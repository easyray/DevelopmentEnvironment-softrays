<!DOCTYPE html>
<html>
<head>
	<title>Page Flow</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <div id="container">
	    <div id="my-logo"><img src="pix/logo.png" /> </div>
		<?php include("menu.php"); ?>
	    <div id="our-slide-show">

			<h3>Root Folder</h3>
			<form method="post">
				<input type="text" style="width:350px; height:25px" name="filename" value="<?php echo SITE_FOLDER; ?>" /><input type="submit" value="Open" />
				<input type="hidden" name="task" value="show-folder-2">
			</form>    

			<div>
				<br />
				<h1>Modules</h1>
				<?php
					include "functions.php";
					$Modules = simplexml_load_string(file_get_contents("modules.xml"));
					$Modules = getArrayFrom($Modules);
				?>
				<form method="post">
					<?php 
					$Select = '<select name="filename" >';
					foreach($Modules AS $Val){ 
						$Select .= '<option value="'.SITE_FOLDER."/modules/$Val".'" >'.$Val.'</option>';
					}

					echo $Select;
					?>
					<input type="hidden" name="task" value="show-folder-2">
					<input type="submit" value="     Go     " />
				</form>
<?php

if(isset($_POST['task']) && $_POST['task']=='show-folder-2' ){

	if(is_file($_POST['filename'])){
		showFunctions($_POST['filename']);
	}else if(is_dir($_POST['filename'])){
		showAFolder(($_POST['filename']));
	}

}
?>				
			</div>
		</div>
	</div>
</body>
</html>

<?php

	function showFunctions($File){

		$str = file_get_contents($File);
		$res = array();
		$Search = '/function\s*(\w+\s*\((\s*\$\w+)?(\s*,\s*\$\w+)*\s*\))/';
		preg_match_all($Search, $str, $res);

		echo '<textarea cols= "80" rows="25">';
		foreach ($res[1] as $key => $value) {
			# code...
			echo "$value \n ";
		}
		echo '</textarea>';
	}

	function showAFolder($Dir){

		$List = scandir($Dir);

	 	echo "<ul>";

	 	foreach($List AS $Value){
	 		if($Value !="." && $Value !=".."){
		 		if(!is_dir("$Dir/$Value")){
		 			$path_value = substr("$Dir/$Value", strlen($_SERVER['DOCUMENT_ROOT']));
		 			echo '<li><input value="'.$_SERVER['HTTP_HOST'].SITE_PATH."".$path_value.'" />
			 			'."$Dir/$Value".'
			 			<form method="post" >
			 			<input type="hidden" name="filename" value="'."$Dir/$Value".'"/>
			 			<input type="submit" value="open" />
			 			<input type="hidden" name="task" value="show-folder-2">
			 			</form>	</li>';
			 	}else{
			 		$path_value = substr("$Dir/$Value", strlen(SITE_FOLDER)+1);
			 		echo '<form method="post"><li>Folder: '.$path_value.'</li>'.
			 		'<input  value="'."$Dir/$Value/".'" name="filename"/>
			 		<input type="hidden" name = "task" value="show-folder-2" />
			 		<input type="submit" value="open"></form>';
			 	}
		 	}
		}
		 	
		echo '</ul>';

	}
?>