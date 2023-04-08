<?php
if( 
 	isset($_POST["task"]) &&
	"save-section" == $_POST["task"]
){
	$Puppy = '<?xml version="1.0" encoding="UTF-8"?>'."\n<sections>\n";
	$Templ_Data =[];
	foreach ($_POST['sectionName'] as $Sec_key => $section) {
		if("" != trim($section)){
			$Puppy .= '	<section>'.$section.'</section>'."\n";

			$Templ_Data[] =
			[
				$_POST["sectionIds[]"][$Sec_key],
				$section,
				$_POST["moduleName[]"][$Sec_key]
			];
		}
	}

	$Puppy .='</sections>';

	if(isset($_POST['admin']) && "" != trim($_POST['admin']) ){
		$Dst = $_POST['site-folder'].'/admin/configure/sections.xml';
	}else{
		$Dst = $_POST['site-folder'].'/configure/sections.xml';
	}

	file_put_contents($Dst, $Puppy);
	
	$Templ_Data_2 = [];
	
	$Templ_Data_2[0] = $Templ_Data;
	$Templ_Data_2[1] = $_POST['site-folder'];
	$Templ_Data_2[2] = $_POST['admin'];

	file_put_contents(__DIR__."/TemplateData.txt", $Templ_Data_2);

echo '<form method="post"  action="save-extract-tempate.php" >
	<input type="submit"  value="Save Template" />
</form>';

die("dusted");
}
	$Sections = explode(",", $_POST['sections']);
	$SN =1;
?><!DOCTYPE html>
<html>
<head>
	<title>Use</title>
</head>
<body>
<form method="post">
	<table border="1" style="border-collapse: collapse;">
		<tbody>
		<tr>
			<td>SN</td>
			<td>Element</td>
			<td>Section-name</td>
			<td>Dst-Module</td>
		</tr>
		<?php foreach($Sections AS $section): ?>
		<tr>
			<td><?php echo $SN++; ?></td>
			<td><?php echo $section; ?><input type="hidden" name="sectionIds[]" value="<?php echo  $section ; ?>" /></td>
			<td><input name="sectionName[]" type="text"  /></td>
			<td><input name="moduleName[]" type="text" value="_def_<?php echo  $section ; ?>_module" /></td>
		</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<input type="hidden" name="site-folder" value="<?php
		if($_POST['site-folder']){
			echo $_POST['site-folder'];
		}/*else*/  
	?>" />
	<input type="hidden" name="admin" value="<?php
		if(isset($_POST['admin'])){
			echo $_POST['admin'];
		}/*else*/  
	?>" />

	<input type="hidden" name="task" value="save-section" />
	<input type="submit" value="Save" />

</form>
</body>
</html>