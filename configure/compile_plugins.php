<?php
	include ("functions.php");

	
	if(is_file("plugins.xml")){
		$Plugins = simplexml_load_string(file_get_contents("plugins.xml"));

		$Plugins = getArrayFrom($Plugins->plugin);
		
		if(!is_dir("../plugins")){
			mkdir("../plugins");
		}

		
		foreach ($Plugins as $key => $value) {
			mkdir("../plugins/$value");
		}

		foreach ($Plugins as $key => $value) {
			file_put_contents("../plugins/$value/$value.php","<?php class $value{
				function onAfterInitialise(){}
			} ?>");
		}
		

		
	}// end if	

