<?php

	$PO =  file_get_contents($_POST['filename']);

	$res = array();
	$POArray = preg_match_all('/<%[\w-]+%>/', $PO, $res);

	$PP =  array_unique($res[0]);
	$P  = array();
	
	foreach ($PP as  $value) {
		$P[] = $value;
	}
	
	if(
		isset($_POST["task"]) &&
		"create-template" == $_POST["task"] 
	){
		$Code  = file_get_contents($_POST['filename']);
		
		foreach ($_POST["replace"] as $key => $value) {
			$_POST["replace"][$key] = '<?php 
	$R = route($PageName, "'.$value.'");
	foreach ($R as $key => $value) {
	include($value);
}
?>';
		}

		$Code = str_replace($_POST["pattern"], $_POST["replace"], $Code);

		file_put_contents($_POST["filename"], $Code);
			
	}

	include "functions.php";
	$sections  =simplexml_load_string(file_get_contents($_POST['site-folder']."/configure/sections.xml"));

	$sections = getArrayFrom($sections->section);
	
	$DDSTR ='<select name="replace[]" >';
	foreach ($sections as $Key => $Value) {
		$DDSTR .='<option>'.$Value.'</option>';
	}
	$DDSTR .='</select>';



?><!DOCTYPE html>
<html>
<head>
	<title>Template</title>
</head>
<body>
<form  method ="post">
	<table border="1" cellspacing="0">
		<tbody>
		<tr>
			<td>Pattern</td>
			<td>Variable Name</td>
		</tr>
			<?php  foreach( $P AS $V ) { ?>
			<tr>
			<td><?php echo  $V; ?></td>
			<td>
				<!--<input name="replace[]" type="text" />-->
				<?php echo $DDSTR; ?>
				<input name="pattern[]" type="hidden" value="<?php echo  $V; ?>" />
			</td>
			</tr>
			<?php  }  ?>
		</tbody>
	</table>

	<input type="submit" value = "   Go!!!  " />
	<input type="hidden" name="filename" value="<?php echo $_POST['filename']; ?>" />
	<input type="hidden" name = "site-folder" value= "<?php echo $_POST['site-folder']; ?>" />
	<input type="hidden" name="task" value="create-template" />
</form>

</body>
</html>