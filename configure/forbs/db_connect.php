<?php
include dirname(__FILE__)."/config.php";

	$Loc =  $_SERVER['DOCUMENT_ROOT'];
	$Loc = str_replace("\\" ,"/", $Loc);
	
	if(
		strstr($_SERVER['DOCUMENT_ROOT'], "sdcard") ||
		strstr($_SERVER['DOCUMENT_ROOT'], "xampp")   
	){
		define("SITE_FOLDER", "$Loc/".RELATIVE_FOLDER);	
		define('SITE_PATH','/'.RELATIVE_FOLDER);
	}else{
		define("SITE_FOLDER", "$Loc");		
		define('SITE_PATH','/');
	}

	define('DATABASE_FILE', SITE_FOLDER."/admin/forbs/".DATA_FILE);

//=========================================

//database connection
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
	echo "<br >\r\n";
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
	$fil = fopen(SITE_FOLDER."/log.log","at");
	fwrite($fil,$stuff."\n");
	fclose($fil);
}

function substract($str, $frmStr){
 return str_replace("\\", "/", substr($frmStr,strlen($str)));
}
