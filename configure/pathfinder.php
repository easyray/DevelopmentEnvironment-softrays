<?php
	if(!isset($_SERVER['REQUEST_SCHEME'])){
		$_SERVER['REQUEST_SCHEME'] = 'http';
	}


	if(!isset($_SERVER['DOCUMENT_ROOT'])){
		$_SERVER['DOCUMENT_ROOT'] = '/storage/sdcard0/paw/html';
	}

   if(!isset($_SERVER['REQUEST_URI'])){
	
		$_SERVER['REQUEST_URI'] = 
		$_SERVER['SERVER_URL'].$_SERVER['SCRIPT_NAME'];
		
		if($_SERVER['QUERY_STRING'] !=''){
			$_SERVER['REQUEST_URI'] .= '?'.$_SERVER['QUERY_STRING'];
		}
	}
	?><?php
	if( !defined('SITE_FOLDER') ){
		//SITE_FOLDER
		$FullPath = dirname( $_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF']);
		$FullPathArray = explode("/", $FullPath);

		$Len = sizeof($FullPathArray);
		$FullPath = $FullPathArray[0];
		for($i=1; $i< $Len-1; $i++){
			$FullPath .="/".$FullPathArray[$i];
		}
		define('SITE_FOLDER',$FullPath);

	$HttpPath          =  dirname($_SERVER['PHP_SELF']);
	$HttpPathArray = explode("/", $HttpPath);

	$Len          = sizeof($HttpPathArray);
	$HttpPath = $HttpPathArray[0];
	for($i=1; $i< $Len-1; $i++){
		$HttpPath .="/".$HttpPathArray[$i];
	}
	define("SITE_PATH",$HttpPath);
		
	}

/*define('SITE_FOLDER','/storage/sdcard0/paw/html/talented/admin');
define('SITE_PATH'  ,'talented/admin');
*/
?>