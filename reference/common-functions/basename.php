<?php
$path = "/testweb/home.php";

//Show filename
echo basename($path) ."<br/>";

//Show filename, but cut off file extension for ".php" files
echo basename($path,".php");
?>