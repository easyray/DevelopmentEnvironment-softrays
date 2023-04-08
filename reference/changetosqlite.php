<?php
print_r($_GET);
print_r($_POST);
if (isset($_GET['source-file'])){

	$S_R = array(
		array("mysqli_real_escape_string\s*\(\s*(\\$\w+)","sqlite_escape_string(/*$1*/"),
		array("mysqli_connect","sqlite_open(DATABASE_FILE);//"),
		array("mysqli_query", "sqlite_query"),
		array("mysqli_num_rows", "sqlite_num_rows"),
		array("mysqli_fetch_array","sqlite_fetch_array"),
		array("MYSQLI_ASSOC","SQLITE_ASSOC"),
		array("mysqli_connect_errno","sqlite_last_error(\$connect);//")
	);

	$Code = file_get_contents($_GET['source-file']);
	echo "<textarea>".htmlentities($Code)."</textarea>";

	foreach ($S_R as $key => $value) {
		$Code = preg_replace('/'.$value[0].'/', $value[1], $Code) or die($value[0]);
	}

	file_put_contents($_GET['source-file'], $Code);
}
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<p><strong>Convert to SQLITE code</strong></p>
<form>
<table>
<tbody>
<tr>
<td>File Name</td>
<td><input name="source-file" type="text" /></td>
</tr>
<tr>
<td> </td>
<td><input  type="submit" value="convert" /></td>
</tr>
</tbody>
</table>
</form>
</body>
</html>