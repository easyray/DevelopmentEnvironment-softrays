<?php
	include ("functions.php");

	
	if(is_file("modules.xml")){
		$Modules = simplexml_load_string(file_get_contents("modules.xml"));

		$Modules = getArrayFrom($Modules->module);
		
		if(!is_dir("../modules")){
			mkdir("../modules");
		}


		foreach ($Modules as $key => $value) {
			mkdir("../modules/$value");
		}

		foreach ($Modules as $key => $value) {
			file_put_contents("../modules/$value/$value.php","<?php defined('_JEXEC') or die ?>");
		}
		

		
	}// end if	