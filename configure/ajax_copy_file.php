	<?php

	if(is_dir("../../admin")){
	include "../../admin/forbidden/db_connect.php";
	}else{
	include "../../forbidden/db_connect.php";
	}

	/*Array
(
    [selected] => /storage/sdcard0/paw/html/edu-prj/admin/configure
)
*/

file_put_contents("copy.csv", $_POST["selected"]);
		class ReturnObject{
			var $posted,
			$output;
		}
		
		
		$RO = new ReturnObject();
		$RO -> posted = $_POST;
		$RO -> output = "success";


	echo json_encode($RO);
	