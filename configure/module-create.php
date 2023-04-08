<?php
/*
"module":Module,
"section": Section,
"content": Content
"site-folder":.....
*/


$Module = $_POST['module'];

$DstFile = $_POST["site-folder"]."/modules/$Module/$Module.php";
$DstFile = str_replace("\\", "/", $DstFile);

echo $DstFile;

if(!is_dir(dirname($DstFile))){
	mkdir(dirname($DstFile));
}

file_put_contents($DstFile, $_POST['content']);
//echo json_encode($_POST); die;

$Existing = objToArray(json_decode(file_get_contents($_POST["site-folder"]."/configure/section-module.json")));

$Existing[$_POST['section']] = $Module;

file_put_contents(
	$_POST["site-folder"]."/configure/section-module.json",  
	json_encode($Existing)
);


//==================================================================
function objToArray($Obj){
	$ret = array();
	foreach($Obj AS $Key=> $Value){
		if(gettype($Value)	=="object"){
			$ret[$Key]= objToArray($Value);
		}else{
			$ret[$Key]= $Value;
		}
	}//end foreach
	
	return $ret;
}
