<?php
include __DIR__."/config.php";
// Some server variables are missing on the tab
	if(!isset($_SERVER['REQUEST_SCHEME'])){
		$_SERVER['REQUEST_SCHEME'] = 'http';
	}


	if(!isset($_SERVER['DOCUMENT_ROOT'])){
		$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(dirname(__DIR__)));
	}

   if(!isset($_SERVER['REQUEST_URI'])){
	
		$_SERVER['REQUEST_URI'] = 
		$_SERVER['SERVER_URL'].$_SERVER['SCRIPT_NAME'];
		
		if($_SERVER['QUERY_STRING'] !=''){
			$_SERVER['REQUEST_URI'] .= '?'.$_SERVER['QUERY_STRING'];
		}
	}

	if(!isset($_SERVER['HTTP_HOST'])){
		$_SERVER['HTTP_HOST']='localhost';
	}
//=========================================================

	$Loc =  $_SERVER['DOCUMENT_ROOT'];
	$Loc = str_replace("\\" ,"/", $Loc);
	
	$_FOLDER =substract($_SERVER['DOCUMENT_ROOT'], dirname(dirname(__DIR__)));
	
	define("SITE_FOLDER", "$Loc$_FOLDER");

	define(
		'SITE_PATH',
		$_SERVER['REQUEST_SCHEME'].'://'.
		$_SERVER['HTTP_HOST']."$_FOLDER"
	);


	define('DOWNLOAD_FOLDER' ,SITE_FOLDER.'/downloads');
	define('DOWNLOAD_PATH'   ,SITE_PATH.  '/downloads');	


	define('SITE_ROOT_FOLDER', SITE_FOLDER);
	define('DATABASE_FILE', SITE_FOLDER."/admin/forbidden/".DATA_FILE);
//=========================================

//database connection
	/*** mysql hostname ***/
	$hostname = 'localhost';

	/***database     ******/
	$dbname   = "kwara_affair";
	$username  = 'root';


	/*** mysql password ***/
	$password  = '';

try {
		$PDO = new PDO(
			"sqlite:".DATABASE_FILE
		);
}catch(PDOException $e){
	echo "database connection error<br />";
	echo $e->getMessage();
}


function convertURL($stuff){

	if(strstr(SITE_FOLDER,"storage/sdcard0")){
		if(strstr($stuff,"?")){
			$stuff = str_replace('?', '&', $stuff);
			return "index.php?p=$stuff";
		}else{
			return "index.php?p=$stuff";
		}
	}else{
		return $stuff;
	}
}

//Debug functions

function pretty_r($stuff){
	echo "<pre>";
	print_r($stuff);
	echo "</pre>";
}

function showPrepedQuery ($query, $stuff){

	echo getPrepedQuery ($query, $stuff);
	echo " <br />\n";
}	

function getPrepedQuery ($query, $stuff){

	$q = explode("?", $query);

	$k =0;
	foreach ($stuff as $key => $value) {
		
		$stuff[$key] = escape_sql($value);
		
		$q[$k] .= '?';
		$q[$k] = str_replace('?', " '".$stuff[$key]."' ", $q[$k]);
		$k++;
	}

	return implode("", $q);
}	

function escape_sql($str) {

    $search = array("\\",  "\x00", "\n",  "\r",  "'", "\x1a");
    $replace = array("\\\\","\\0","\\n", "\\r", "\'", "\\Z");

    $ret = str_replace($search, $replace, $str);
    
    return $ret;
}

function file_log($stuff){
	$fil = fopen(DOWNLOAD_FOLDER."/log.log","at");
	fwrite($fil,$stuff."\n");
	fclose($fil);
}

	function capturePOST1($Filename){
		$src = file_get_contents($Filename);
		$stuff = ''.json_encode($_POST).'';
		
		$src =str_replace(
			'<?php capturePOST1(__FILE__); ?>', 
			"$stuff", 
			$src
		);
		
		file_put_contents($Filename, $src); die;
	}
	
	function capturePOST($Filename){
		$src = file_get_contents($Filename);
		$stuff = '/*'.print_r($_POST,true).json_encode($_POST).'*/';
		$src =str_replace("capturePOST", "$stuff\n//", $src);
		file_put_contents($Filename, $src); die;
	}
function verifyPOST($index){
		$Old = json_decode( file_get_contents(SITE_ROOT_FOLDER."/../debug/debug.json"));

		$Stuff = $Old[$index];
		foreach($Stuff as $Key=>$Value){
			if(!isset($_POST[$Key])){ return false; }
		}
		return true;
}
//------------------------------------------------
function substract($str, $frmStr){
 return str_replace("\\", "/", substr($frmStr,strlen($str)));
}
