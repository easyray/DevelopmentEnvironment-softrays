<?php

if( 
 	isset($_POST["task"]) &&
	"project.create" == $_POST["task"]
){

	$Projects = objToArray(json_decode(file_get_contents('projects.txt')));
	
	if( 
	 	isset($_POST["copy-and-create"]) &&
		"" != $_POST["copy-and-create"]
	){
		$_POST["task"] = "install" ;
		$_POST['dst']  = basename($_POST['folder']);
		$_POST['database'] = $_POST["dst"].".sqlite";
		include __DIR__.'/../new_Mvc_php/index.php';
		$_POST["folder"] = dirname(__DIR__).'/'.$_POST["dst"];
	}

	$Projects[] = array(
		"name"=>$_POST['name'],
		"folder"=>$_POST['folder']
	);
	file_put_contents('projects.txt', json_encode($Projects));
	
}

if( 
	 	isset($_POST["task"]) &&
		"remove" == $_POST["task"]
){
	

	$Projects =json_decode(file_get_contents("projects.txt" )) ;
	$Projects = objToArray($Projects);

	$NewProjects = [];
	foreach ($Projects AS $Project) {
		if($Project['folder']!= $_POST['filename'])	{
			$NewProjects[] = $Project;
		}
	}
	file_put_contents('projects.txt', json_encode($NewProjects));

}
$Projects =json_decode(file_get_contents("projects.txt" )) ;
$Projects = objToArray($Projects);
?><!DOCTYPE html>
<html>
<head>
	<title>PHP-MVC Projects</title>
</head>
<body>

	<table border="" style="border-collapse: collapse;">
		<tbody>
		<tr>
		<td><h3>Projects</h3></td>
		<td>col-2</td>
		<td>col-3</td>
		<td>col-4</td>
		<td>col-5</td>
		</tr>

		 <?php foreach($Projects AS $project): ?>
		<tr> 
			<td><?php echo $project['name']; ?></td>
			<td>
				<input name="root-folder" type="text" value="<?php echo $project['folder']; ?>" />
			</td>
			<td>
				<form method="post" action="configure/index.php" target="_blank" >
					<input name="root-folder" type="hidden" value="<?php echo $project['folder']; ?>" />
					<input   type="submit" value="Manage" />
				</form>
			</td>
			<td>
				<form method="post" action="configure/show-a-page.php?root-folder=<?php echo  $project['folder']; ?>" target="_blank" >
					<input name="root-folder" type="hidden" value="<?php echo $project['folder']; ?>" />
					<input name="filename" type="hidden" value="<?php echo $project['folder']; ?>" />
					<input type="hidden" name="task" value="show-folder-2" />
					<input   type="submit" value="Open" />
				</form>
			</td>
			<td>
				<form method="post" >
					<input name="filename" type="hidden" value="<?php echo $project['folder']; ?>" />
					<input type="hidden" name="task" value="remove" />
					<input   type="submit" value="Remove" />
				</form>
			</td>					
		 </tr>
		 <?php endforeach; ?>

		</tbody>
	</table>
	<h3>New</h3>
	<form method="post">
	Name <input type="text" name="name"/>	<br />
	Folder <input type="text" name="folder"/>	
	<input type="submit" value="create" />
	<input type="submit" value="create and copy files" name="copy-and-create" />
	<input  name="task" type="hidden" value="project.create" />
	</form>

<table>
	<tr> 
		<td>Default</td>
		<td>
			<input type="text" value="<?php echo __DIR__; ?>" />
		</td><td>
			<form method="post" action="configure/index.php" target="_blank" >
				<input name="root-folder" type="hidden" value="<?php echo __DIR__; ?>" />
				<input   type="submit" value="Manage" />
			</form>
		</td><td>
			<form method="post" action="configure/show-a-page.php" target="_blank" >
				<input name="root-folder" type="hidden" value="<?php echo __DIR__; ?>" />
				<input name="filename" type="hidden" value="<?php echo __DIR__; ?>" />
				<input type="hidden" name="task" value="show-folder-2" />
				<input   type="submit" value="Open" />
			</form>
		</td>					
	 </tr>	
</table>	
</body>
</html><?php

function objToArray($Obj){
	$ret = array();
	foreach($Obj AS $Key=> $Value){
		if(gettype($Value)	=="object"){
			$ret[$Key]= objToArray($Value);
		}else{
			$ret[$Key]= $Value;
		}
	}//end foreach
	
	return $ret;
}
