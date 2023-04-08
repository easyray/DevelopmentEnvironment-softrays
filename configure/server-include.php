<?php
if(is_dir("../admin")){
	include "../admin/forbidden/db_connect.php";
}else{
	include "../forbidden/db_connect.php";
}
if (isset($_POST['task']) && $_POST['task']=="add-include"){
	$Source = file_get_contents($_POST['source']);
	$Source .= 'include "'.$_POST['destination'].'"; ';
	file_put_contents( $_POST['source'], $Source);
}
?><!DOCTYPE html>
<html>
<head>
	<title>Server include</title>
    <link rel="stylesheet" href="css/style.css" />
   <!-- - <script src="jquery-1.9.1.js"></script>
    <script src = "ListViewII.js" ></script>-->
</head>
<body>
<div id="container">
    <div id="my-logo"><img src="pix/logo.png" /> </div>

    <div id="our-slide-show">
<?php 
	if(!isset($_SERVER['SERVER_URL'])){
		$_SERVER['SERVER_URL'] = $_SERVER['REQUEST_SCHEME']."://".$_SERVER["HTTP_HOST"].$_SERVER['SCRIPT_NAME'];
	}			
?>



<form method="post">
<h3>Source File</h3>
<?php
$G = createStructure(dirname($_POST['rotfolder']));
		echo '<select name="source" >'.$G.'</select>';
?>
<h3>Script</h3>
<?php 
echo '<select name="destination" >'.$G.'</select>';
?>
<input  type="submit" value="   Add   "/>
<input  name="task" type="hidden" value="add-include" />
<input  name="rotfolder" type="hidden" value="<?php echo $_POST['rotfolder']; ?>" />

</form>
</div>

</div>

<?php  
		

	function createStructure($Dir){
	 	$List = scandir($Dir);
	 	
	 	$Sel = '';
	 	foreach($List AS $Value){
	 		if($Value !="." && $Value !=".."){
		 		if(!is_dir("$Dir/$Value")){
		 			$Path = substr("$Dir/$Value", strlen(SITE_FOLDER)+1);
		 			$Sel .= '<option >'.$Path.'</option>';
		 		}else{
		 			$Sel .= createStructure("$Dir/$Value");
		 		}// end if
	 		}//if($Value != ... )
	 	}//end foreach
	 	
	 	return $Sel;
	}




?>
</div>

</body>
</html>