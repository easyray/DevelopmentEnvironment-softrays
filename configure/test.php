<?php 
$Images  = array( 'css.png','default.png','gif.png','html.png','jpeg.png','js.png','php.png','png.png','zip.png' );
$Ext         = array('css','default','gif','png','jpg','js','php','png','zip' );

function getExtension($File){
	$FileParts = explode(".",$File);

	$ext  =$FileParts[sizeof($FileParts)-1 ];
	
	$G = array('css','gif','png','jpg','js','php','png','zip');
	if( in_array($ext, $G ) ){
		return    $ext;
	}else{
		return 'default';
	}
}

function getClass($ext){
	$G = array('css','gif','png','jpg','js','php','png','zip');
	if( in_array($ext, $G )){
		return    "fm_file_$ext";
	}else{
		return 'fm_file';
	}
	
}


foreach($Ext AS $Key => $value){
	$class = getClass($value);
	$img   = $Images[$Key];
	echo "
	<pre>
	
	.$class{
		display: inline-block;
		width:  16px;
		height: 16px;
		background-image: url(../pix/$img);
		background-size: 100% 100%;
	}
	</pre>
	";
	
}
/*
.fm_file{
	display: inline-block;
	width:  16px;
	height: 16px;
	background-image: url(../pix/text.png);
	background-size: 100% 100%;
}
*/
?>