<?php
	function makeFolder($str){
		
		$folders = explode("/",$str);
		
		//$ThisFile = str_replace("\\", "/", dirname(__FILE__) )."/../$str";
		
		
		if(is_file("$str")){
			$L = sizeof($folders);
		}elseif(is_dir("$str")){
			$L = sizeof($folders)+1;
		}else{
			die("$str does not exist \n");
		}
		
		$folder =".";
		
		for ($c =0 ; $c<$L-1; $c++) {
			$folder .= "/".$folders[$c];
			if(!is_dir($folder)){
				mkdir($folder);
			}
			
		}
	}
	
