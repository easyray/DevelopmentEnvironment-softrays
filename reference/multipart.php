<?php
if( 
 	isset($_POST["task"]) &&
	"upload-file" == $_POST["task"]
){
/*
Array
(
    [userfile] => Array
        (
            [name] => 230090fbc161a6612bf3264524df5433.jpg
            [type] => image/jpeg
            [tmp_name] => C:\xampp\tmp\php3EA5.tmp
            [error] => 0
            [size] => 23586
        )

)
*/
	move_uploaded_file(
		$_FILES['userfile']['tmp_name'], 
		__DIR__."/uploads/".$_FILES['userfile']['name']
	);
}

?><!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form method="post"  enctype="multipart/form-data" >
		<input type="file" name="userfile" />
		<input type="submit" name="" />
		<input type="hidden" name="task" value="upload-file" />
	</form>
</body>
</html> 