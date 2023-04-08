<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    if( isset($_REQUEST["root-folder"]) ){
        $Folder = $_REQUEST["root-folder"].'/';
    }else{
	   $Folder = "";
    }

    $Folder_ = $Folder;
	if(! function_exists("pretty_r")){
		include "$Folder_"."forbidden/db_connect.php";
	}


	if(!isset($_SERVER['SERVER_URL'])){
		$_SERVER['SERVER_URL'] = $_SERVER['REQUEST_SCHEME']."://".$_SERVER["HTTP_HOST"].$_SERVER['SCRIPT_NAME'];
	}

	if(
		isset($_POST["task"]) &&
		(
			$_POST["task"] =="show-folder-2" ||
			$_POST["task"] =="show-folder"
		)
	){
	
		if(! function_exists("pretty_r")){
			include "$Folder"."forbidden/db_connect.php";
		}
		
		include "filemanager.php";
		die;
	}

?><!DOCTYPE html>
<html>
<head>
	<title>Page Flow</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <div id="container">
    <div id="my-logo"><img src="pix/logo.png" /> </div>
	<?php include("menu.php"); ?>

<?php
	include ("functions.php");
	$Urls      =simplexml_load_string(file_get_contents($Folder_."configure/urls.xml"));
	$Urls = getArrayFrom($Urls->url);
	
	if(isset($_POST['url'])){
		$Url = $_POST['url'];
	}else{
		$Url = "index.php";
		$_POST['url'] = $Url ;	
	}
	
	function doRouting($Route, $Key, $Url){

			/*
		
			$Url is the  url value selected on the page flow
Sample Routing  object
Array
(
    [main-content] => Array
        (
            [0] => stdClass Object
                (
                    [manage-pane-menu.html] => pane_menu
                )

        )

    [footer] => Array
        (
            [0] => stdClass Object
                (
                    [experiment1.html] => footer
                )

            [1] => stdClass Object
                (
                    [experiment2.html] => footer
                )

            [2] => stdClass Object
                (
                    [index.php] => footer
                )

        )

)	
main-content/ footer => $Key		
			
			*/
				$RouteCode2 ='';

				foreach($Route[$Key] AS $Ke2 => $Val ) { //the array under route key  pick an item

					if($Url == getKey($Val)){  // each item has key= url,  value =  module

						$RouteCode2 .=
						''.getValue($Val).'/'.getValue($Val).'.php
			<form method="post" style="float:left">
			<!--<input type="submit" value = "open" />-->
			<input type="hidden" value="show-folder-2" name="task"  />
			<input type="hidden" name ="filename" value = "'.SITE_FOLDER.
			'/modules/'.getValue($Val).'/'.getValue($Val).'.php" />						
			</form>';

					}////////
				}// end for
		return $RouteCode2 ;
	}
	

	
	if(is_file($Folder_."configure/module-routing.json")){
		
		$Route = (array) json_decode(file_get_contents($Folder_."configure/module-routing.json"));

		$Default = (array) json_decode(file_get_contents($Folder_."configure/section-module.json"));
		
		$RouteCode ='<table border="1" cellspacing="0">';	
	 	
		foreach($Default AS $Key=>$Value){
			$RouteCode2 ='';
			$RouteCode  .= '<tr><td style="text-align:right; padding-right:10px">'.$Key.'  :  </td><td>';
			if(
				isset($Route[$Key])    && 
				is_array($Route[$Key]) 
				){
					
					$RouteCode2  = doRouting($Route, $Key, $Url);
					if($RouteCode2 != ''){
						$RouteCode .= $RouteCode2;
					}else{ 
						$RouteCode .=doDefault($Default, $Key);
					}
			}else{
						$RouteCode .=doDefault($Default, $Key);
			}// end if	
			
			$RouteCode .='</td></tr>';
		}
		$RouteCode .='</table>';
	}

	if(is_file("plugins.xml")){
		$Plugins = simplexml_load_string(file_get_contents("plugins.xml"));

		$Plugins = getArrayFrom($Plugins->plugin);
	}else{
		$Plugins = array();
	}


?>

    <div id="our-slide-show">

		<h3>Root Folder</h3>
		<form method="post">
			<input type="text" style="width:350px; height:25px" name="filename" value="<?php echo SITE_FOLDER; ?>" /><input type="submit" value="Open" />




			<input type="hidden" name="task" value="show-folder-2">
			<input type="hidden" name="root-folder" value="<?php echo  $_REQUEST['root-folder'] ; ?>" />
		</form>

		<h1>URLs</h1>
		<form method="post">
			<?php 
			$Select = '<select name="url" >';
			foreach($Urls AS $Val){ 
				$Selected =  ($_POST['url'] == $Val)? 'selected' : '';
				$Select .= '<option value="'.$Val.'" '.$Selected.'  >'.$Val.'</option>';
			}

			echo $Select;
			?>
			<input type="submit" value="     Go     " />
			</form>
			<div>
			<br />

<?php
 echo $RouteCode; 
 ?>
			<h2>Plugins</h2>
			<table  cellspacing="0" cellpadding="5">
			<tbody>
			<?php foreach ($Plugins AS $Key=> $Value){ ?>
			<tr>
			<td style="text-align:right; padding-right:10px">
				<?php echo $Value; ?>
			</td>
			<td>
&nbsp;
			</td>
			<td>
			<?php echo  $Value.'/'.$Value.'.php'; ?>
			</td>
			<td>
			<form  method="post">
				<input type="submit" value = "edit" />
				<input type="hidden" name ="filename" value = "<?php echo  SITE_FOLDER.'/plugins/'.$Value.'/'.$Value.'.php'; ?>" />
				<input type="hidden" value="show-folder-2"  name="task" />
			</form>
			</td>			
			</tr>
			<?php } ?>			
			</tbody>
			</table>
</div>
			

<div style="border: thin solid #aaa; padding: 30px;  margin: 10px">
	<strong>Folder Structure</strong>
	<form id="form1" name="form1" method="post" >
	  <input type="text" name="filename" id="filename" value="/storage/sdcard0/paw/html/editor/opener.txt" />
	</form>
</div>

</div>
			</div>
			
			</div>
</body>
</html><?php
	function doDefault($Default, $Key){
/*
			The Default obje is like
Array
(
    [footer] => footer
    [page-title] => title
    [css] => css
    [shared_objects] => shared_objects
    [menu] => menu
    [main-content] => login
    [hidden] => empty
    [top_navbar] => top_navbar
    [crumbs] => empty
    [debug] => debug
    [status_module] => status_module
)			
where page-title, css,... => $key (and they are section names)
thier value are the modules (default modules)
		*/
			
			$RouteCode = 
			$Default[$Key].'/'.$Default[$Key].'.php
		<form method="post" style="float: left">
			<!--<input type="submit" value = "open" />-->
			<input type="hidden" value="show-folder-2" name="task" />
			<input type="hidden" name ="filename" value = "'.SITE_FOLDER.
			'/modules/'.$Default[$Key].'/'.$Default[$Key].'.php" />						
		</form>	<br />';				
		
		return $RouteCode ;
	}