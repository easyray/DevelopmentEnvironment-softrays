<?php
/*
There are 2 parts to this program
1. This page finds all the elements with an ID in the supplied template file and sends the result  to 
2. use-section-stuff.php which provides you with the text-boxes to supply alternative section names

Part 2 automatically writes the sections.xml configure file, which can be used to easily setup sections for new project templates

Would be a good Idea to make sure there are no existing values that you need in the pre-existing sections.xml as they will be overwritten

A new part has been added: The second  page now presents input boxes for module names and provides a button to take us to page 3, where the template will be autmatically setup, modules created and filled in
It saves module name etc.
*/
?>
<!DOCTYPE html>
<html>
<head>
	<title>Candidate sections</title>
</head>
<body>
<div id="xml-pageb87c9a66be256a833d5b627023733552"><?php
	include $_POST['filename'];
?></div>
<form action="use-section-stuff.php" method="post" >
	<textarea rows="10" cols="30" id="lemont" name="sections"></textarea>
	<input type="submit" value="     Use     " />
	<input type="hidden" name="site-folder" value="<?php
		if($_POST['site-folder']){
			echo $_POST['site-folder'];
		}/*else*/  
	?>" />
	<input type="hidden" name="admin" value="<?php
		if(isset($_POST['admin'])){
			echo $_POST['admin'];
		}/*else*/  
	?>" />

</form>


<script src="js/extract.js"></script>
</body>
</html>