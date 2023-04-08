<?php
if(is_dir("../admin")){
	include "../admin/forbidden/db_connect.php";
}else{
		include "../forbidden/db_connect.php";
}

//include dirname(__FILE__).'/ajax-debug-stuff.php';
	
	$_SERVER["DOCUMENT_ROOT"] = str_replace('\\', '/', $_SERVER["DOCUMENT_ROOT"]);

	$CmpResult =  strcmp(
		$_SERVER["DOCUMENT_ROOT"],
		substr(
			$_POST['rotfolder'],
			0,
			strlen($_SERVER["DOCUMENT_ROOT"])
		) 
	);


	$URL = "";
	$Msg = "";

	if(0==$CmpResult){
		$URL = 'http://'.$_SERVER['HTTP_HOST'].
		substr(	
			$_POST['rotfolder'],
			strlen($_SERVER["DOCUMENT_ROOT"])
		);
	}else{
		$Msg = "The folder is outside the document root";
		
	}

	$MY_FOLDER = dirname(__FILE__);
	$MY_FOLDER = str_replace("\\", '/', $MY_FOLDER);
	define('MY_FOLDER',$MY_FOLDER);


	define("INCLUDE_FILE", MY_FOLDER.'/CapturedData.php');
	define("INCLUDE_CODE", 
'<?php 
	if(is_dir("../../admin")){
		include "../../admin/forbidden/db_connect.php";
	}else{
		include "../../forbidden/db_connect.php";
	}
	include "'.MY_FOLDER.'/ajax-debug-stuff.php";
	include "'.INCLUDE_FILE.'"; 
?>'
	);

?><!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<h3>URL Address and Ajax Data </h3>
	<?php echo $Msg; ?>
	<input type="text" style="width:70%; height: 30px"  value="<?php echo $URL; ?>" id="destination" />
	<input type="text" style="width:70%; height: 30px"  value="" id="destination-2" readonly />
	<br />
	<hr />


<?php
	include ("functions.php");
	

?>

<script>
	function goToDestination(){
		alert("tell me something");
		document.getElementById("dst-form").action = 
		document.getElementById("destination-url").value; 
		document.getElementById("dst-form").submit();
	}
</script>
	Data<textarea rows="4" cols="40" id="textfield"></textarea>
	<br />
	<input type="button" value=" Image-Load " id="Load_Button" />
	<input type="button" value=" Send with Image " id="button1"/>
	<input type="button" value=" Send only Data " id="button2" />
	<input type="button" value=" Generate URL "   id="button3" />
	<br />
	POST<input type="radio" name="meth" value="1" id="use-post" checked="1" /><BR>
	GET<input type="radio" name="meth" value="1" id="use-get"  /><br/>
	
	<textarea id="result" rows="20" cols="50"></textarea>

<script src="jquery-1.9.1.js" ></script>
<script src="ajaxupload.3.5.js?v=2" ></script>
	
<script type="text/javascript">

	var xUploader = "";
	
	function setupUploader(){
		if(xUploader !="")xUploader.destroy();
		
		var Method = ($("#use-get")[0].checked)? 'GET': 'POST';
		//console.log("did it!!!");
		var JsonObject = {
			action: $("#destination").val(),
			name  : 'userfile',
			method: Method,
			autoSubmit: false,
			onComplete: completed
		}
		
		var Load_Button = $("#Load_Button").get(0);
		
		xUploader = new AjaxUpload(Load_Button, JsonObject);
	}
	
	
	$("#destination").bind("change", setupUploader);
	$("#use-get").bind("change", setupUploader);
	$("#use-post").bind("change", setupUploader);


	$("#button1").click(
		function(){
			
			xUploader.setData(eval("("+$("#textfield").val()+")"));
			xUploader.submit();
			

		}
	);
	
	$("#button2").click(
		function(){

			var Data =(eval("("+$("#textfield").val()+")"));
			var Method = ($("#use-get")[0].checked)? 'GET': 'POST';
			console.log(Data);
			$.ajax(
				{
					url: $("#destination").val(),
					type: Method,
					success: completed,
					data:   Data,
					error: function(a,b,c){
						console.log (a+b+c);
					}
				}
			);
			

		}
	);		
	
	function evaluate(str){
		return window['eval']('('+str+')');
	}

	function explodeobj(obj,arrayname){
		var str ="";
		var len =  obj.length;

		for(var i in obj){
			if('object'  == typeof(obj[i])){
				str += "&"+explodeobj(obj[i],i);
			}else{
				if(arrayname){
					str+= '&'+arrayname+'%5B%5D='+obj[i];
				}else{
					str += '&'+i+'='+obj[i];
				}
			}
		}

		str = str.replace("&",'?');

		return str;
	}

	$("#button3").click(
		function (){
			var items = evaluate($('#textfield').val());
			var qstr = explodeobj(items);
			document.getElementById('destination-2').value =
			$('#destination').val()+qstr;
		}
	);

	function completed(stuff1,stuff2,stuff3){
		$("#result").html("stuff1: "+stuff1+"\nStuff2: "+stuff2+"\nStuff3: "+stuff3);
	}
	
	setupUploader();
</script>

</body>
</html>	