<?php

	if( 
	 	isset($_POST["admin"]) &&
		""!= $_POST["admin"]
	){
		$Sections = simplexml_load_string(file_get_contents(
			$_POST['site-folder'].'/admin/configure/sections.xml'
		));
	}else{
		$Sections = simplexml_load_string(file_get_contents(
			$_POST['site-folder'].'/configure/sections.xml'
		));	
	}
	
	

	include __DIR__."/functions.php";
	$SN = 1;
?><!DOCTYPE html>
<html>
	<head>
		<title>Assign Default modules</title>
		<style type="text/css">
			div#extractable{
				display: none;
			}
		</style>
	</head>
	<body>
		<div id="extractable"><?php include $_POST['filename'] ; ?></div>
		<h2>Match id to section to module</h2>
		<form method="post" action="save-extract-tempate.php">
		<table style="border-collapse: collapse;" border="1" cellpadding="5">
		<tbody>
			<tr>
				<th>SN</th>
				<th>Section-id</th>
				<th>Section-Name</th>
				<th>Module</th>
			</tr>
		<?php foreach ($Sections as $SectionName): ?>
			<tr>
				<td><?php echo $SN++; ?></td>
				<td><div class="section-nest"></div></td>
				<td>
					<?php echo $SectionName; ?>
					<input type="hidden" name="section[]" value="<?php echo  $SectionName ; ?>" />
				</td>
				<td><input type="text" name="module[]" /></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
		</table>
		<input type="hidden" name="filename" value="<?php echo  $_POST['filename'] ; ?>" />
		<input type="hidden" name="site-folder" value="<?php echo  $_POST['site-folder'] ; ?>" />
		<input type="submit" value="  Extract  " />

		</form>
	</body>
</html>
<script type="text/javascript">
	
	function getIdAndClass(obj,arr,counter){			
		
		var counter2, Children,len,index3;
		
		Children = obj.children;
		
		len = Children.length;
		var ret;
		for(counter2 = 0; counter2< len; counter2++){
			ret = getIdAndClass(Children[counter2],arr,counter);
			counter = ret[1];
			if(Children[counter2].id !=""){
				arr[counter++] = ""+Children[counter2].id;
			}
		}
		
		return [arr,counter];
	}

	G = getIdAndClass(document.getElementById('extractable'),[],0);
	IDs = G[0];

	Str = '<select name="section_ids[]" > ' ;  
	for(Id in IDs){
		Str += '<option  value="'+IDs[Id]+'">'+IDs[Id]+'</option>' ;  
	} 
	Str += '</select>';

	Dsts = document.getElementsByClassName('section-nest');

	len = Dsts.length;
	for(i=0; i<len; i++){
		Dsts[i].innerHTML = Str;
	}

</script>