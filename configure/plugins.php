<?php
    
    if( isset($_REQUEST["root-folder"]) ){
        $Folder = $_REQUEST["root-folder"].'/';
    }else{
	   $Folder = "";
    }

	include ("functions.php");


	if(is_file($Folder."configure/plugins.xml")){
		$Plugins = simplexml_load_string(file_get_contents($Folder."configure/plugins.xml"));

		$Plugins = getArrayFrom($Plugins->plugin);
	}else{
		$Plugins = array();
	}
	
	
	
	if(isset($_POST['task']) && $_POST['task']== "create" ){
		$Plugins[] = $_POST['name'];
		saveXML("plugins", "plugin", $Plugins,$Folder."configure/plugins.xml");
	}	

	if(isset($_POST['task']) && $_POST['task']== "edit" ){
		$Plugins[$_POST['index']] = $_POST['name'];
		saveXML("plugins", "plugin", $Plugins,$Folder.'configure/plugins.xml');
	}	
	
	if(isset($_POST['task']) && $_POST['task']== "delete" ){
		$Indeces = json_decode($_POST['indeces']);
		$Plugins =removeItem( $Plugins, $Indeces);
		saveXML("plugins", "plugin", $Plugins,$Folder.'configure/plugins.xml');
	}	

	/****/
 ?><!DOCTYPE html>
<html>
<head>
	<title>Plugins</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <div id="container">
        
        <div id="my-logo"><img src="pix/logo.png" /> </div>
		<?php include("menu.php"); ?>
		
        <div id="our-slide-show">
			<h1>Plugins</h1>
			<table class="t-colapse" border="1" cellspacing="0" cellpadding="5">
			<tbody>
			<tr>
			<th>S/N</th>
			<th> </th>
			<th>Plugin</th>
			<th> </th>
			</tr>
			<?php $SN = 1; ?>
			<?php foreach ($Plugins AS $Key=> $Value){ ?>
			<tr>
			<td><?php echo  $SN; ?> </td>
			<td><input class="clschkplugin" type="checkbox" value="<?php echo  ($SN-1); ?>" /></td>
			<td>
			<span id="id-span-plugin-<?php echo  ($SN-1); ?>" >
			<?php echo  $Value; ?>
			</span>
			<span id="id-frm-span-plugin-<?php echo  ($SN-1); ?>" style="display: none;">
			<form  method="post">
			<input name="name" type="text" value="<?php echo  ($Value); ?>" />
			<input name="index" type="hidden" value="<?php echo  ($SN-1); ?>" />
			<input name="task" type="hidden" value="edit" />
			<input type="submit" value="  Ok  " />
			<input type="hidden" name="root-folder" value="<?php echo  $_REQUEST['root-folder'] ; ?> " />
			</form>
			</td>
			<td>
			<input type="button" value="Edit" id="id-btn-edit-<?php echo  ($SN-1); ?>" onclick="editItem(this,'id-span-plugin-','id-frm-span-plugin-')" />
			</td>
			</tr>
			<?php  $SN+=1; ?>
			<?php  }  ?>
			</tbody>
			</table>
			<div style="height: 40px"></div>
	<form  method="post">
		<input type="text" name="name" />
		<input type="hidden" name="task" value="create" />
		<input type="submit" value=" Create " />
		<input type="hidden" name="root-folder" value="<?php echo  $_REQUEST['root-folder'] ; ?> " />
	</form>
	<form  method="post" id="g-del" >
		<input type="hidden" name="indeces" />
		<input type="hidden" name="task" value="delete" />
		<input type="button" onclick="groupChkDelete('clschkplugin', 'g-del','indeces')" value=" Delete " />
		<input type="hidden" name="root-folder" value="<?php echo  $_REQUEST['root-folder'] ; ?> " />
	</form>	
        </div>

	</div>

	<script >
		function editItem(obj,prefix,prefix2){
		
		
			var MyId = obj.id.split("-")
			var len = MyId.length;

			MyId = MyId[len-1];
			
			var spanid1 = prefix+ MyId;
			var spanid2 = prefix2 + MyId;
			console.log(spanid1);

			document.getElementById(spanid1).innerHTML = "";
			
			var  FrmBox = document.getElementById(spanid2);
			
			FrmBox.style.display = "inline" ;
			var Frm = FrmBox.getElementsByTagName("form")[0];
			
		}

		function groupChkDelete(ClassName, FormId,FrmFldName){
			var dat = createChkJSON(document.getElementsByClassName(ClassName));
			
			document.getElementById(FormId)[FrmFldName].value = dat;
			document.getElementById(FormId).submit();


		}

		function createChkJSON(Items){
			var Str = "[";
			var len = Items.length;
			var ii =0;
			for( var i = 0; i < len; i++){
				if(Items[i].checked){
					if(ii==0){
						Str += '"'+Items[i].value+'"';
						ii++;
					}else{
						Str += ', "'+Items[i].value+'"';
					}
				}// end if
			}
			Str+=']';
			return Str;
		}		
	</script>
</body>
</html>