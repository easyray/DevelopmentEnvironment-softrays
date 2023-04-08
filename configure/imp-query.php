<?php
global $PDO; 
$query = "SELECT *
 FROM lesson 
WHERE specific_subject= ? ";
$pds = $PDO->prepare($query); 
$pds->execute(/****/ array(
$1) ); 

$R = $pds->fetchAll(2); 
return $R;
 ?>