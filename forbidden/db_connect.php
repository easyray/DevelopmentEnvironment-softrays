<?php
include __DIR__."/config.php";

$Loc =  $_SERVER['DOCUMENT_ROOT'];
$Loc = str_replace("\\" ,"/", $Loc);
define("SITE_FOLDER", "$Loc/".RELATIVE_FOLDER);
define('SITE_ROOT_FOLDER', SITE_FOLDER);
define('DOWNLOAD_FOLDER' ,$Loc.'/'.RELATIVE_FOLDER.'/downloads');

define('SITE_PATH','/'.RELATIVE_FOLDER);
define('DOWNLOAD_PATH'   , '/'.RELATIVE_FOLDER.'/downloads'  );


define('DATABASE_FILE', SITE_FOLDER."/forbs/".DATA_FILE);
//=========================================

$host = 'localhost';
$db   = 'db-name.sqlite';
$user = 'root';
$password = 'S@cr@t1!';

$dsn = "sqlite:".DATABASE_FILE; 
/*$dsn = "mysql:host=;dbname=;charset=UTF8";*/

try {
	$pdo = new PDO($dsn, $user, $password);

} catch (PDOException ) {
	echo $e->getMessage();
}



function convertURL($stuff){

	if(
		strstr(SITE_FOLDER,"storage/sdcard0") ||
		strstr(SITE_FOLDER,"sdcard")
	){
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

function verifyPOST($index){
		$Old = json_decode( file_get_contents(SITE_ROOT_FOLDER."/../debug/debug.json"));

		$Stuff = $Old[$index];
		foreach($Stuff as $Key=>$Value){
			if(!isset($_POST[$Key])){ return false; }
		}
		return true;
}