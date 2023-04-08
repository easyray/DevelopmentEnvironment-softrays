<?php 
	if(!isset($_SERVER['REQUEST_SCHEME'])){
		$_SERVER['REQUEST_SCHEME'] = 'http';
	}

	if(!isset($_SERVER['DOCUMENT_ROOT'])){

		$SNArray  = explode('/', $_SERVER['SCRIPT_FILENAME']);
		$Len = sizeof($SNArray);
		
		$DcoRoot ='';
		for($c=0; $c<($Len-2) ; $c++){
			if($c != 0){
				$DcoRoot .= '/'	;
			}
			$DcoRoot .= $SNArray[$c];

		}

		$_SERVER['DOCUMENT_ROOT'] = $DcoRoot;
	}
	
	if(isset($_GET['p'])){

		echo'<pre>';
			print_r ($_GET);
		echo '</pre>';
	}
 	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type" />
    <title>Experimenting on TinyMce</title>
	<style type ="text/css">
		#MCE-style{
			margin-left: 50px;
			margin-top:  60px;
			float: left;
			margin-right: 20px;
		}
	</style>
	<script src="js/tinymce/tinymce.js?v=2" type="text/javascript" ></script>
	<script src="js/tinymce/plugins/table/plugin.js" type="text/javascript" ></script>
	<script src="js/tinymce/plugins/paste/plugin.js" type="text/javascript" ></script>
	<script src="js/tinymce/plugins/spellchecker/plugin.js" type="text/javascript" ></script>
	<script src="js/tinymce/plugins/form/plugin.js" type="text/javascript" ></script>
	<script src="js/jquery-1.9.1.js"></script>
	
	
<script type="text/javascript">
	tinymce.init({
		selector: "#mytextarea",
		width: 650,
		height: 300,
		relative_urls : false,
		remove_script_host: true,
		document_base_url : "<?php echo $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/webDML' ?>",

		plugins: [
			"advlist autolink autosave link image lists charmap print preview hr anchor pagebreak ",
			"searchreplace visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
			"save table contextmenu directionality emoticons template textcolor paste  textcolor colorpicker save  code_wrap change_node insert_code mypictures form"
		],
		toolbar: " undo redo | styleselect bullist numlist | bold italic | link my_picture image | code_wrap change_node insert_code myform",
		style_formats: [
			{title: 'Heading 1', block: 'h1'},
			{title: 'Heading 2', block: 'h2' },
			{title: 'Label', block: 'div', classes: 'label'}
		],
		
		nonbreaking_force_tab:{"format":"&nbsp;&nbsp;&nbsp;&nbsp;"},
		content_css : "/webDML/tinyMCE/css/style.css"		
	});
	
</script>

</head>
<body>
	<div id="MCE-style" id="fetchfile">
		<h1>TinyMCE Getting Started Guide</h1>

		<form method="post" action="SaveFile.php" id="solid-form">
			<textarea id="mytextarea" name="html-code" ></textarea>
			<input type="button" id="save-file" value="  JS Code  " />
			<input type="button" id="save-file-2" value=" PHP Code " />
			<input type="button" id="save-file-3" value=" PHP Code 2" />
			<input type="button" id="load-css" value="  Load Css " />
		</form>

	</div>

	<div id="code-result" style="float: left; margin-top: 180px">
		<textarea cols="50" rows="10"><?php
		if( 
		 	isset($Code) &&
			"" != $Code
		){
			echo $Code;
		}
		?></textarea>
	</div>
	
	<script type = "text/javascript" >

		$("#save-file"  ).bind("click",saveFile);
		function saveFile(){
			var Str ;
			Str = tinyMCE.activeEditor.getContent() ;
			Str = Str.replace(/'/g, "\\'");
			Str = "stuff = '"+Str;
			Str = Str.replace(/\n/g, "'+\n'");
			Str = Str.replace(/_dat/g, "'+dat+'");
			Str = Str.replace(/<!--\?php/g, " ' ;  \n");
			Str = Str.replace(/\?-->/g, "\n stuff += '");			
			$("#code-result textarea").html(Str);
			//console.log(Str);
		}
		
		
		$("#save-file-2"  ).bind("click",saveFile2);
		function saveFile2(){
			var Str ;
			Str = tinyMCE.activeEditor.getContent() ;
			Str = Str.replace(/_dat/g, "<?php echo  '<?php echo $stuff; ?>'; ?>");
			Str = Str.replace(/<!--\?/g, <?php echo '" \n <?"'; ?>);
			Str = Str.replace(/\?-->/g, "\n ?>");
			$("#code-result textarea").html(Str);
			//console.log(Str);
		}				
		
		$("#save-file-3"  ).bind("click",saveFile3);
		function saveFile3(){
			var Str ;
			Str = tinyMCE.activeEditor.getContent() ;
			Str = Str.replace(/'/g, "\\'");
			Str = "$Str = '"+Str;
			Str = Str.replace(/\n/g, "'.\n'");
			Str = Str.replace(/_dat/g, "'.$stuff.'");
			Str = Str.replace(/<!--\?php/g, " ' ;  \n");
			Str = Str.replace(/\?-->/g, "\n $Str .= '");			
			$("#code-result textarea").html(Str);
			//console.log(Str);
		}

		$("#load-css"  ).bind("click",loadCSS);
		
		function loadCSS(){
			var Str ;
			Str = $("#code-result textarea").val() ;
			
			dat = {"css": Str };

			$.ajax(
				{
				
				"url": "load-css.php",
				"type": "post",
				"data": dat
				}
			);
		}
		
function findThisAttr(obj,attr){

	for(var i in obj){
		if(i == attr){
			console.log(i); return ;
		}else if(findThisAttr(obj[i], attr)){
			console.log(i); return ;
		}
	}

}
	window.onload=function(){
		tinyMCE.activeEditor.setContent($("#code-result textarea").html()) ;

	}
	</script>
}
</body>
</html>