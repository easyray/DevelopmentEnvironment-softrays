<?php
	
	if( 
	 	isset($_POST["task"]) &&
		"routing.save" == $_POST["task"]
	){
		file_put_contents(
			$_POST['root-folder']."/configure/section-module.json",
			$_POST['map-json']
		);
	}





	
	include ("functions.php");

    if( isset($_REQUEST["root-folder"]) ){
        $Folder = $_REQUEST["root-folder"].'/';
    }else{
	   $Folder = "";
    }

	$Modules=simplexml_load_string(file_get_contents($Folder."configure/modules.xml"));
	$Modules = getArrayFrom($Modules->module);



	if(isset($_POST['action_module'])){
	    if(isset($_POST['action_module']) && $_POST['action_module']=="update"){
	    	$Modules[$_POST['index']] = $_POST['value'];
	    	saveXML('modules', 'module', $Modules ,$Folder."configure/modules.xml");
	    }else if(isset($_POST['action_module']) && $_POST['action_module']=="delete"){
	    	$Modules = removeItem($Modules,$_POST['ModIndeces']);
			saveXML('modules', 'module', $Modules ,"modules.xml");
	    }else if(isset($_POST['action_module']) &&$_POST['action_module'] == "create"){
			$Modules[]  = $_POST['name'];
			saveXML('modules', 'module', $Modules ,$Folder."configure/modules.xml");
		}else if(isset($_POST['action_module']) &&$_POST['action_module'] == "save"){
			$G = array();
			foreach($_POST['sectionList'] AS $Key => $Value){
				$G[$Value] = $_POST['moduleList'][$Key];
			}

			file_put_contents($Folder.'configure/section-module.json', json_encode($G) );

		}else if(isset($_POST['action_module']) &&$_POST['action_module'] == "reset"){
			$G = array();
			file_put_contents($Folder.'configure/section-module.json', json_encode($G) );
		}else if(isset($_POST['action_module']) &&$_POST['action_module'] == "delete-modules"){



			if( 
				isset($_POST["remove-folders"]) &&
				"remove" == $_POST["remove-folders"]
			){
				$folder_indeces = explode(",", $_POST['modules']);
				$L = sizeof($folder_indeces);

				$folders =[];
				for($i=0; $i<$L; $i++){
					$folder[] = $Modules[$folder_indeces[$i]];
				}

				foreach($folder as $value){
					removeModuleFolder($value,$Folder."modules");
				}
			}

			$indeces = explode(",", $_POST['modules']);
			$Modules = removeItem($Modules, $indeces);
			saveXML('modules','module',$Modules,$Folder."configure/modules.xml");			
		}
	}else if( 
	 	isset($_POST["task"]) &&
		"add-modules" == $_POST["task"]
	){
		
		$NModules   = explode(",", $_POST['modules']);
		foreach ($NModules as $key => $value) {
			$Modules[]  = $value;
		}
		
		saveXML('modules', 'module', $Modules ,$Folder."configure/modules.xml");

		if( 
		 	isset($_POST["create-folders"]) &&
			"add-modules" == $_POST["create-folders"]
		){
			foreach ($NModules as $key => $value) {
				createModuleFolder($value,$Folder."modules");
			}
		}
	}else if( 
	 	isset($_POST["task"]) &&
		"list-modules" == $_POST["task"]
	){
		$Lst= scandir($Folder."modules");
		$ModuleList =[];
		foreach ($Lst as $key => $value) {
			if(".."!=$value && "." != $value){
				$ModuleList[] = $value;
			}
		}
	}

	
	$sections  =simplexml_load_string(file_get_contents($Folder."configure/sections.xml"));
	$sections  = getArrayFrom($sections->section);

	$GSectionModule = array();
	 foreach( $sections AS $Key => $Value){
		$GSectionModule[$Value] = $Modules[0];
	}


	if(is_file($Folder."configure/section-module.json")){
		$G = (array) json_decode(file_get_contents($Folder.'configure/section-module.json'));	
		foreach($G AS $Key => $Value){
			$GSectionModule[$Key] = $G[$Key];
		}
	}


	if( 
	 	isset($_POST["task"]) &&
		"routing.default.detect" == $_POST["task"]
	){

		// get the list of sections
		$Sections =simplexml_load_string(file_get_contents($_POST['root-folder']."/configure/sections.xml"));
		$Sections =  getArrayFrom($Sections->section);


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
			explode('/', route($PageName,$Section)[0])[1];
		}


	}
 ?><!DOCTYPE html>
<html>
<head>
	<title>Def-Module</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <div id="container">
        
        <div id="my-logo"><img src="pix/logo.png" /> </div>
		<?php include("menu.php"); ?>
        
		<div id="our-slide-show">
			<h1>Default Module</h1>
			<p>Modules</p>
		
			<table border="1" cellpadding="5" cellspacing="0" class="t-colapse" id="modules-table">
			<thead>
			<tr>
			<th>S/N</th>
			<th>&nbsp;</th>
			<th>Module Name</th>
			<th>&nbsp;</th>
			</tr>
			</thead>
			<tbody>
			<?php $SN  = 1; ?>
			<?php foreach ($Modules AS  $Value) { ?>
			<tr>
				<td><?php echo $SN; ?></td>
				<td>
					<input name="ModIndeces[]" type="checkbox" class="cls-chk-modules"  value="<?php echo ($SN-1) ; ?>" />
				</td>
				<td>
					<span id="id-spn-frm-module-<?php echo ($SN-1); ?>" style="display: none"> 
					<form method="post">
						<input type="text" name="value" value="<?php echo $Value; ?>">
						<input type="hidden" name="index" value="<?php echo ($SN-1); ?>">
						<input type="hidden" name="action_module" value="update">
						<input type="submit" value=" Ok ">
						<input type="hidden" name="root-folder" value="<?php echo  $_REQUEST['root-folder'] ; ?> " />
					</form>
					</span>
					<span id="id-spn-module-<?php echo ($SN-1); ?>">
					<?php echo $Value; ?>
					</span></td>
		<td><input type="button" onclick="editItem(this,'id-spn-module-','id-spn-frm-module-')" value=" edit " id="id-btn-edit-module-<?php echo ($SN-1); ?>"></td>
					</tr>
			<?php
				$SN++;
			 }  ?>
      </tbody>
	</table>

	<div style="width:48%; padding-right:12%; float: right; height: 30px; padding-top: 20px">
    
		<form  method="post" id="frm-url-tmp" style="display: inline;">
		<input type="text" name="name" />
		<input type="hidden" name="action_module" value="create" />
		<input type="submit" value=" Add " />
		<input type="hidden" name="root-folder" value="<?php echo  $_REQUEST['root-folder'] ; ?>" />
		</form>
		<input type="hidden" name="action_module" value="delete" />
		<input type="button" value=" Delete " id="btn-module-delete" />
		<form method="post" id="frm-module-delete">
			<input type="checkbox" name="remove-folders" value="remove" />
			<input type="hidden" name="action_module" value="delete-modules">
			<input type="hidden" name="modules" value="" id="module-list" >
			<input type="hidden" name="root-folder" value="<?php echo  $_REQUEST['root-folder'] ; ?>" />
		</form>
	</div>

<h4>Moduleses</h4>
<form method="post">
	<textarea name="modules" rows="5" cols="40"><?php 
		if(isset($ModuleList)){
			echo implode(",", $ModuleList);
		}
	?></textarea>
	<input type="hidden" name="task" value="add-modules" />
	<div>
		Create Folders<input type="checkbox"  value="add-modules" name="create-folders" />
		<input type="submit"  value="add-modules" />
	</div>
</form>
<form method="post">
	<input type="hidden" name="task" value="list-modules" />
	<div>
		<input type="submit"  value="list-modules" />
	</div>
</form>
	
	<p>&nbsp;</p>		
	<p>&nbsp;</p>		
	<p>&nbsp;</p>		
<h3>Default Module Assignment</h3>

<form  method = "post">
<table class="t-colapse" border="1" cellspacing="0" cellpadding="5">
<tbody>
<tr>
<th>S/N</th>
<th>Section</th>
<th>Module</th>
</tr>
<?php $SN = 1 ?>
<?php foreach($GSectionModule AS $Key => $Value ) { ?>
<tr>
<td><?php  echo $SN ;   ?></td>
<td><?php  echo $Key;   ?><input type ="hidden" value="<?php  echo $Key;   ?>" name="sectionList[]"/></td>
<td><?php  echo tempList($Modules,"cls-mod-list",$Value,"moduleList[]"); ?></td>
</tr>
<?php $SN ++ ?>
<?php  }  ?>
</tbody>
</table>	



    <input type = "hidden" name ="action_module" value = "save" />
    <input type = "submit"  value = "save" />
	<input type="hidden" name="root-folder" value="<?php echo  $_REQUEST['root-folder'] ; ?>" />
</form>
<form method="post">
    <input type = "hidden" name ="action_module" value = "reset" />
    <input type = "submit"  value = "reset" />
    <input type="hidden" name="root-folder" value="<?php echo  $_REQUEST['root-folder'] ; ?> " />
</form>	

<form method="post">
    <input type = "hidden" name ="task" value = "routing.default.detect" />
    <input type = "submit"   value = "   Detect Default Routing   " style="height: 30px; border-radius: 5px; "/>
    <input type="hidden" name="root-folder" value="<?php echo  $_REQUEST['root-folder'] ; ?>" />
</form>	
<form method="post">
	<textarea rows="20" cols="40" name="map-json"><?php 
	if(isset($SectionModuleDictionary)){
		echo  json_encode($SectionModuleDictionary) ;
	}
	?></textarea>
    <input type = "hidden" name ="task" value = "routing.save" />
    <input type = "submit"   value = "   Save Routing Json  " style="height: 30px; border-radius: 5px; "/>
    <input type="hidden" name="root-folder" value="<?php echo  $_REQUEST['root-folder'] ; ?> " />
</form>	


        </div>
	</div>
	<script src="jquery-1.9.1.js"></script>
	<script >
		function editItem(obj,prefix,prefix2){
		
		
			var MyId = obj.id.split("-")
			var len = MyId.length;

			MyId = MyId[len-1];
			
			var spanid1 = prefix+ MyId;
			var spanid2 = prefix2 + MyId;
			console.log(spanid1);

			document.getElementById(spanid1).innerHTML = "";
			
			var  FrmBox = document.getElementById(spanid2);
			
			FrmBox.style.display = "inline" ;
			var Frm = FrmBox.getElementsByTagName("form")[0];
			
		}


//-----------------------------------------
$("#btn-module-delete").bind("click",deleteModules); 

function deleteModules() {
	var checks = $("input.cls-chk-modules");
	var len = checks.length;
	var str = "";
	var first_done = 0;
	for(var i = 0; i<len; i++){
		if(checks[i].checked){
			if(first_done==0){
				str += checks[i].value;
				first_done++;
			}else{
				str += ","+checks[i].value;
			}
		}
	}
	
	$("#module-list").val(str);
	$("#frm-module-delete")[0].submit();

}
function modulesDeleted(dat) {
 console.log(dat); 
 window.location.reload();
}

	</script>
</body>
</html>