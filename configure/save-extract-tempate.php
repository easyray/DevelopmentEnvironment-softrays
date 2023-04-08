<?php

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
<html>
<div style="display: none;"><?php 

if( isset($_POST["filename"])):	
	include $_POST['filename'];
endif;

?></div>

<!-- working code started -->
<div id="list-of-sections-div" >
	code extracted<br />
	<textarea id="list-of-sections" style="display: none;"><?php 
		if(isset($_POST['filename'])){
			echo  json_encode($_POST['section']) ; 
		}
	?></textarea>
		<textarea id="list-of-modules" style="display: none;"><?php 
		if(isset($_POST['filename'])){
			echo  json_encode($_POST['module']); 
		}
	?></textarea>
	<textarea id="list-of-section-ids" style="display: none;"><?php 
	if(isset($_POST['filename'])){
		echo  json_encode($_POST['section_ids']); 
	}
	?></textarea>

	<input type="hidden" id="site-folder" value="<?php 
		if(isset($_POST['site-folder'])){
			if( isset($_POST["admin"])){
				echo  $_POST['site-folder'].'/admin' ; 
			}else{
				echo  $_POST['site-folder'] ; 
			}
		}
	?>" />
	<br />

	<input type="button" value="Show Extracted Code" onclick="trans()" />



<form method="POST">
	<textarea id="density" rows="20" cols="60" name="density">The java script removed all the innerHTML the remaining code needs to be put into this box so we can  send it on the next mission(template creation)</textarea>
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
	<br>
	<input type="text" name="template" placeholder="template name" />
	<br>
	<input type="submit" value=" Save template " />
</form>

<script src="js/jquery-1.9.0.min.js"></script>

<script >
<?php include __DIR__."/save-extract-tempate.js"; ?>


var 
List = evaluate(document.getElementById('list-of-sections').value ),
List2= evaluate(document.getElementById('list-of-modules' ).value ),
List3= evaluate(document.getElementById('list-of-section-ids').value);

var Str= document.head.outerHTML + document.body.outerHTML;
var i_HTML, i_HTML_0;

var LT ="<";
LT+="?php";

var Len = List3.length;

for(var i=0 ; i<Len; i++){

	if(document.getElementById(List3[i])){
	
		createModule(
		    List2[i],
		    List[i],
		    document.getElementById(List3[i]).innerHTML,
		);

		document.getElementById(List3[i]).innerHTML = 
			LT + "\n" +
		    "$Inc = route($PageName, '"+List[i]+"'); \n"+
		    "foreach ($Inc AS $value) { include($value); } \n ?"+
			">"	;
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
</html><?php

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