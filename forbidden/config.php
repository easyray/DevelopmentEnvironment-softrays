<?php
	$KList = array(
		"ACCOUNTS"=>256,
		"USERS"=>128,
		"SESSION"=>64,
		"CLASSES"=>32,
		"PRINCIPAL_COMMENT"=>16,
		"SUBJECT"=>8,
		"STUDENT"=>4,
		"COMMENTS"=>2,
		"RESULT"=>1
	);

	$K_PRIVILEGE_LIST =$KList ;

	foreach($KList AS $Key => $Value){
		define($Key,$Value);
	}

	define("RELATIVE_FOLDER",'php-mvc-IDE');
	define("DATA_FILE", "mvc_db.sqlite");
?>