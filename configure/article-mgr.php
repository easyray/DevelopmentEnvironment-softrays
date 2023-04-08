<?php
    if( isset($_REQUEST["root-folder"]) ){
        $Folder = $_REQUEST["root-folder"].'/';
    }else{
	   $Folder = "";
    }

    $Folder_ = $Folder;
	if(! function_exists("pretty_r")){
		include "$Folder"."forbidden/db_connect.php";
	}	
		
	include ("functions.php");
	
	
	if(isset($_POST['task']) && $_POST['task'] == "article-mgr.create-dinfo" ){
		$fp = fopen("article-mgr.txt", "wt");
		fwrite($fp,$_POST['database'].',');
		fwrite($fp,$_POST['section'].',');
		fwrite($fp,$_POST['url']);
		fclose($fp);
	}


	$datafound = true;
	if(!is_file("article-mgr.txt")){
		$datafound = false;
	}else{

		$Dinfo = file_get_contents("article-mgr.txt");
		$Dinfo = explode(",", $Dinfo);
		
		$username = "root";
		$password = "";
		
	}// end if

	if(
		$datafound && isset($_POST['task']) && 
		(
			$_POST['task'] == "article-mgr.save-url" ||
			$_POST['task'] == "article-mgr.save-section"
		)
	){

		if($_POST['toadd'] != ""){
			$toadd    = explode(",", $_POST['toadd']);
		}else{
			$toadd = array();
		}
		if($_POST['toremove'] != ""){
			$toremove = explode(",", $_POST['toremove']);
		}else{
			$toremove= array( );
		}

	}


	if($datafound && isset($_POST['task']) && $_POST['task'] == "article-mgr.save-url"){
		$query1 = "INSERT INTO ".$Dinfo[2]." (string,privilege) VALUES(?, ?)";
		
		$pds    = $PDO->prepare($query1);
		$len =0;
		foreach ($toadd as $key => $value) {
			$value = explode("_",$value);
			$len = sizeof($value);
			$value2 = $value[$len-1];
			$value1 = "";
			for($knt = 0; $knt< $len-1; $knt++){
				$value1 .= $value[$knt];
			}
			
			$pds->execute( array($value1,$value2) );
		}

		$query2 = "DELETE FROM ".$Dinfo[2]." WHERE id= ?";
		$pds    = $PDO->prepare($query2);

		foreach ($toremove as $key => $value) {
			$pds->execute( array($value) );
		}		

	}



	if($datafound && isset($_POST['task']) && $_POST['task'] == "article-mgr.save-section"){

		$query1 = "INSERT INTO  ".$Dinfo[1]."(string) VALUES(?)";
		$pds    = $PDO->prepare($query1);

		foreach ($toadd as $key => $value) {
			$pds->execute( array($value) );
		}

		$query2 = "DELETE FROM ".$Dinfo[1]." WHERE id= ?";
		$pds    = $PDO->prepare($query2);

		foreach ($toremove as $key => $value) {
			$pds->execute( array($value) );
		}		

	}

?><!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css?r=9" />
</head>
<body>
    <div id="container">
        
        <div id="my-logo"><img src="pix/logo.png" /> </div>
		<?php
		 include("menu.php"); ?>
<?php
// fetch existing URls and sections in DB
	if($datafound){
		try{
			$EE = $PDO->query("SELECT * FROM ".$Dinfo[1]);
			$Sections = $EE->fetchAll();

			$Urls = $PDO->query("SELECT * FROM ".$Dinfo[2])->fetchAll();
		}catch(PDOException $e){
			$datafound = false;
			echo $e->getMessage();
		}
	}else{
		$Urls = "";
		$Sections = "";
	}// end if

// fetch from file
	//echo $Folder_; die;
	$Urls2 = simplexml_load_file($Folder_."configure/urls.xml");
	$Urls2 = getArrayFrom($Urls2->url);

	$Sections2 = simplexml_load_file($Folder_."configure/sections.xml");
	$Sections2 = getArrayFrom($Sections2->section);	
 
?>		
        <div id="our-slide-show">
        <h2>Manage Article Data</h2>
		
		<div id="db-form" style="display: <?php 
			if(!$datafound){ 
				echo 'block'; 
			}else{
				echo 'none'; 
				} ?>; padding-top: 20px; padding-bottom: 30px;">
			<h3>Database info</h3>
			<form method="post">
				<input type="text" name="database" placeholder="database" />
				<input type="text" name="section" placeholder="Section table" />
				<input type="text" name="url" placeholder="URL table" />
				<input type="submit" value=" connect " />
				<input type="hidden" name="task" value="article-mgr.create-dinfo" />
			</form>
		</div>


<div style="height: 50px"></div>
<h2>URLs</h2>
<?php
	function getConstName($Array, $Code){
		$Ret = "None";
		foreach($Array AS $Item){
			if($Item["code"] == $Code){
				return  $Item["CONSTANT_NAME"];
			}
		}//end foreach....
		
		return $Ret;
	}
	
	
	$D = $PDO->prepare("SELECT * FROM privileges");
	echo DATA_FILE;

	$D->execute(array() );
	$PRIV = $D -> fetchAll(2);	
?>
			
<table class="t-colapse" border="1">
<tbody>
<tr>
<th width="50">S/N</th>
<th>URL</th>
<th>&nbsp;</th>
<th>&nbsp;</th>
</tr>
<?php $SN =1 ?>
<?php 
if(is_array($Urls))
foreach($Urls AS $Stuff) { ?>
<tr>
<td><?php echo  $SN++; ?></td>
<td><?php echo  $Stuff['string']; ?></td>
<td><?php echo getConstName($PRIV, $Stuff['privilege']) ; ?></td>
<td>
	<input class="rem-url" value="<?php echo  $Stuff['id']; ?>" type="checkbox" /> 
	<span class="rem-stuff">remove</span>
</td>
</tr>
<?php } ?>

<?php  foreach($Urls2 AS $Stuff ){ ?> 
<?php if(!urlOrSectionExists($Stuff, $Urls)){ ?>
<tr>
<td><?php echo  $SN++; ?></td>
<td><?php echo  $Stuff; ?></td>
<td>
<?PHP							
 	$KK = new DropdownCreator();
	$KK->setDataArray($PRIV);
	$KK->setValuekey('code');
	$KK->setTextkey('CONSTANT_NAME');
	$KK->setValue("");
	$KK->setName("privilege".$Stuff);
	$KK-> setID ("privilege".$Stuff);
	echo $KK->getDropdownstring();
	//CREATE TABLE 'privileges' ('id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 'CONSTANT_NAME' TEXT, 'description' TEXT, 'code' INTEGER)
/********/

?>
</td>
<td>
	<input class="add-url" value="<?php echo  $Stuff; ?>"  type="checkbox" /> 
	<span class="add-stuff">add</span></td>
</tr>
	<?php } ?>
<?php } ?>
</tbody>
</table>

<form id="url-form" method="post">
	<input type="hidden" name="task" value="article-mgr.save-url" />
	<input type="hidden" name="toadd"  />
	<input type="hidden" name="toremove" />
</form>

<input type="button" value= " Save " onclick="editItem('rem-url', 'add-url','url-form')">

<div style="height: 50px"></div>
<h2>Sections</h2>

			
<table class="t-colapse" border="1">
<tbody>
<tr>
<th width="50">S/N</th>
<th>Sections</th>
<th>&nbsp;</th>
</tr>
<?php $SN =1 ?>
<?php 
if(is_array($Sections))
foreach($Sections AS $Stuff) { ?>
<tr>
<td><?php echo  $SN++; ?></td>
<td><?php echo  $Stuff['string']; ?></td>
<td>
	<input class="rem-section" value="<?php echo  $Stuff['id']; ?>" type="checkbox" /> 
	<span class="rem-stuff">remove</span>
</td>
</tr>
<?php } ?> 
<?php foreach($Sections2 AS $Stuff ){ ?> 
	<?php if(!urlOrSectionExists($Stuff, $Sections)){ ?>
<tr>
<td><?php echo  $SN++; ?></td>
<td><?php echo  $Stuff; ?></td>
<td>
	<input class="add-section" value="<?php echo  $Stuff; ?>"  type="checkbox" /> 
	<span class="add-stuff">add</span></td>
</tr>
	<?php } ?>
<?php } ?>
</tbody>
</table>
<form id="section-form" method="post">
	<input type="hidden" name="task" value="article-mgr.save-section" />
	<input type="hidden" name="toadd"  />
	<input type="hidden" name="toremove" />
</form>

<input type="button" value= " Save " onclick="editItem('rem-section', 'add-section','section-form')">


        </div>
	</div>
	<script >
		function editItem(torem,toadd, formid){
			
			
			var r = document.getElementsByClassName(torem),
			    a = document.getElementsByClassName(toadd);

			var c =0;

			var str ="";
			
			for(var i =0; i< r.length; i++){
				if(r[i].checked){
					if(c>0){ str+= ",";  }
					str += r[i].value;
					c++;
				}
			}
			
			document.getElementById(formid).toremove.value=str;
			
			str ="";
			c = 0;
			for(var i =0; i< a.length; i++){
				if(a[i].checked){
					G="privilege"+a[i].value;
					console.log(G);

					if(document.getElementById(G)){
						
						code = document.getElementById(G).value;
					
						if(c>0){ str+= ",";  }
						str += a[i].value+"_"+code;
						c++;

					}else{

						if(c>0){ str+= ",";  }
						str += a[i].value
						c++;
					}
				}
				
			}
			
			document.getElementById(formid).toadd.value=str;
			
			document.getElementById(formid).submit();
			
			
		}
	</script>
	
</body>
</html>