<?php
include ("functions.php");
if(isset($_POST["subtask"]) && "url-shortcuts" == $_POST["subtask"])
	generateURLShortcuts();
if(isset($_POST["subtask"]) && "sublimeproject" == $_POST["subtask"])
	createSublimeProject();
if(isset($_POST["subtask"]) && 	"ide.settings" == $_POST["subtask"])
	createIDESettings();
if(isset($_POST["task2"]) &&   "use-url" == $_POST["task2"])
{
   $_POST['filename'] = $_SERVER['DOCUMENT_ROOT'].'/'.
   substr($_POST['url-dst'],strlen('http://localhost/'));
   unset($_POST["task2"]);
}
if(isset($_POST["task2"]) && "script.run" == $_POST["task2"])
	runScript();
if(isset($_POST["task2"]) && "use-abs" == $_POST["task2"])
{
   $_POST['filename'] = str_replace("\\", "/", $_POST['abs-dst']);
   unset($_POST["task2"]);
}
if(isset($_POST["create-folder"]))
	createFolder();
if(isset($_POST["create-file"]))
	createFile();
if(isset($_POST["create-html"]))
	createHTML();
if(isset($_POST['create-pro-file']))
	createProFile();
if(isset($_POST['compl-ref-list']))
	createCompletionList();



if(isset($_POST['filename'])){
	if(isset($_POST["launch"]) && "launch-time" == $_POST["launch"])
	if(isset($_POST["phptidy"]) && "ozera" == $_POST["phptidy"])
		phpTidy();
	/*end-if*/
	if(
		!isset($_POST["create-file"]	 )  &&
		!isset($_POST['create-pro-file'] )&&
		!isset($_POST["create-folder"]   )&&
		!isset($_POST["task2"]		     ) &&
		!isset($_POST["fn-ref"]		     ) &&
		!isset($_POST["var-ref"]		 )  &&
		!isset($_POST["launch"]		     ) &&
		!isset($_POST["file-select"]	 )  &&
		!isset($_POST["griffon-transfer"])&&
		!isset($_POST["phptidy"])
	){
		
		$exec_output = [];
		if(is_file($_POST['filename']))
			exec("subl ".$_POST['filename'], $exec_output);		

		if(isset($_POST['open-folder'])){

			if(is_file($_POST['filename'])   ){
				$Folder = dirname($_POST['filename']);
			}else{
				$Folder = $_POST['filename'];
			}

			$Folder = str_replace("/", DIRECTORY_SEPARATOR , $Folder);

			exec("explorer ".$Folder);
		}
	}//===========		
	
}// end if



$SROOT = SITE_FOLDER;

$SPATH = SITE_PATH;
?>

	<title>File Manager</title>
	<link rel="stylesheet" href ="css/file-manager.css?v=7" >
	<style type="text/css">
		body,ul,li,span{
			background-color: #474842;
			color: #eee;
		}
		input{
			background-color: #272822;
			color: #eee;
			border: thin solid #888
		}
		body{
			padding-top: 50px;
			padding-left: 50px
		}
		#side-pane{
			width: 20%;
			float: left;
		}
	</style>
	
	<h1 style="font-family: sans-serif; clear: both">File Manager</h1>
	<h4 style="clear: both;"><?php 
	echo $_POST['filename']; ?></h4>
	<div>
	<form method="post">
		<input type="text" name="url-dst" style="width: 300px; height: 30px" placeholder="use url" />
		<input type="hidden" name="task2" value="use-url" />
		<input name="task" value="show-folder-2" type="hidden" />
		<input type="submit" value="   Use   "  style="padding: 10px; border-radius: 5px" />
	</form>
	<form method="post">
	<input type="text" name="abs-dst" style="width: 300px; height: 30px" placeholder="use absolute location" value="<?php 
	echo $_POST['filename']; ?>" />
	<input type="hidden" name="task2" value="use-abs" />
	<input name="task" value="show-folder-2" type="hidden" />
	<input type="submit" value="   Use   "  style="padding: 10px; border-radius: 5px" />
	  </form>      
	</div>
	<div id="side-pane">
	  <ul style="list-style-type: none; padding: 0px; margin: 0px; max-height: 400px; overflow-y: scroll;">
		<li class="side-pane-item">
		  <form style="display: inline;" method="post"> 
		  	<input name="task" value="show-folder-2" type="hidden"> 
			  <input name="filename" value="<?php echo $SROOT; ?>"
			  type="hidden"> <input value="Root Folder" style="width: 100%" type="submit">
		  </form>
		</li>
		<li class="side-pane-item">
		  <form style="display: inline;" method="post"> <input
			  name="task" value="show-folder-2" type="hidden"> <input
			  name="filename" value="<?php echo $SROOT.'/admin';
			  ?>" type="hidden"> <input value="Admin Root" style="width: 100%" type="submit">
		  </form>
		</li>
		<li class="side-pane-item">
		  <form style="display: inline;" method="post"> <input
			  name="task" value="show-folder-2" type="hidden"> <input
			  name="filename" value="C:/xampp/htdocs/php-mvc-IDE/reference" type="hidden"> <input value="Reference" style="width: 100%" type="submit">
		  </form>
		</li>		
		<li class="side-pane-item">
		  <form style="display: inline;" method="post"> <input
			  name="task" value="show-folder-2" type="hidden"> <input
			  name="filename" value="<?php echo $SROOT.'/modules';
			  ?>" type="hidden"> <input value="Site Modules" style="width: 100%" type="submit">
		  </form>
		</li>
		<li class="side-pane-item">
		  <form style="display: inline;" method="post"> <input
			  name="task" value="show-folder-2" type="hidden"> <input
			  name="filename" value="<?php echo
			  $SROOT.'/admin/modules'; ?>" type="hidden"> <input value="Admin Modules" style="width: 100%" type="submit">
		  </form>
		</li>
		<li class="side-pane-item">
		  <form style="display: inline;" method="post"> <input
			  name="task" value="show-folder-2" type="hidden"> <input
			  name="filename" value="<?php echo $SROOT.'/templates';
			  ?>" type="hidden"> <input value="Site Templates" style="width: 100%" type="submit">
		  </form>
		</li>
		<li class="side-pane-item">
		  <form style="display: inline;" method="post"> <input
			  name="task" value="show-folder-2" type="hidden"> <input
			  name="filename" value="<?php echo
			  $SROOT.'/admin/templates'; ?>" type="hidden"> <input value="Admin Templates" style="width: 100%" type="submit">
		  </form>
		</li>
		<li class="side-pane-item">
		  <form style="display: inline;" action="<?php echo
			$SPATH.'/admin/install.php'; ?>" target="blank_"> <input value="admin install" style="width: 100%" type="submit">
			<input type="hidden" name="root-folder" value="<?php 
			if(!isset($_REQUEST['root-folder']) ){
				echo  SITE_FOLDER ; 
			}else{
				echo $_REQUEST['root-folder'];
			}
		    ?>" />
		  </form>
		</li>
		<li class="side-pane-item">
		  <form style="display: inline;" action="<?php echo
			$SPATH.'/install.php'; ?>" target="blank_"> <input value="site install" style="width: 100%" type="submit" />
			<input type="hidden" name="root-folder" value="<?php 
			if(!isset($_REQUEST['root-folder']) ){
				echo  SITE_FOLDER ; 
			}else{
				echo $_REQUEST['root-folder'];
			}
		     ?>" />
		  </form>
		</li>
		<li class="side-pane-item">
    <form method="post" style="display: inline" action="tinyMCE/code-page.php" target="blank_"> 
      <input name="filename" value="<?php echo $_POST['filename']; ?>" type="hidden"> 
      <input name="task" value="show-folder-2" type="hidden" />
      <input value="Wysiwyg Editor" style="width: 100%" name="griffon-transfer" type="submit" />
    </form>
		</li>
		<li class="side-pane-item">
		  <form style="display: inline;" action="<?php echo
			$SPATH.'/admin/configure/tinyMCE/TinyMCE.html'; ?>"
			target="blank_"> <input value="WYSG 2" style="width: 100%" type="submit">
		  </form>
		</li>
		<li class="side-pane-item">
			<form style="display: inline;" method="post">
				<input name="task" value="show-folder-2" type="hidden">
				<input name="task2" value="show-config" type="hidden">
				<input name="filename" value="<?php echo
					  $SROOT.'/admin/forbidden/config.php'; ?>" type="hidden">
				<input value="Config File" style="width: 100%" type="submit">
			</form>
		</li>
		<li class="side-pane-item">
			<form style="display: inline;" method="post" action="<?php
					echo $SPATH.'/admin/forbs/phplite/index.php'; ?>" target="blank_">
				<input name="task" value="show-folder-2" type="hidden">
				<input name="task2" value="sqlite" type="hidden">
				<input name="filename" value="<?php echo
					  $SROOT.'/admin/forbidden/config.php'; ?>" type="hidden">
				<input value="SQLite" style="width: 100%" type="submit">
			</form>
		</li>
		<li class="side-pane-item">
			<form style="display: inline;" method="post" action="database-mgr.php" target="blank_">
				<input type="hidden" name="root-folder" value="<?php
				  		if($_REQUEST['root-folder']){
				  			echo $_REQUEST['root-folder'];
				  		}/*else*/  
				  	?>" />
				<input value="Database" style="width: 100%" type="submit">
			</form>
		</li>
		<li class="side-pane-item">
		  <form style="display: inline;" method="post" >
		  	<input type="hidden" name="root-folder" value="<?php
		  		if($_REQUEST['root-folder']){
		  			echo $_REQUEST['root-folder'];
		  		}/*else*/  
		  	?>" />
		  	<input name="task" value="show-folder-2" type="hidden">
		  	<input type="hidden" name="filename" value="<?php
				if($_REQUEST['filename']){
					echo $_REQUEST['filename'];
				}/*else*/  	?>" />
			<input value="Bookmark" style="width: 100%" type="submit"> 
			</form>
		</li>
		<li class="side-pane-item">
		  <form style="display: inline;" method="post" >
		  	<input name="task" value="show-folder-2" type="hidden">
		  	<input type="hidden" name="root-folder" value="<?php
		  		if($_REQUEST['root-folder']){
		  			echo $_REQUEST['root-folder'];
		  		}/*else*/  
		  	?>" />
		  	<input type="hidden" name="filename" value="<?php
				if($_REQUEST['filename']){
					echo $_REQUEST['filename'];
				}/*else*/  	?>" />
			<input value="Forget" style="width: 100%" type="submit"> </form>
		</li>		
		<li class="side-pane-item">
		  <form style="display: inline;" method="post" action="nava-editor.php" target="blank_">
		  	<input type="hidden" name="root-folder" value="<?php
		  		if($_REQUEST['root-folder']){
		  			echo $_REQUEST['root-folder'];
		  		}/*else*/  
		  	?>" />
		  	<input type="hidden" name="filename" value="<?php
		  		if($_REQUEST['filename']){
		  			echo $_REQUEST['filename'];
		  		}/*else*/  	?>" />
			<input value="Open in Nav Editor" style="width: 100%" type="submit"> </form>
		</li>
		<li> Site Modules
		  <?php
			include_once "functions.php";
			
			$Modules = simplexml_load_string(file_get_contents($SROOT."/configure/modules.xml"));
			$Modules = getArrayFrom($Modules);
		?>
		  <form method="post">
		  <?php 
	  			$Select = '<select name="filename" >'; 
			foreach($Modules AS $Val){
				  $Select .= '<option value="'.$SROOT.
				  '/modules/'.$Val.'" />'.$Val.'</option>'; 
			} 

			echo "$Select </select>"; 
			
			?>
			<input name="task" value="show-folder" type="hidden"> 
			<input value="	 Go	 " type="submit">
		  </form>
		</li>
		<li> Admin Modules
		  <?php
			$Modules = simplexml_load_string(file_get_contents($SROOT."/admin/configure/modules.xml"));
			$Modules = getArrayFrom($Modules);
		?>
		  <form method="post">
			<?php 
			$Select = '<select name="filename" >'; 
	  foreach($Modules AS $Val){
			$Select .= '<option value="'.$SROOT.'/admin/modules/'.$Val.
			'" >'.$Val.'</option>'; 
	  } 
	  echo "$Select </select>";
	  ?> 
	  <input name="task" value="show-folder" type="hidden"> <input value="	 Go	 " type="submit">
	  </form>
		</li>
		<li> Admin Plugins
		  <?php
			$Plugins = simplexml_load_string(file_get_contents($SROOT."/admin/configure/plugins.xml"));
			$Plugins = getArrayFrom($Plugins);
		?>
		  <form method="post">
			<?php 
			$Select = '<select name="filename" >'; 
	  foreach($Plugins AS $Val){
			$Select .= '
			<option value="'.$SROOT.'/admin/plugins/'.$Val.'" >'.
			$Val.'</option>'; 
	  } 
	  echo $Select; ?> 

	  <input name="task" value="show-folder" type="hidden"> <input value="	 Go	 " type="submit">
		  </form>
		</li>
		<li> Site Plugins
		  <?php
			$Plugins = simplexml_load_string(file_get_contents($SROOT."/configure/plugins.xml"));
			$Plugins = getArrayFrom($Plugins);
		?>
		  <form method="post">
			<?php 
			$Select = '<select name="filename" >'; 
	  foreach($Plugins AS $Val){
			$Select .= '<option value="'.$SROOT.'/plugins/'.$Val.'" >'.
			$Val.'</option>'; 
	  } 

    echo "$Select </select>"; 

    ?> 

	  <input name="task"
			  value="show-folder" type="hidden"> <input value="	 Go	 " type="submit">
		  </form>
		</li>
	  </ul>
	</div>
	<div style="color: black;width: 70%; text-align: left; float: left;  ">
	  <div style="max-height: 400px; overflow-y: scroll; border: thin solid #666; margin-left: 50px">
		<?php

	if(is_file($_POST['filename'])){
		showAFolder(dirname($_POST['filename']));
	}else if(is_dir($_POST['filename'])){
		showAFolder(($_POST['filename']));
	}
?> </div>
	  /
	  <div>
		<form method="post" style="display: inline"> <input
			name="filename" value="<?php echo
			dirname($_POST['filename']); ?>" type="hidden"> <input
			name="task" value="show-folder-2" type="hidden"> <input value="Up" type="submit">
		</form>

    <form method="post" style="display: inline"  > 

		  &nbsp;&nbsp;&nbsp;&nbsp;
      <input name="filename" value="<?php echo $_POST['filename']; ?>" type="hidden"> 
      <input name="task" value="show-folder-2" type="hidden" />
      <input name="new-item" type="text" /> 
      <input value="New Folder" name="create-folder" type="submit" />
		  <input value="New File" name="create-file" type="submit"> 
      <input value="New HTML-resp" name="create-html" type="submit">
		  <input value="New File(ajax-server)" name="create-pro-file" type="submit">
		</form>

    <form method="post" style="display: inline" action="tinyMCE/TinyMCE2.php?p=<?php echo  $_REQUEST['root-folder'].'/recordset.json' ; ?>" target="blank_">
      <input name="filename" value="<?php echo $_POST['filename']; ?>" type="hidden">
      <input name="task" value="show-folder-2" type="hidden" />
      <input value="TinyMCE Editor" name="griffon-transfer" type="submit" />
    </form>
    <?php echo  $_REQUEST['root-folder'].'/recordset.json' ; ?>

  </div>
	  <form action="create-ajax.php" method="post" style="display:
		inline"> <input name="rotfolder" value="<?php echo
		  $_POST['filename']; ?>" type="hidden"> <input value="Create Ajax" type="submit">
	  </form>
	  <form style="display: inline" action="bind-event.php"
		method="post"> <input name="rotfolder" value="<?php echo
		  $_POST['filename']; ?>" type="hidden"> <input value="Bind Event" type="submit">
	  </form>
	  <form style="display: inline" method="post"> 
	  	<input name="task" value="show-folder-2" type="hidden"> <input name="filename"
		  value="<?php echo $_POST['filename']; ?>" type="hidden">
		<input value="Open Folder" name="open-folder" type="submit"> </form>
	  <form action="getURL.php" method="post"> 
	  	<input name="rotfolder" value="<?php echo $_POST['filename']; ?>" type="hidden" />
		<input type="hidden" name="root-folder" value="<?php 
			if(!isset($_REQUEST['root-folder']) ){
				echo  SITE_FOLDER ; 
			}else{
				echo $_REQUEST['root-folder'];
			}
		?>" />

		<input value="Get Address" type="submit">
	  </form>

	  <form  method="post"> 
	  	<input name="filename" value="<?php echo $_POST['filename']; ?>" type="hidden" />
		<input type="hidden" name="root-folder" value="<?php 
			if(!isset($_REQUEST['root-folder']) ){
				echo  SITE_FOLDER ; 
			}else{
				echo $_REQUEST['root-folder'];
			}
		?>" />
		<input name="task" value="show-folder-2" type="hidden">
		<input value="     Launch     " type="submit">
		<input type="hidden" name="launch" value="launch-time" />
	  </form>



	  <form style="display: inline" method="post"> 
	  		<input name="filename" value="<?php echo $_POST['filename'];
		  ?>" type="hidden"> 
		  <input name="task" value="show-folder-2" type="hidden"> 
		  <input name="phptidy" value="ozera" type="hidden" /> 
		  <input value="Php Tidy" type="submit" />
		  <input name="task"  value="show-folder-2" type="hidden" />
		  
	  </form>


	  <form style="display: inline" action="script-version.php" target="_blank" method="post"> 
	  	<input name="filename" value="<?php echo $_POST['filename']; ?>" type="hidden" />
		<input type="hidden" name="site-folder" value="<?php 
			if(!isset($_REQUEST['root-folder']) ){
				echo  SITE_FOLDER ; 
			}else{
				echo $_REQUEST['root-folder'];
			}
		?>" />
		<input name="task" value="show-folder-2" type="hidden">
		<input value="<script>" type="submit">
	  </form>
	  
	  <form  action="link-version.php" target="_blank" method="post" style="display: inline" > 
	  	<input name="filename" value="<?php echo $_POST['filename']; ?>" type="hidden">
		<input type="hidden" name="site-folder" value="<?php 
			if(!isset($_REQUEST['root-folder']) ){
				echo  SITE_FOLDER ; 
			}else{
				echo $_REQUEST['root-folder'];
			}
		?>" />
		<input name="task" value="show-folder-2" type="hidden">
		<input value="&lt;link...&gt;" type="submit">
	  </form>
	  <form style="display: inline" method="post"> 
	  	<input name="filename" value="<?php echo $_POST['filename'];
		  ?>" type="hidden"> 
		  <input name="task" value="show-folder-2" type="hidden"> 
		  <input name="fn-ref" value="ozera" type="hidden"> 
		  <input value="Function Reference" type="submit">
	  </form>
	  <form style="display: inline" method="post"> 
	  	<input name="filename" value="<?php echo $_POST['filename'];
		  ?>" type="hidden"> 
		  <input name="task" value="show-folder-2" type="hidden"> 
		  <input name="var-ref" value="ozera" type="hidden"> 
		  <input value="Variables Reference" type="submit">
	  </form>
	  <form style="display: inline" method="post"> 
	  	<input name="filename" value="<?php echo $_POST['filename'];
		  ?>" type="hidden"> 
		  <input name="task" value="show-folder-2" type="hidden"> 
		  <input name="compl-ref-list" value="ozera" type="hidden"> 
		  <input value="Create Completion List" type="submit">
	  </form>
	  <form style="display: inline" method="post"> 
	  	<input name="filename" value="<?php echo $_POST['filename'];
		  ?>" type="hidden"> 
		  <input name="task" value="show-folder-2" type="hidden"> 
		  <input name="task2" value="script.run" type="hidden">
		  <?php 
		  	$ScriptList = explode(
		  		"\n", 
		  		file_get_contents(
		  			"C:/scripts/IDE-Scripts/PHP-MVC-Scripts.txt"
		  		)
		  	);
		  	?>
		  <select name="chosen-script" id="dd-stuff" >
		      <?php foreach($ScriptList AS $ScriptItem) : ?>
		      	<?php $Script_Item =explode(";", $ScriptItem); ?>
		          <option value="<?php echo $Script_Item[1]; ?>" <?php
		              if(
		              		isset($_POST['chosen-script']) &&
		                  $Script_Item[1] ==  $_POST['chosen-script']
		              ){
		                  echo 'selected="true" ';
		              }/*else*/  
		          ?> ><?php echo $Script_Item[0]; ?></option>
		      <?php endforeach; ?>
		  </select>
		  <input value="Run Script" type="submit">
	  </form>
	  <br />
	  <form action="../index.php"> 
		  <input value=" Exit " type="submit" />
		  <input name="root-folder" value="<?php echo  SITE_FOLDER ; ?>" type="hidden" />
	  </form>
<?php
	function showAFolder($Dir){

		$List = scandir($Dir);

	 	echo '<ul style="list-style-type: none; padding-top: 50px" class="fm_list"-->';


	  foreach($List AS $Value){ 
		if($Value !="." && $Value !=".."){ 
		  if(is_dir("$Dir/$Value")){ 
			echo '
	  <li><span class="fm_folder"></span>'. $Value. 
	  '<form method="post" style="display: inline"> 
	  <input name="filename" value="'.$Dir.'/'.$Value.'" type="hidden"> 
	  <input value="open" style="" type="submit">
	  <input name="task" value="show-folder-2" type="hidden"> 
	  </form></li>'; 
		} 
	  } 
  }
	  foreach($List AS $Value){ 
		if($Value !="." && $Value !=".."){ 
		  if(!is_dir("$Dir/$Value")){ 
			$class = getClass(getExtension($Value) ) ; 
			echo '
			<li><span class="'.$class.'"></span> 
			<input class="fm_chk_copy" value="'.$_POST["filename"].
			'/'.$Value.'" type="checkbox"> '.$Value.'
		<form method="post" style="display: inline"> 
		<input name="filename" value="'.$Dir.'/'.$Value.
		'" type="hidden" /> 
		<input value="select" name="file-select" type="submit">
		<input value="open" style="" type="submit"> 
		<input name="task" value="show-folder-2" type="hidden"> 
		</form>
	  </li>
	  '; 
	} 
  } 
}
	  /////////// echo '';
	  }
	  ?>
	</div>
	<script src="jquery-1.9.1.js"></script>
	<script type="text/javascript">

function selectFiles() {

	var dat; 
	var chk_list = $("input.fm_chk_copy");
	var len	  = chk_list.length;
	var lst	  = "";
	var counter  = 0;
	
	for(var i=0; i<len; i++){
		if(chk_list[i].checked){
			if(counter == 0){
				lst += chk_list[i].value;
				counter = 1;
			}else{
				lst += ','+chk_list[i].value;
			}
		}
	}

	alert("selected");
	
	dat = {
		"selected": lst
	};
	console.log("<?php echo SITE_PATH; ?>");
	 $.ajax({ 
		data: dat,
		 type:"post",
		 url: "<?php echo SITE_PATH; ?>/configure/ajax_copy_file.php",
		success: fileSelected,
		 error: function(a,b,c){ 
		console.log(a); 
		console.log(b);
		 console.log(c); 
	} 
	});
}
function fileSelected(dat) {
 console.log(dat); 
}
$("input#copy-button").bind("click",selectFiles); 
	
</script><?php 
	if(
		isset($_POST['task2'])
	){
		$Config = file_get_contents($_POST['filename']);
		echo '<div style="clear: both; background-color: #efefef; color: #555"-->
	<pre>';
		echo htmlentities($Config);

		echo '</pre>'; 
  } 
  if( isset($_POST['fn-ref']) ){
	showFunctions($_POST['filename']); 
  } 

  if( isset($_POST['var-ref']) ){
	showVariabes($_POST['filename']); 
  } 
  ?>
  </body>
</html>
<?php 
	function showFunctions($File){

		$str = file_get_contents($File);
		$res = array();
		$Search = '/function\s+([0-9a-zA-Z_]+\s*\([^)]*\))/';
		
	preg_match_all($Search, $str, $res);
		echo '<textarea cols= "80" rows="25">';

   foreach ($res[1] as $key => $value) { 
   # code... 
	echo "$value\n"; 
  } 
  echo '</textarea>'; 
}

function showVariabes($Filename){
	$Str    = file_get_contents($Filename);
	$Search = '/\$[a-zA-Z_][0-9a-zA-Z_]*/';
	preg_match_all($Search, $Str, $res);

	echo '<textarea cols= "80" rows="25">';

	$Unique =[];
	foreach ($res[0] as $key => $value) { 
		$Unique[$value] = 0; 
	}

	ksort($Unique);

	foreach ($Unique as $key => $value) {
		echo "$key\n";
	}
	echo '</textarea>'; 	

}

function generateURLShortcuts(){
	$HomeFolder = $_POST["site-folder"];

	if("" != trim(strstr($_POST["root-folder"],"admin")))
		$PathSuffix = '/admin';
	else
		$PathSuffix = '';
	
	$Urls = simplexml_load_string(
		file_get_contents($Folder_."configure/urls.xml")
	);

	$Urls = getArrayFrom($Urls->url);	

	$Code = file_get_contents(__DIR__."/template.url");

	foreach ($Urls as $url) {
		file_put_contents(
			"$HomeFolder/$url.url",
		   str_replace(
		   	"<url>",
		   	$_SERVER['REQUEST_SCHEME']."://". 
				$_SERVER['HTTP_HOST'].
		   	SITE_PATH.("$PathSuffix/$url"),
		   	$Code
		   )
		);
	}
}

function createSublimeProject(){
	if(is_file($_POST['filename'])){
		$Folder = dirname($_POST['filename']);
	}else{
		$Folder = $_POST['filename'];
	}

	$Realtive_Path = basename($Folder);

	$Code = file_get_contents(__DIR__.'/forbs/sublime-projext.txt');
	$Code = str_replace('<%relative-folder%>', $Realtive_Path, $Code);

	file_put_contents("$Folder/$Realtive_Path".'.sublime-project', $Code);
}

function createIDESettings(){
	if(is_file($_POST['filename'])){
		$Folder = dirname($_POST['filename']);
	}else{
		$Folder = $_POST['filename'];
	}

	$Realtive_Path = basename($Folder);

	if(!is_dir("$Folder/forbidden")){
		mkdir("$Folder/forbidden");
	}

	copy(__DIR__.'/forbs/.htaccess',"$Folder/.htaccess");
	copy(__DIR__.'/forbs/db_connect.php', "$Folder/forbidden/db_connect.php");
	copy(__DIR__.'/forbs/db_connect-fake.php', "$Folder/forbidden/db_connect-fake.php");
	copy(__DIR__.'/forbs/config.php', "$Folder/forbidden/config.php");

	$Code_Str = file_get_contents("$Folder/forbidden/config.php");
	$Code_Str = str_replace('<%relative-folder%>', $Realtive_Path, $Code_Str);

	file_put_contents("$Folder/forbidden/config.php", $Code_Str);

	if(!is_dir("$Folder/forbs")){
		mkdir("$Folder/forbs");
		mkdir("$Folder/forbs/phplite");
	}

	copy(__DIR__.'/forbs/lessons.sqlite',"$Folder/forbs/lessons.sqlite");
	copy(__DIR__.'/forbs/index.php',"$Folder/forbs/phplite/index.php");
	copy(__DIR__.'/forbs/phpliteadmin.config.php',"$Folder/forbs/phplite/phpliteadmin.config.php");
	die;
}
function runScript(){
	$Cmd = "start \"\" ".$_POST['chosen-script'];
	exec($Cmd);
	unset($_POST['task2']);
}
function createFolder(){
	if(is_file($_POST['filename'])   ){
		$Folder = dirname($_POST['filename']);
	}else{
		$Folder = $_POST['filename'];
	}
	mkdir($Folder .'/'.$_POST["new-item"]) ;
}

function createFile(){
	if(is_file($_POST['filename'])   ){
		$Folder = dirname($_POST['filename']);
	}else{
		$Folder = $_POST['filename'];
	}
	
	file_put_contents($Folder .'/'.$_POST["new-item"]," ");
}

function createHTML(){
	if(is_file($_POST['filename'])   ){
		$Folder = dirname($_POST['filename']);
	}else{
		$Folder = $_POST['filename'];
	}
	
	file_put_contents($Folder .'/'.$_POST["new-item"],
'
 <!DOCTYPE html-->
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>New Stuff</title>
		<!--<link rel="stylesheet" href ="index.css?v=2" >-->
	</head>
	<body>
		<div id="asdx">Somebody tell me something</div>
	</body>
</html>
	'
	) ; 
}

function createProFile(){
	$MY_FOLDER =
	dirname(__FILE__); $MY_FOLDER = str_replace("\\", '/', $MY_FOLDER);
	$INCLUDE_CODE =
	'<?php 
	if(is_dir("../../admin")){
		include "../../admin/forbidden/db_connect.php";
	}else{
		include "../../forbidden/db_connect.php";
	}
	include "'.$MY_FOLDER.'/ajax-debug-stuff.php";
	capturePOST(__FILE__);
	pretty_r($_POST);
	pretty_r($_GET);
';		
	
	if(is_file($_POST['filename'])   ){
		$Folder = dirname($_POST['filename']);
	}else{
		$Folder = $_POST['filename'];
	}

	file_put_contents($Folder .'/'.$_POST["new-item"], $INCLUDE_CODE);
}

function launch(){
	$_POST['filename'] = str_replace(" ", "%20", $_POST['filename']);
	$Cmd ="C:\\xampp\\php\\php.exe C:\\scripts\\getAddress.php ".
	$_POST['filename'];

	exec($Cmd);
}

function getExtension($File){
	$FileParts = explode(".",$File);

	$ext  =$FileParts[sizeof($FileParts)-1 ];
	
	$G = array('css','gif','png','jpg','js','php','png','zip','c','cpp','xml','html','txt','rc','java','xml','h');
	if( in_array($ext, $G ) ){
		return    $ext;
	}else{
		return 'default';
	}
}

function getClass($ext){
	$G = array('css','gif','png','jpg','js','php','png','zip','c','cpp','xml','html','txt','rc','java','xml','h');

	if( in_array($ext, $G )){
		return    "fm_file_$ext";
	}else{
		return 'fm_file';
	}
	
}

function phpTidy(){
	$exec_output = [];
	exec(
		'php C:\scripts\phptidy-master\phptidy.php replace '.
		str_replace('/', "\\", $_POST['filename']).' 2>&1',
		$exec_output = []
	);
}

function createCompletionList()
{
	$List = scandir(SITE_FOLDER.'/configure');

	$CompletionList = "";
	foreach ($List as $key1 => $File) {
		if(
			is_file(SITE_FOLDER."/$File") &&
			isset(pathinfo(SITE_FOLDER."/$File")["extension"]) &&
			pathinfo(SITE_FOLDER."/$File")["extension"] = "php"
		){
			$str = file_get_contents(SITE_FOLDER."/configure/$File");
			$Search = '/function\s+([0-9a-zA-Z_]+)\s*\(([^)]*)\)/';
			$res = [];
			preg_match_all($Search, $str, $res);
		/*---------------------------------*/
			$str = "";
			foreach ($res[0] as $key => $value) {
				$str .= $res[1][$key].";".
					$res[1][$key].'(';
				
				$Params = explode(",", $res[2][$key]);
				foreach ($Params as $j => $param) {
					$Params[$j] = '${'.($j + 1).':'.$param.'}';
				}
				$Params = implode(", ", $Params);
				$str.= $Params.');'.$res[1][$key]."\n";
		
				$CompletionList .= $str;
			}
		/*-------------------------------------------*/
		}
	}

	file_put_contents(
		SITE_FOLDER."/completion-list.txt",
		$CompletionList
	);
}