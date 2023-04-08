<?php
if( 
 	isset($_POST["task"]) &&
	"show-folder-2" == $_POST["task"]
){
	if( isset($_POST["admin"])){
		$ListOfMap = file_get_contents($_POST['site-folder']."/admin/configure/section-module.json");
	}else{
		$ListOfMap = file_get_contents($_POST['site-folder']."/configure/section-module.json");
	}

	
	include $_POST['filename'];
}


if( 
 	isset($_POST["task"]) &&
	"map-modules-content" == $_POST["task"]
){
	$index1 = strpos ( $_POST['density'], '<!-- working code started -->' );
	$index2 = strpos ( $_POST['density'], '<!-- working code ended -->' );

	$WC = substr ( $_POST['density'] , $index1,30+$index2-$index1  );

	$Coyote = '<';
	$Coyote .= '?php';

	$QCoyote = '?';
	$QCoyote .='>';

	$_POST['density'] = str_replace('<!--?php', $Coyote, $_POST['density']);
	$_POST['density'] = str_replace('?-->', $QCoyote, $_POST['density']);
	$_POST['density'] = str_replace($WC, "", $_POST['density']);

	

	if(!is_dir($_POST['filename'].'/templates/'.$_POST["template"])){

		mkdir($_POST['filename'].'/templates/'.$_POST["template"]);
	}


	
	file_put_contents(
		$_POST['filename'].'/templates/'.$_POST["template"].'/index.php',
		$_POST['density']
	);

	die("dusted");
}

?>

<!-- working code started -->
<div id="list-of-sections-div" >
	code extracted<br />
	<textarea id="list-of-sections" style="display: none;"><?php 
		if(isset($ListOfMap)){
			echo  $ListOfMap ; 
		}
	?></textarea>
	<input type="button" value="Show Extracted Code" onclick="trans()" />



<form method="POST">
	<textarea id="density" rows="20" cols="60" name="density"></textarea>
	<input type="hidden" name="task" value="map-modules-content" />
	<input type="hidden" name="filename" value="<?php 
	if(isset($_POST['site-folder'])){
		if( isset($_POST["admin"])){
			echo  $_POST['site-folder'].'/admin' ; 
		}else{
			echo  $_POST['site-folder'] ; 
		}
	}
	?>" />
	<input type="text" name="template" placeholder="template name" />
	<input type="submit" value=" Save template " />
</form>

<script type="text/javascript">
	
	$List = evaluate(document.getElementById('list-of-sections').value );
	//document.getElementById('list-of-sections-div').innerHTML = "";

	var Str= document.head.outerHTML + document.body.outerHTML;
	var i_HTML, i_HTML_0;

	var LT ="<";
	LT+="?php";

	for(var i in $List){

 		if(document.getElementById(""+i)){
			document.getElementById(""+i).innerHTML = 
				LT + "\n" +
				'<!--'+i+' BEGINS -->\n'+
			    "$Inc = route($PageName, '"+i+"'); \n"+
			    "foreach ($Inc AS $value) { include($value); } \n ?"+
				">"	+
				document.getElementById(""+i).innerHTML+
				'\n<!--'+i+' ENDS -->';
		}
	}

//----------------------------------------------
function evaluate(str){
	return window['eval']("("+str+")");
}
//----------------------------------------------

function getBy_ltpp_Pattern(Str_pat, Str){
	
	return (Str.indexOf('&lt;%'+Str_pat+'%&gt;') != -1);
}

function getHTMLtBy_ltpp_Pattern(Str_pat, Str){
	var Index1, Index2;

	Index1 	= Str.indexOf('&lt;%'+Str_pat+'%&gt;');
	Index2 	= Str.indexOf('</%'+Str_pat+'%>');

	if(Index1>0 && Index2>0){
		Str.substring(Index1+Str_pat.length+4, Index2);
	}else{
		return "";
	}
}

function trans(){
	var Head = document.head.outerHTML.replace(/&lt;%/g,'<%').replace(/%&gt;/g,'%>');
	BodI = document.body.outerHTML.replace(/&lt;%/g,'<%').replace(/%&gt;/g,'%>');
	
	document.getElementById('density').value = LT+' include "router.php"; ?>'+
	'<html>\n'+ Head+BodI+
	'\n</html>';
}
//----------------------------------------------
</script>

</div>
<!-- working code ended -->
                           <!-- try no remove the preceding spaces -->

<?php

function fillModule($Module, $Str,$Folder){
	$Module= ltrim(rtrim($Module));
	$Folder= ltrim(rtrim($Folder));

	file_put_contents(
		"$Folder/modules/$Module/$Module".".php", 
		"<?php 
	defined('_JEXEC') OR die; ?>
	$Str"
	);
}