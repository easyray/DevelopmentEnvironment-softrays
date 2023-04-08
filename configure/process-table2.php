<?php
/****


http://localhost/php-mvc-IDE/configure/process-table.php
 Array
(
    [tablename] => categories
    [root-folder] => C:/xampp/htdocs/hillcity-test-portal/admin/forbidden/db_connect.php
)

/****
echo'<pre>';
	print_r ($_POST);
echo '</pre>';
die;
/***/
//echo json_encode($_POST); die;
if (is_dir($_POST['root-folder'].'/admin')){
	include $_POST['root-folder'].'/admin/forbidden/db_connect.php';
}else{
	include $_POST['root-folder'].'/forbidden/db_connect.php';
}


	$query = "SELECT * FROM sqlite_master WHERE name = ?";
	$pds = $PDO->prepare($query);
	$pds->execute( array($_POST['tablename'])   );
	$Stuffs =  $pds->fetchAll(2);
	$CreateQuery = $Stuffs[0]['sql'];

	$CreateQuery = str_replace("\r\n", ' ' , $CreateQuery);
	$CreateQuery = str_replace("\n", ' ' , $CreateQuery);
	
	//echo $CreateQuery; die;

	$letters             = '[A-Za-z_]+';
	$s1                  = '\s*';
	$s2                  = '\s+';
	$name                = "($letters|\\(\\s*$letters\\s*\\)|\"$letters\"|\\(\\s*\"$letters\"\\s*\\)|'$letters'|\\('$letters'\\))";
	$column_name = "($name)";


	$res  = array();
	
	preg_match_all("/(CREATE\\s+TABLE\\s+$name\\s*\\(\\s*)(.*)/", $CreateQuery,$res);


	$column_def_1   = "($name($s2$name)+)";
	$column_def_2   = "($name\\s+$name\\($s1\\d+$s1\\)($s2$name)*)";

	$column_def     = "($column_def_2|$column_def_1)";
	
	$SQLStructure  = "/$column_def/";
	
	$res2= array();
	
	preg_match_all($SQLStructure, $res[3][0],$res2);


	$outcome = array();
	foreach ($res2[3] AS $key => $value) {
		if($value !=""){
			$outcome[]= enQuote($_POST['tablename'].'.'.deQuote($value));
		}else{
			$outcome[]= enQuote($_POST['tablename'].'.'.deQuote($res2[8][$key]));
		}
	}//fore

	//pretty_r($outcome);

	echo json_encode($outcome);




function enQuote($str){

	if($str[0] == "'"){
		$str = substr($str, 1, strlen($str)-2);
	}

	if($str[0]=='"'){
		return $str;
	}else{
		return '"'.$str.'"';
	}
}

function deQuote($str){

	if(
		$str[0] == "'" ||
		$str[0] == '"'
	){
		$str = substr($str, 1, strlen($str)-2);
	}

	return $str;
}
?>