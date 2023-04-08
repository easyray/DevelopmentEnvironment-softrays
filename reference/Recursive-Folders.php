<?php
function createFolderChain($Chain){

	$Chain = str_replace("\\", "/", $Chain);
	
	$Chain = explode("/",$Chain);
	$Dst = "";
	foreach($Chain AS $Value){
		$Dst .="$Value/";
		if(! is_dir($Dst)){
			mkdir($Dst);
		}
	}
}
//---------------------------------------------------

function getFilesRecursive($path){
	$path =str_replace("/", "\\", $path);
	$Kollection= scandir($path);

	$List = [];
	foreach ($Kollection as $key => $value) {
		# code...
		if(
			'..' != $value &&
			'.' != $value 
		){
			if(is_file("$path\\$value")){
				$List[] = "$path\\$value";
			}elseif(is_dir("$path\\$value")){
				$List[] = getFilesRecursive("$path\\$value");
			}
		}
	}//endforeach;

	return implode("\r\n", $List);
}
//---------------------------------------------------