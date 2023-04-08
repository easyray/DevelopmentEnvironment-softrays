<?php
    if( isset($_REQUEST["root-folder"]) ){
        $Folder = $_REQUEST["root-folder"].'/';
    }else{
	   $Folder = "";
    }
	
	if(isset($_POST["stuff"])){
		$Stor = array();

		$Arr1 = json_decode($_POST["stuff2"]);
		$Arr2 = json_decode($_POST["stuff"]);
		foreach($Arr1 AS $Key=> $Value){
			$Stor[$Value] = $Arr2[$Key];
		}

		file_put_contents(
			$Folder."/configure/assign-template.json" ,
			json_encode($Stor) 
		);
	}
	
	
	
	$Urls      =simplexml_load_string(file_get_contents($Folder."configure/urls.xml"));
	$templates =simplexml_load_string(file_get_contents($Folder."configure/templates.xml"));

	include("functions.php");
	
	$Urls = getArrayFrom($Urls->url);
	$templates = getArrayFrom($templates->template);
	
	$AssgArray = array();
	
	foreach($Urls AS $Value){
		$AssgArray[$Value] = $templates[0];
	}
	
	if(isset($_POST['action_module']) &&$_POST['action_module'] == "reset"){
		$G = array();
		file_put_contents($Folder.'assign-template.json', json_encode($G) );
	}	
	
	if(is_file("assign-template.json") ){
		$Tm = json_decode(file_get_contents($Folder."configure/assign-template.json"));
		
		if(is_object($Tm)){	
			//print_r($Tm);
			foreach($Tm AS $Key=> $Value){
				$AssgArray[$Key] = $Value;
			}		
		}
	}
	

?><!DOCTYPE html>
<html>
<head>
	<title>Assg-Template</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <div id="container">
        
        <div id="my-logo"><img src="pix/logo.png" /> </div>
		<?php include("menu.php"); ?>
        <div id="our-slide-show">
			<h1>Template Assignment</h1>
  			<table class="t-colapse" border="1">
			<thead>
			<tr>
			<th>S/N</th>
			<th>URL Name</th>
			<th>Template</th>
			</tr>
			</thead>
			<tbody>
			<?php $SN =1;	?>
			<?php foreach($AssgArray AS $Key =>$Val){ ?>
			<tr>
			<td><?php echo $SN;  ?></td>
			<td><span class="cls-url"><?php echo $Key;  ?></span></td>
			<td><?php echo tempList($templates,"cls-sel-tmp", $Val,"temp_"); ?></td>
			</tr>
			<?php 
					$SN++;
				} 
			?>
			</tbody>
			</table>
			<div style="width:48%; padding-right:12%; float: right; height: 30px; padding-top: 20px">
				<input type="button" value="Save" onclick="saveAssg()" />
				<form method="post" id="frm-url-tmp" >
					<input type="hidden" name="stuff" />
					<input type="hidden" name="stuff2" />
					<input type="hidden" name="root-folder" value="<?php echo  $_REQUEST['root-folder'] ; ?> " />
				</form>

				<form method="post">
				    <input type = "hidden" name ="action_module" value = "reset" />
				    <input type = "submit"  value = "reset" />
				    <input type="hidden" name="root-folder" value="<?php echo  $_REQUEST['root-folder'] ; ?> " />
				</form>	

			</div>
		</div>
	</div>
	<script >
		function saveAssg(){
			var Form = document.getElementById("frm-url-tmp");
			
			Form.stuff.value = createJSON(document.getElementsByClassName("cls-sel-tmp"));
			Form.stuff2.value = createJSON2(document.getElementsByClassName("cls-url"));
			
			Form.submit();
		}

		function createJSON(Items){
			var Str = "[";
			var len = Items.length;
			var ii =0;
			for( var i = 0; i < len; i++){

				if(ii==0){
					Str += '"'+Items[i].value+'"';
					ii++;
				}else{
					Str += ', "'+Items[i].value+'"';
				}

			}
			Str+=']';
			return Str;
		}

		function createJSON2(Items){
			var Str = "[";
			var len = Items.length;
			var ii =0;
			for( var i = 0; i < len; i++){

				if(ii==0){
					Str += '"'+Items[i].innerHTML+'"';
					ii++;
				}else{
					Str += ', "'+Items[i].innerHTML+'"';
				}

			}
			Str+=']';
			return Str;
		}			
	</script>
</body>
</html>	