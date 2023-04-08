<?php
	include_once dirname(__FILE__).'/functions.php';
	echo'<pre>';
		print_r ($_REQUEST);
	echo '</pre>';

	if( 
	 	isset($_REQUEST["root-folder"])
	){
		$Folder = $_REQUEST["root-folder"].'/';
	}else{
		$Folder = '';
	}
	
	$Urls      =simplexml_load_string(file_get_contents($Folder."configure/urls.xml"));
	$templates =simplexml_load_string(file_get_contents($Folder."configure/templates.xml"));
	$sections  =simplexml_load_string(file_get_contents($Folder."configure/sections.xml"));
	$modules   = simplexml_load_string(file_get_contents($Folder."configure/modules.xml"));

	$Urls = getArrayFrom($Urls);
	$templates = getArrayFrom($templates);
	$sections = getArrayFrom($sections);	
	$modules = getArrayFrom($modules);

?><!DOCTYPE html>
<html>
<head>
</head>
<body style="background-color:  #444; color: #aaa; margin-top: 50px; margin-left: 100px;">
<h3 style="border-bottom: 5px solid #aaa;">New URL Fast-track</h3>
<form method="post" >
<table>
<tbody>
<tr>
	<td>URL</td>
	<td>
		<select  name="url"> 
 <?php foreach($Urls AS $Key => $stuff) { ?>
		<option value="<?php echo $stuff; ?>"><?php echo $stuff; ?></option>
 <?php } ?>
 		</select>
 	</td>
	<td>
		<input type="radio" name="rurls"  checked value="1">
		<input type="radio" name="rurls" value="2">
	</td>
	<td><input name="nurls" /></td> 	
</tr>
<tr>
	<td>Template</td>
	<td>
		<select id="" class="" name="template">​_ 
	 <?php foreach($templates AS $Key => $stuff) { 
	 ?>
	<option value="<?php echo $stuff; ?>"><?php echo $stuff; ?></option>
	 <?php } ?>
	 	</select>
	</td>
	<td>
	&nbsp;
	</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>Module</td>
	<td>
		<select id="" class="" name="module"> 
 <?php foreach($modules AS $Key => $stuff) { ?>
			<option value="<?php echo $stuff; ?>"><?php echo $stuff; ?></option>
 <?php } ?>
 		</select>
 	</td>
	<td>
		<input type="radio" name="rmodules"  checked value="1">
		<input type="radio" name="rmodules" value="2">
	</td>
	<td><input name="nmodules" /></td></tr>
<tr>
	<td>Section</td>
	<td>
		<select id="" class="" name="section"> 
 <?php foreach($sections As $Key => $stuff) {
 ?>
		<option value="<?php echo $stuff; ?>"><?php echo $stuff; ?></option>
 <?php } ?>
 		</select>
 	</td>
	<td>&nbsp;	</td>
	<td>&nbsp;</td> 	
</tr>
</tbody>
</table>
<input type="submit" value="    Go    ">
<input type="hidden" name="root-folder" value="<?php echo  $_POST['root-folder'] ; ?>" />
<input type="hidden" name="task" value="dosomething">
</form>
</body>
</html><?php

if(
	isset($_POST['task'])&&
	'dosomething'== $_POST['task']
){

	if('2' == $_POST['rurls']){
		// save the new url
		$Urls[]= $_POST['nurls'] ;
		saveXML("urls", "url", $Urls,$Folder."configure/urls.xml");
		$Url = $_POST['nurls'] ;
		
		//save the template for the new url
		
		//get default template
		$Templates = simplexml_load_file($Folder."configure/templates.xml");
		$Templates = getArrayFrom($Templates);
		$Template  = $Templates[0];

		//save
		$Assignmnent = objToArray(json_decode(file_get_contents($Folder."configure/assign-template.json")));
		$Assignmnent[$Url] = $Template;
		file_put_contents($Folder."configure/assign-template.json",json_encode($Assignmnent));
	}else{
		// use the old url
		$Url =  $_POST['url'];
	}

	if('2' == $_POST['rmodules']){
		// save the new modules
		$modules[]= $_POST['nmodules'] ;
		saveXML('modules', 'module', $modules ,$Folder."configure/modules.xml");
		$module = $_POST['nmodules'] ;

		mkdir($Folder."modules/".$_POST['nmodules']);
		
		file_put_contents($Folder."modules/".$_POST['nmodules']."/".$_POST['nmodules'].".php","<?php defined('_JEXEC') or die; ?>");
	}else{
		// use the old module
		$module =  $_POST['module'];
	}

	$Route = (array) json_decode(file_get_contents($Folder."configure/module-routing.json"));
	$Route = objToArray($Route);

	if(!isset($Route[ $_POST['section'] ])){
		$Route[ $_POST['section'] ] = array( );		
	}

	$Route[ $_POST['section'] ][] = array(
		$Url => $module
	);
	
	file_put_contents(
		$Folder."configure/module-routing.json",
		json_encode($Route)
	);

	include dirname(__FILE__).'/compile.php';

}

