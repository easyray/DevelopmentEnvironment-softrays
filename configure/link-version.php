<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php 
if( 
 	isset($_POST["task"]) &&
	"change-version" == $_POST["task"]
){

	if( is_file($_POST["filename"])	){

		$Src = file_get_contents($_POST["filename"]);
		$res = array();
		$DD = array();
		$QQ = array();
		
		foreach ($_POST['src'] as $key => $value) {
				# code...
			
			$_POST['src'][$key] = str_replace("/", "\\/", $_POST['src'][$key]);
			$_POST['src'][$key] = str_replace("?", "\\?", $_POST['src'][$key]);
			$_POST['src'][$key] = str_replace(".", "\\.", $_POST['src'][$key]);

			$GG = '/\<link\b[^>]*href ?= ?"'.$_POST['src'][$key].'"[^>]*\/?>/';

			preg_match_all($GG, $Src, $res);

			$DD[]= $res[0][0];
			$M = parse_url($value);
			$QQ[]= $M['path'];
		}

		foreach ($DD as $key => $value) {
			# code...
			$Src = str_replace($value, '<link rel="stylesheet" href ="'.$QQ[$key].
				(("" !=$_POST['query'][$key])?'?'.$_POST['query'][$key]:"").
				'" >', $Src);
		}


		file_put_contents($_POST["filename"],$Src );
	}	


}

if( is_file($_POST["filename"])	){

	$Src = file_get_contents($_POST["filename"]);
	$res = array();
	preg_match_all('/\<link\b([^>]*)\/?>/', $Src, $res);



	$AllSrc = array();
	foreach ($res[1] as $key => $value) {
		# code...
		$res2 =	array();
		preg_match_all('/href ?= ?"([^"]+)"/', $value,$res2);

		if( isset($res2[1][0]) ){
			$AllSrc[] =array('string'=>"&lt;link $value \/&gt;", "src"=> $res2[1][0]);
		}
	}

	foreach ($AllSrc as $key => $value) {
		# code...
		$_Value = parse_url($value['src']);

		if( isset($_Value["query"]) ){
			$query = $_Value["query"];
		}else{
			$query ="";
		}
		$AllSrc[$key]['query'] = $query;
	}
	
}
	?>
<form method="post" >
<table border="1" cellspacing="0">
	<tbody>
	<tr>
	<td>SN</td>
	<td>Script</td>
	<td>Src</td>
	<td>Query</td>
	</tr>
	<?php $SN = 1; ?>
	<?php foreach($AllSrc AS $Key=> $stuff): ?>
	<tr>
		<td><?php echo $SN++; ?></td>
		<td><?php echo $stuff['string']; ?></td>
		<td>
			<?php echo $stuff['src']; ?>
			<input name="src[]" type="hidden" value="<?php echo $stuff['src']; ?>" />		
		</td>
		<td>
			<input name="query[]" type="text" value="<?php echo $stuff['query']; ?>" />
		</td>
	</tr>
	<?php endforeach;  ?>
	</tbody>
</table>
<input type="hidden" name="filename" value="<?php echo  $_POST['filename'] ; ?>"  />
<input type="hidden" value="change-version" name="task">
<input type="submit" value="     Change     " />
</form>
</body>
</html>