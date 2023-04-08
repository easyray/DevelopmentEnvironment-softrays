<div id="footer" >
  
    <span class="nav-item"><a href="article-mgr.php?root-folder=<?php echo  $_REQUEST['root-folder'] ; ?>">Article Magic</a></span>
    <span class="nav-item"><a href="admin-menu.php?root-folder=<?php echo  $_REQUEST['root-folder'] ; ?>">Admin Menu</a></span>
    <span class="nav-item"><a href="privileges.php?root-folder=<?php echo  $_REQUEST['root-folder'] ; ?>" >Privleges</a></span>    
	<span class="nav-item"><a href="show-a-page.php?root-folder=<?php echo  $_REQUEST['root-folder'] ; ?>">Page Flow</a></span>
    <span class="nav-item"><a href="database-mgr.php?root-folder=<?php echo  $_REQUEST['root-folder'] ; ?>">Database</a></span>
<span style="display: none;" id="kill-thing">
	<span class="nav-item">
		<a href="compile.php?root-folder=<?php echo  $_REQUEST['root-folder'] ; ?>">Compile</a>
	</span>

<br />
	<form  action="extract-sections.php"  	target="_blank" method="post" style="display: inline"> 
		<input type="hidden" name="site-folder" value="<?php 
			if(!isset($_REQUEST['root-folder']) ){
				echo  SITE_FOLDER ; 
			}else{
				echo $_REQUEST['root-folder'];
			}
		?>" />
		<input name="task" value="show-folder-2" type="hidden" />
		<input value="Find Candidate sections" type="submit" />
		<input name="filename" value="" type="text" placeholder="File-name" />
		<input type="checkbox" name="admin" /><span style="color: #ddd;">Admin</span>
	</form><br />

	<form style="display: inline" method="post"> 
		<input name="task" value="ide.settings" type="hidden"/> 
		<input value="Add IDE Settings" type="submit" />
		<input type="hidden" name="site-folder" value="<?php 
			if(!isset($_REQUEST['root-folder']) ){
				echo  SITE_FOLDER ; 
			}else{
				echo $_REQUEST['root-folder'];
			}
		?>" />
	  </form><br />
	  
	  <form style="display: inline" method="post"> 
		<input name="task" value="sublimeproject" type="hidden"/> 
		<input value="Sublime Project" type="submit" />
		<input type="hidden" name="site-folder" value="<?php 
			if(!isset($_REQUEST['root-folder']) ){
				echo  SITE_FOLDER ; 
			}else{
				echo $_REQUEST['root-folder'];
			}
		?>" />		  
	  </form><br />

	  <form style="display: inline" method="post"> 
		<input name="task" value="url-shortcuts" type="hidden"/> 
		<input value="Create url-shortcuts" type="submit" />
		<input type="hidden" name="root-folder" value="<?php 
			if(!isset($_REQUEST['root-folder']) ){
				echo  SITE_FOLDER ; 
			}else{
				echo $_REQUEST['root-folder'];
			}
		?>" />
		<input type="hidden" name="site-folder" value="<?php echo  SITE_FOLDER ; ?>" />
	  </form><br />
</span>

<input type="button" onclick="toggle()" style="display:inline-block; float: right;" />


<script>
	function toggle(){
		var k;
		k = document.getElementById("kill-thing");
	
		if(k.style.display=="none"){
			k.style.display="inline";
		}else{
			k.style.display="none";
		}//end if
	}
</script>
</div>