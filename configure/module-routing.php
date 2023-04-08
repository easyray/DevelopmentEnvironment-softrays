<?php
	
	if( 
	 	isset($_POST["task"]) &&
		"route.save" == $_POST["task"]
	){
		file_put_contents(
			$_POST['root-folder']."/configure/module-routing.json", 
			$_POST['routing-json']
		);
	}


	if( 
	 	isset($_REQUEST["root-folder"])
	){
		$Folder = $_REQUEST["root-folder"].'/';
	}else{
		$Folder = '';
	}

	if(is_file($Folder."configure/module-routing.json")){
		$Route = (array) json_decode(file_get_contents($Folder."configure/module-routing.json"));
	}else{
		$Route = array();
	}
	
	
	include ("functions.php");
	
    
	if (isset($_POST['task']) && $_POST['task']== 'add'  ){
		if(!isset($Route[ $_POST['i_sections'] ])){
			$Route[ $_POST['i_sections'] ] = array( );		
		}
		$Route[ $_POST['i_sections'] ] = get_ArrayFrom( $Route[ $_POST['i_sections'] ]);
		$Route[ $_POST['i_sections'] ][] = array($_POST['i_url'] => $_POST['i_modules']);
		file_put_contents($Folder."configure/module-routing.json",json_encode($Route));
	}else 	if (
		isset($_POST['task']) && 
		$_POST['task']== 'remove'  
	){
		
		if(isset($Route[ $_POST['i_sections'] ])) {
 			$Route[ $_POST['i_sections'] ] = get_ArrayFrom( $Route[ $_POST['i_sections'] ]);
 			$Len = sizeof($Route[ $_POST['i_sections'] ]);

			foreach( $Route[ $_POST['i_sections'] ] AS $C=>$Val){
				if(
					getKey($Val)   == $_POST['i_url'] &&
					getValue($Val) == $_POST['i_modules'] ){
					unset($Route[ $_POST['i_sections'] ][$C]);
					if(
						0== sizeof(
							$Route[ $_POST['i_sections'] ]
						)
					){
						unset(
							$Route[ $_POST['i_sections'] ]
						);
					}
					break;
				}
			}//next

			file_put_contents($Folder."configure/module-routing.json",json_encode($Route));
		}
	}else if(isset($_POST['task']) && $_POST['task']== 'reset'){
		file_put_contents($Folder."configure/module-routing.json",'{}');
	}//end if
	
	$Urls  =simplexml_load_string(file_get_contents($Folder."configure/urls.xml"));
	$Urls  = getArrayFrom($Urls->url);
	
	$sections  =simplexml_load_string(file_get_contents($Folder."configure/sections.xml"));
	$sections  = getArrayFrom($sections->section);
	
	$Modules   =simplexml_load_string(file_get_contents($Folder."configure/modules.xml"));
	$Modules  = getArrayFrom($Modules->module);
	

//***************************************
	if( 
	 	isset($_POST["task"]) &&
		"routing.detect" == $_POST["task"]
	){

		// get the list of sections
		$Sections =simplexml_load_string(file_get_contents($_POST['root-folder']."/configure/sections.xml"));
		$Sections =  getArrayFrom($Sections->section);

		// get the list of urls
		$URLs =simplexml_load_string(file_get_contents($_POST['root-folder']."/configure/urls.xml"));
		$URLs =  getArrayFrom($URLs->url);
		//locate the router
		define('_JEXEC',1);
		include $_POST['root-folder']."/router.php";

		//choose an improbable pagename
		$PageName = 'subliminal-section-ur@321';
		//loop through		
		//And fill dictionary
		$SectionModuleDictionary = [];
		foreach ($Sections as $key => $Section) {
			$SectionModuleDictionary[$Section]=
			route($PageName,$Section);
		}

		$SpecificRouteDic = [];

		foreach ($URLs AS $PageName) {			
			foreach ($Sections as $key => $Section) {
				if(
					!same_array(
						$SectionModuleDictionary[$Section],
						($R = route($PageName,$Section))
					)
				){
					$SpecificRouteDic[$Section][]= collect($PageName,$R);
				}
			}
		}
	}
 ?><!DOCTYPE html>
<html>
<head>
	<title>Module-routing</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <div id="container">
        
        <div id="my-logo"><img src="pix/logo.png" /> </div>
		<?php include("menu.php"); ?>
		
        <div id="our-slide-show">
		<h2> Module Routing</h2>
			
<form  method ="post" >
<table class="t-colapse" border="1" cellspacing="0" cellpadding="5">
<tbody>
<tr>
<th>Section</th>
<th>URL</th>
<th>Module</th>
</tr>
<tr>
<td><?php echo tempList($sections,"cls-sections","",$Name="i_sections") ; ?></td>
<td><?php echo tempList($Urls,"cls-url","","i_url"); ?></td>
<td><?php echo tempList($Modules,"cls-modules","","i_modules"); ?></td>
</tr>
</tbody>
</table>			
<div style="padding-top: 20px; padding-bottom: 50px " >
<input type="submit" value= "   add   " />
<input type="hidden" value="add" name="task"  />
<input type="hidden" name="root-folder" value="<?php echo  $_REQUEST['root-folder'] ; ?>" />
</div>
</form>		

<table class="t-colapse" border="1" cellspacing="0" cellpadding="5">
<tbody>
<tr>
<th>URL</th>
<th>Section</th>
<th>Module</th>
<th>&nbsp;</th>
</tr>
<?php foreach($Route AS $Key => $Value ) { ?>
<?php foreach($Value AS $Ke2 => $Val ) { ?>
<tr>
<td><?php echo getKey($Val) ; ?></td>
<td><?php echo $Key; ?></td>
<td><?php echo getValue($Val); ?></td>
<td>
<form method="post">
	<input type="submit" value= "remove" />
	<input type="hidden" value="<?php echo getKey($Val); ?>" name = "i_url">
	<input type="hidden" value="<?php echo $Key; ?>" name = "i_sections">
	<input type="hidden" value="<?php echo getValue($Val); ?>" name = "i_modules">
	<input type="hidden" value="remove" name = "task">
	<input type="hidden" name="root-folder" value="<?php echo  $_REQUEST['root-folder'] ; ?>" />
</form>
</td>
</tr>
<?php  }  ?>
<?php  }  ?>
</tbody>
</table>

<form method="post">
	<input type="hidden" name="task" value="reset" />
	<input type="submit" value="reset" />
	<input type="hidden" name="root-folder" value="<?php echo  $_REQUEST['root-folder'] ; ?>" />
</form>
<form method="post">
	<input type="hidden" name="task" value="routing.detect" />
	<input type="submit" value="detect routing" style="height: 30px;border-radius: 5px" />
	<input type="hidden" name="root-folder" value="<?php echo  $_REQUEST['root-folder'] ; ?>" />
</form>
<form method="post" >
	<textarea rows="15" cols="25" name="routing-json" ><?php 
	if (isset($SpecificRouteDic)){
		echo json_encode($SpecificRouteDic);
	}
	?></textarea><br />
	
	<input type="submit" value="Save Routing Json" style="height: 30px; border-radius:5px" />
	<input type="hidden" name="root-folder" value="<?php echo  $_REQUEST['root-folder'] ; ?>" />
	<input type="hidden" name="task" value="route.save" />
</form>
</div>
</div>

</body>
</html><?php
function same_array($array1,$array2){
	if(sizeof($array1) != sizeof($array2)){
		return 0;
	}

	foreach ($array2 as  $value) {
		if(!in_array($value, $array1)){
			return 0;
		}
	}

	return 1;
}

function collect($key,$container){
	return array($key=>explode('/', $container[0])[1]);
}
?>