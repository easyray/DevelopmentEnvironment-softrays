<?php

	function copy_folder($Src, $Dst){
		$List = scandir($Src);
		echo "<pre>";
		print_r($List);
		echo "</pre>";
		foreach ($List as $key => $value) {
			if(
				"." != $value &&
				".."!= $value &&
				is_file("$Src/$value")
			){
				copy("$Src/$value", "$Dst/$value");
			}else if(
				"." != $value &&
				".."!= $value &&
				is_dir("$Src/$value")
			){
				mkdir("$Dst/$value");
				copy_folder("$Src/$value", "$Dst/$value");
			}
		}
	}