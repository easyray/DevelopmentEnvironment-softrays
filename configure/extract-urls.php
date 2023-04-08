<?php
/*.
Array
(
    [filename] => C:/xampp/htdocs/front-end
    [site-folder] => C:/xampp/htdocs/front-end
    [task] => show-folder-2
)
*/
//open the index file
$IndexCode = file_get_contents($_POST['site-folder'] ."/index.php");

//extract the cases/ urls
$Cases=[];

 preg_match_all('/case\s+"([^"]+)"/', $IndexCode,$Cases);

saveXML('urls','url', $Cases[1],$_POST['site-folder'] ."/configure/urls.xml");

function saveXML($Root, $ATag, $TagArray,$FileName){

	$Str = '<?xml version="1.0" encoding="UTF-8"?>'."\n<$Root>";
	foreach($TagArray as $Value){
		$Str .="\n\t<$ATag>$Value</$ATag>";
	}
	
	$Str .= "\n</$Root>";
	echo'<pre>';
		print_r ($Str);
	echo '</pre>';
	file_put_contents($FileName,$Str);
}
