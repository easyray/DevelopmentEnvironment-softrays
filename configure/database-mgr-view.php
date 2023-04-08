<?php 
	if( 
	 	isset($_POST["delete"]) &&
		"delete" == $_POST["delete"]
	){
		include ($_REQUEST['root-folder']."/forbidden/db_connect.php");
		unlink(
			$_REQUEST['root-folder']."/forbs/".$_REQUEST['filename'].
			'_'.
			$_REQUEST['date']
		);
	}elseif( 
	 	isset($_POST["use"]) &&
		"Use" == $_POST["use"]
	){
		include ($_REQUEST['root-folder']."/forbidden/db_connect.php");
		copy(
			$_REQUEST['root-folder']."/forbs/".$_REQUEST['filename'].
			'_'.
			$_REQUEST['date'],
			DATABASE_FILE	
		);
	}
?><!DOCTYPE html-->
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Manage Project Database</title>

		<link rel="stylesheet" href ="css/prototype.css" >
		<link rel="stylesheet" href ="css/main.css" >
	</head>
	<body>
		<div id="asdx">
			<div id="container">
	<section id="header">
		<div id="logo" class="div20 ">
			<img src="photos/SQLite370.svg..png">
		</div>
			<div class="div50 ">
				<div id="intro-top-spacer"></div>
				<div id="intro">
					<article>
						<h3>SQLite database Manager</h3>
In fermentum posuere urna nec. Aliquet enim tortor at auctor urna nunc id cursus. Penatibus et magnis dis parturient. Urna neque viverra justo nec ultrices dui sapien eget. Ac orci phasellus egestas tellus rutrum tellus pellentesque eu. Cursus mattis molestie a iaculis at. Mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Volutpat lacus laoreet non curabitur gravida arcu ac tortor. Sollicitudin nibh sit amet commodo nulla facilisi nullam vehicula. Habitant morbi tristique senectus et netus et malesuada fames. Et pharetra pharetra massa massa ultricies mi. At consectetur lorem donec massa. Massa tincidunt dui ut ornare lectus. Pharetra convallis posuere morbi leo urna. Volutpat lacus laoreet non curabitur gravida arcu ac. Quam lacus suspendisse faucibus interdum posuere lorem.

Eget lorem
					</article>
				</div>
			</div>
	</section>
	<section id="work-area" class="div90 ">
		<div id="commands" class="div40 " style="max-height: 250px; overflow-y: scroll; overflow-x: hidden;">
			<ul class="u-menu">
				<li>
					<a id="v-bakup">Backup Database</a>
					<div id="hidden-note" style="display: none;" class="middle-div">
						<h4>Description notes</h4>
						<input id="cancel-backup" type="button" class="std-input" value="Cancel" />
						<textarea style="width: 98%" rows="10"></textarea>
						<input type="button"class="std-input" value="Backup" id="bakup">
					</div>	
				</li>
				<li><a id="resto">Restore Database</a></li>

				<li><a id="expor" href="database-mgr-2.php?root-folder=<?php
					if($_REQUEST['root-folder']){
						echo $_REQUEST['root-folder'];
					}/*else*/  
				?>&task=<?php echo  "export" ; ?>">
					Export SQL (all)</a>
				</li>
				<li><a id="expor2" href="database-mgr-2.php?root-folder=<?php
					if($_REQUEST['root-folder']){
						echo $_REQUEST['root-folder'];
					}/*else*/  
				?>&task=<?php echo  "export-2" ; ?>">
					Export SQL (structure)</a>
				</li>
				<li>
					<a id="impor">Import SQL</a>
					<form style="display: none;" id="upload-form" method="post"  enctype="multipart/form-data" action="database-mgr-2.php">
					<input type="file" name="userfile" class="std-input" /><br />
					<input type="hidden" name="task" value="import" />
					<input type="hidden" name="root-folder" value="<?php
						if($_REQUEST['root-folder']){
							echo $_REQUEST['root-folder'];
						}/*else*/  
					?>" />
					<input type="submit" value="upload" class="std-input" />
					<br>
					<span class="smaller" style="color: red">
						Note that importing may overwrite database content 
					</span>
					</form>
				</li>
				
			</ul>
		</div>
		<div id="query-boxes" class="div50 ">
			<form method="post">
			<select class=" std-input" id="command-dd">
				<option value="">
					Commands
				</option>
				<option value="change-t-name">Change Table Name</option>
				<option value="change-c-name">Change Column Name</option>
				<option value="add-col">Add Column</option>
				<option value="remove-col">Remove Column</option>
			</select>
			<div id="tables-dd"></div>
			<div id="cols-dd"></div>
			<textarea class="std-input" style="height: 150px" name="cmd-SQL" id="sql-cmd" rows="35" cols="20"></textarea>
			
			</form>
		</div>
		</section>
	</div>		
	</div>
	<!-- <script src ="js/jquery-debug.js" ></script> -->
	<script src ="js/jquery-1.9.0.min.js" ></script>
	<script src ="js/manage-database.js?v=12" ></script>
	<input type="hidden" id="root-folder" value="<?php
		if($_REQUEST['root-folder']){
			echo $_REQUEST['root-folder']; }/*else*/  
	?>" />
	<?php if(isset($_REQUEST['use'])): ?>
	<script type="text/javascript">
		alert("Database changed");
	</script>
	<?php elseif(isset($_REQUEST['delete'])): ?>
	<script type="text/javascript">
		alert("Backup deleted");
	</script>
	<?php endif; ?>
	<div id="hidden-menu" style="display: none;"></div>
	</body>
</html>
 