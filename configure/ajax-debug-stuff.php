<?php

	define('POST_CAPTURE_CODE', '<?php capturePOST1(__FILE__); ?>');
	define('GET_CAPTURE_CODE' , '<?php captureGET  (__FILE__); ?>');

	function captureGET($Filename){
		$src = file_get_contents($Filename);
		$stuff = ''.json_encode($_GET).'';
		$src =str_replace(GET_CAPTURE_CODE, "$stuff", 	$src );
		
		file_put_contents($Filename, $src); die;
	}

	function capturePOST1($Filename){
		$src = file_get_contents($Filename);
		$stuff = ''.json_encode($_POST).'';
		
		$src =str_replace(POST_CAPTURE_CODE, "$stuff", 	$src );
		
		file_put_contents($Filename, $src); die;
	}
	
	function capturePOST($Filename){
		$src = file_get_contents($Filename);
		$stuff = '/*'.print_r($_POST,true).json_encode($_POST).'*/';
		$src =str_replace("capturePOST", "$stuff\n//", $src);
		file_put_contents($Filename, $src); die;
	}	
?>