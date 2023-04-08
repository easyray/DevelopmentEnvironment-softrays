<?php
/*
echo'<pre>';
	print_r ($_POST);
echo '</pre>';
die;
/*****/
include("functions.php");
if( 
 	isset($_POST["task"]) &&
	"urls.extract" == $_POST["task"]
){
	$URLs = saveURLs();
}

	if( 
	 	isset($_REQUEST["root-folder"])
	){
		$Folder = $_REQUEST["root-folder"].'/';
	}else{
		$Folder = '';
	}

	if( 
	 	isset($_POST["task"]) &&
		"extract-sections" == $_POST["task"]
	){
		$Src = file_get_contents($Folder.$_POST['template-file']);

		$res =[];
		$GG = '/\<section\b[^>]*id ?= ?"(([^"]|\\.)+)"[^>]*>/';
		preg_match_all($GG, $Src, $res);

		$ExtactedSections = $res[1];

	}



	$Urls      =simplexml_load_string(file_get_contents($Folder."configure/urls.xml"));
	$templates =simplexml_load_string(file_get_contents($Folder."configure/templates.xml"));
	$sections  =simplexml_load_string(file_get_contents($Folder."configure/sections.xml"));



	
	// Process URL related messages
	
	if(isset($_POST["action_url"]) && $_POST["action_url"] =="delete"){
		
		$Indeces = json_decode($_POST["stuff"]);
		$Urls = removeItem($Urls->url, $Indeces);
		saveXML("urls", "url", $Urls,$Folder."configure/urls.xml");

	}else if(isset($_POST["action_url"]) && $_POST["action_url"] =="update"){

		$Urls = getArrayFrom($Urls->url);
		$Urls[intval($_POST['index'])] = $_POST['value'];
		saveXML("urls", "url", $Urls,$Folder."configure/urls.xml");

	}else if(isset($_POST["action_url"]) && $_POST["action_url"] =="create"){
		
		$Urls = getArrayFrom($Urls->url);
		$Urls[] =	$_POST['name'];
		saveXML("urls", "url", $Urls,$Folder."configure/urls.xml");		
	}else{
		
		$Urls = getArrayFrom($Urls->url);
	} 


	
	// Process Templates related messages
	
	if(isset($_POST["action_template"]) && $_POST["action_template"] =="delete"){
		
		$Indeces = json_decode($_POST["stuff"]);
		$templates = removeItem($templates->template, $Indeces);
		
		saveXML("templates", "template", $templates,$Folder."configure/templates.xml");

	}else if(isset($_POST["action_template"]) && $_POST["action_template"] =="update"){

		$templates = getArrayFrom($templates->template);
		$templates[intval($_POST['index'])] = $_POST['value'];
		saveXML("templates", "template", $templates,$Folder."configure/templates.xml");

	}else if(isset($_POST["action_template"]) && $_POST["action_template"] =="create"){
		
		$templates   = getArrayFrom($templates->template);
		$templates[] = $_POST['name'];
		saveXML("templates", "template", $templates,$Folder."configure/templates.xml");
		
	}else{
		
		$templates = getArrayFrom($templates->template);
	}	


	// Process sections related messages
	
	if(isset($_POST["action_section"]) && $_POST["action_section"] =="delete"){
		
		$Indeces = json_decode($_POST["stuff"]);
		$sections = removeItem($sections->section, $Indeces);
		saveXML("sections", "section", $sections,$Folder."configure/sections.xml");

	}else if(isset($_POST["action_section"]) && $_POST["action_section"] =="update"){

		$sections = getArrayFrom($sections->section);
		$sections[intval($_POST['index'])] = $_POST['value'];
		saveXML("sections", "section", $sections,$Folder."configure/sections.xml");

	}else if(isset($_POST["action_section"]) && $_POST["action_section"] =="create"){
		
		$sections   = getArrayFrom($sections->section);
		$sections[] = $_POST['name'];
		saveXML("sections", "section", $sections,$Folder."configure/sections.xml");
		
	}else{
		
		$sections = getArrayFrom($sections->section);
	}

	if( 
	 	isset($_POST["task"]) &&
		"add-section" == $_POST["task"]
	){
		$SectionsList = explode(",", $_POST['section-list']);
		foreach ($SectionsList as $key => $value) {
			$sections[] = $value;
		}
		saveXML("sections", "section", $sections,$Folder."configure/sections.xml");
	}
	
	if( 
	 	isset($_POST["task"]) &&
		"extract-sections2" == $_POST["task"]
	){

		$_matches =[];
		$Content = file_get_contents($_POST['root-folder'].'/templates/'.$_POST['template-file'].'/index.php');
		preg_match_all('/route\s*\(\$PageName\s*,\s*"([^"]+)"/', $Content, $_matches);
		$ExtactedSections = $_matches[1];
	}
	/****/
?><!DOCTYPE html>
<html>
<head>
	<title>Configure</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <div id="container">
        
        <div id="my-logo"><img src="pix/logo.png" /> </div>
		<?php include("menu.php"); ?>
        <div id="our-slide-show">
        	<div>
        		<span class="nav-item">
        			<form method="post" action="fast-url-create.php">
        				<input type="submit" value="Fast Page" />
        				<input type="hidden" name="root-folder" value="<?php echo  $_REQUEST['root-folder'] ; ?>" />
        			</form>
        		</span>
        	</div>
        		<h1>URLs</h1>

			<table class="t-colapse" border="1">
			<thead>
			<tr>
			<th>S/N</th>
			<th>
				<input type="checkbox" onchange="selectAllUrls(this)"/>
			</th>
			<th>URL Name</th>
			<th>&nbsp;</th>
			</tr>
			</thead>
			<tbody>
			<?php $SN =1;	?>
			<?php foreach($Urls AS $Val){ ?>
			<tr>
			<td><?php echo $SN;  ?>&nbsp;</td>
			<td><input type="checkbox" class="cl-chk-url" value = "<?php echo ($SN-1) ?>"/></td>
			<td>
			<span id="id-spn2-url-<?php echo ($SN-1); ?>"> 
			<?php echo $Val;  ?>
			</span> 
			<span id="id-spn-url-<?php echo ($SN-1); ?>" style="display: none"> 
			<form action="index.php?root-folder=<?php echo $_REQUEST['root-folder']; ?>" method="post">
			<input type="text" name = "value" value = "<?php echo $Val;  ?>" />
			<input type="hidden" name="index" value = "<?php echo $SN-1; ?>" />
			<input type="hidden" name="root-folder" value="<?php echo  $_REQUEST['root-folder'] ; ?>" />
			<input type="hidden" name="action_url" value = "update" />

			<input type="submit" value=" Ok " />
			</form>
			</span>
			</td>
			<td>
<?php 
	if("" != strstr($_REQUEST['root-folder'], "admin") ){
		$URLLL = SITE_PATH.'/admin/'.$Val;
	}else{
		$URLLL = SITE_PATH.'/'.$Val;
	}
	
?>
			<input type="button" onclick="editUrl(this)" value=" edit " id="id-btn-url-<?php echo ($SN-1); ?>"/>
				<form style="display: inline;" method="post" action="<?php echo $URLLL;  ?>" target="_blank" >
					<input type="hidden"  name="task" value="launch" />
					<input type="submit" value="Launch" />
				</form>
			</td>
			</tr>
			<?php 
					$SN++;
				} 
			?>
			</tbody>
			</table>
			<div style="width:48%; padding-right:12%; padding-top: 25px;">

			<div style ="float: right" >
			<form action="index.php?root-folder=<?php echo  $_REQUEST['root-folder']; ?>" id="id-frm-url" method ="post">
				<input type="text" name="name" />
				<input type="hidden" name="stuff" />
				<input type="hidden" name="action_url" value="create" />
				<input type="submit"  value="create" />
				<input type="hidden" name="root-folder" value="<?php echo  $_REQUEST['root-folder']; ?>" />
				<input type="button"  value="delete"  id="id-btn-url-del" onclick= "deleteURL()"/>
			</form><br>
			<form method="post"   >
				
				<input type="submit" value="Extract (and save) URLs" />(overwrite)
				<input type="hidden" name="root-folder" value="<?php echo  $_REQUEST['root-folder']; ?>" />
				<input type="hidden" name="task" value="urls.extract" />
			</form>
<?php if( isset($_POST["task"]) && 	"urls.extract" == $_POST["task"]): ?>
	<div>
		The  following URLs were detected:
		<?php 		$X = implode(",", $URLs) ; ?>
		<p><?php echo $X; ?></p>
		&amp; have been saved to project configuration
	</div>
<?php endif; ?>
			</div>
			</div>
			<div style="border-bottom: thin solid #aaa; height: 15px;clear:both"></div>
		

		
<!--   Templates -->
			<table class="t-colapse" border="1">
			<thead>
			<tr>
			<th>S/N</th>
			<th>&nbsp;</th>
			<th>Template Name</th>
			<th>&nbsp;</th>
			</tr>
			</thead>
			<tbody>
			<?php $SN =1;	?>
			<?php foreach($templates AS $Val){ ?>
			<tr>
			<td><?php echo $SN;  ?>&nbsp;</td>
			<td><input type="checkbox" class="cl-chk-template" value = "<?php echo ($SN-1) ?>"/></td>
			<td>
			<span id="id-spn2-template-<?php echo ($SN-1); ?>"> 
			<?php echo $Val;  ?>
			</span> 
			<span id="id-spn-template-<?php echo ($SN-1); ?>" style="display: none"> 
			<form action="index.php" method="post">
			<input type="text" name = "value" value = "<?php echo $Val;  ?>" />
			<input type="hidden" name="index" value = "<?php echo $SN-1; ?>" />
			<input type="hidden" name="action_template" value = "update" />
			<input type="hidden" name="root-folder" value="<?php echo  $_REQUEST['root-folder'] ; ?>" />
			<input type="submit" value=" Ok " />
			</form>
			</span>
			</td>
			<td><input type="button" onclick="editTemplate(this)" value=" edit " id="id-btn-template-<?php echo ($SN-1); ?>"/></td>
			</tr>
			<?php 
					$SN++;
				} 
			?>
			</tbody>
			</table>
			<div style="width:48%; padding-right:12%; padding-top: 25px;">
			<div style ="float: right" >
			<form action="index.php" id="id-frm-template" method ="post">
				<input type="text" name="name" />
				<input type="hidden" name="stuff" />
				<input type="hidden" name="action_template" value="create" />
				<input type="submit"  value="create" />
				<input type="button"  value="delete"  id="id-btn-template-del" onclick= "deleteTemplate()"/>
				<input type="hidden" name="root-folder" value="<?php echo  $_REQUEST['root-folder'] ; ?>" />
			</form>
			</div>
			</div>
			<div style="border-bottom: thin solid #aaa; height: 15px;clear:both"></div>

<!--   Sections -->
			<table class="t-colapse" border="1">
			<thead>
			<tr>
			<th>S/N</th>
			<th>&nbsp;</th>
			<th>Section Name</th>
			<th>&nbsp;</th>
			</tr>
			</thead>
			<tbody>
			<?php $SN =1;	?>
			<?php foreach($sections AS $Val){ ?>
			<tr>
			<td><?php echo $SN;  ?>&nbsp;</td>
			<td><input type="checkbox" class="cl-chk-section" value = "<?php echo ($SN-1) ?>"/></td>
			<td>
			<span id="id-spn2-section-<?php echo ($SN-1); ?>"> 
			<?php echo $Val;  ?>
			</span> 
			<span id="id-spn-section-<?php echo ($SN-1); ?>" style="display: none"> 
			<form action="index.php?root-folder=<?php echo  $_REQUEST['root-folder'] ; ?>" method="post">
			<input type="text" name = "value" value = "<?php echo $Val;  ?>" />
			<input type="hidden" name="index" value = "<?php echo $SN-1; ?>" />
			<input type="hidden" name="action_section" value = "update" />
			<input type="submit" value=" Ok " />
			<input type="hidden" name="root-folder" value="<?php echo  $_REQUEST['root-folder'] ; ?>" />
			</form>
			</span>
			</td>
			<td><input type="button" onclick="editSection(this)" value=" edit " id="id-btn-section-<?php echo ($SN-1); ?>"/></td>
			</tr>
			<?php 
					$SN++;
				} 
			?>
			</tbody>
			</table>
			<div style="width:48%; padding-right:12%; padding-top: 25px;">
			<div style ="float: right" >
			<form action="index.php?root-folder=<?php echo  $_REQUEST['root-folder'] ; ?>" id="id-frm-section" method ="post">
				<input type="text" name="name" />
				<input type="hidden" name="stuff" />
				<input type="hidden" name="action_section" value="create" />
				<input type="submit"  value="create" />
				<input type="button"  value="delete"  id="id-btn-section-del" onclick= "deleteSection()"/>
				<input type="hidden" name="root-folder" value="<?php echo  $_REQUEST['root-folder'] ; ?>" />
			</form>
			</div>
			<div>
			<form method="post">
				<input type="text" name="template-file" placeholder="temlate file" />
				<input type="submit" value="find sections" />
				<input type="hidden" name="task" value="extract-sections" />
				<input type="hidden" name="root-folder" value="<?php echo  $_REQUEST['root-folder'] ; ?>" />
			</form>

			<form method="post">
				<input type="text" name="template-file" placeholder="temlate file" />
				<input type="submit" value="Find template sections" />
				<input type="hidden" name="task" value="extract-sections2" />
				<input type="hidden" name="root-folder" value="<?php echo  $_REQUEST['root-folder'] ; ?>" />
			</form>
			</div>
			<div>
			<form method="post" >
				<textarea name="section-list"><?php 
					if( isset($ExtactedSections)){
						echo implode(",", $ExtactedSections);
					}
				?></textarea><input type="submit" value="add sections">
				<input type="hidden" name="task" value="add-section" />
			</form>	
			</div>
			</div>
			<div style="border-bottom: thin solid #aaa; height: 15px;clear:both"></div>
			
<?php include("footer.php");  ?>		
		</div>
        

    </div>
	
	<script >
		function deleteURL(){
			var boxes =	document.getElementsByClassName("cl-chk-url");
			var dat = createJSON(boxes);
			var Form =document.getElementById("id-frm-url");

			Form.stuff.value = dat;
			Form.action_url.value = "delete";
			Form.submit();
			
		}
		
		function deleteTemplate(){
			var boxes =	document.getElementsByClassName("cl-chk-template");
			var dat = createJSON(boxes);
			var Form =document.getElementById("id-frm-template");

			Form.stuff.value = dat;
			Form.action_template.value = "delete";
			Form.submit();
			
		}		
		
		function deleteSection(){
			var boxes =	document.getElementsByClassName("cl-chk-section");
			var dat = createJSON(boxes);
			var Form =document.getElementById("id-frm-section");

			
			Form.stuff.value = dat;
			Form.action_section.value = "delete";
			Form.submit();
			
		}		
		function createJSON(Items){
			var Str = "[";
			var len = Items.length;
			var ii =0;
			for( var i = 0; i < len; i++){
				if(Items[i].checked){
					if(ii==0){
						Str += '"'+Items[i].value+'"';
						ii++;
					}else{
						Str += ', "'+Items[i].value+'"';
					}
				}// end if
			}
			Str+=']';
			return Str;
		}
		
		function editUrl(obj){
			var MyId = obj.id.substring(11);
			var spanid1 = "id-spn2-url-"+MyId;
			var spanid2 = "id-spn-url-"+MyId;
			
			document.getElementById(spanid1).innerHTML = "";
			
			var  FrmBox = document.getElementById(spanid2);
			
			FrmBox.style.display = "inline" ;
			var Frm = FrmBox.getElementsByTagName("form")[0];
			console.log(Frm);
		}
		
		function editTemplate(obj){
			var MyId = obj.id.substring(16);
			var spanid1 = "id-spn2-template-"+MyId;
			var spanid2 = "id-spn-template-"+MyId;
			
			console.log(spanid1);
			document.getElementById(spanid1).innerHTML = "";
			
			var  FrmBox = document.getElementById(spanid2);
			
			FrmBox.style.display = "inline" ;
			var Frm = FrmBox.getElementsByTagName("form")[0];
			console.log(Frm);
		}

		function editSection(obj){
			var MyId = obj.id.substring(15);
			var spanid1 = "id-spn2-section-"+MyId;
			var spanid2 = "id-spn-section-"+MyId;
			
			console.log(spanid1);
			document.getElementById(spanid1).innerHTML = "";
			
			var  FrmBox = document.getElementById(spanid2);
			
			FrmBox.style.display = "inline" ;
			var Frm = FrmBox.getElementsByTagName("form")[0];
			console.log(Frm);
		}
		function selectAllUrls(t){
			//select all url check boxes
			var i,Len;
			var AllURls = document.getElementsByClassName("cl-chk-url");

			Len = AllURls.length;
			for(i=0; i<Len; i++){
				AllURls[i].checked = t.checked;
			}
		}
	</script>
</body>
</html><?php

function saveURLs(){
	$IndexCode = file_get_contents($_POST['root-folder'] ."/index.php");
	//extract the cases/ urls
	$Cases=[];
	preg_match_all('/case\s+"([^"]+)"/', $IndexCode,$Cases);
	saveXML('urls','url', $Cases[1],$_POST['root-folder'] ."/configure/urls.xml");
	return $Cases[1];
}
