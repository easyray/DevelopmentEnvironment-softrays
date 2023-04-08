<?php
$File = 
"C:/xampp/htdocs/school-website-Copy/css/font-awesome.min.css";
$content = file_get_contents($File);
$Mathes = array();
 preg_match_all('/\.(fa-\w+):before/', $content, $Matches); 

	$str = "";
 foreach($Matches[1] AS $match){
	$str .="$match\n";
 }
 file_put_contents("awesome.txt",$str);
 
?>