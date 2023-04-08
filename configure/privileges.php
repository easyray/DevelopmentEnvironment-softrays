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
	//include ("sharedobjects.php");
if( 
	isset($_POST['task']) &&
	$_POST['task']=="add-privilege" ){
		$query = "INSERT INTO privileges 
		(CONSTANT_NAME, description, code)
		VALUES(?,?,?) ";
$pds = $PDO->prepare($query);
//pretty_r($PDO->errorInfo());
$pds->execute(
	 array(
		$_POST["privilege"],
		$_POST["description"],
		$_POST["code"]
	) 
); 
		
}else if( 
	isset($_POST['task']) &&
	$_POST['task']=="delete-privileges"){
		
	$Privleges = explode(",",$_POST['privileges']);
	foreach($Privleges AS $P){
		deletePrivilege($P);
	}//end foreach

}

function deletePrivilege($PrivilegeId){
	global $PDO;
	$query = "DELETE FROM privileges WHERE id=? ";
	$pds = $PDO->prepare($query);
	//pretty_r($PDO->errorInfo());
	$pds->execute( array($PrivilegeId) );
}
$query = "SELECT * FROM privileges WHERE 1 ";
$pds = $PDO->prepare($query);
//pretty_r($PDO->errorInfo());
$pds->execute( array() ); 
$Privileges = $pds->fetchAll(2);

?><html>
<head>
	<title>Privileges</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
<script src="jquery-1.9.1.js" ></script>

<script>
	window.onerror = function(msg , url, line){
	var dv;

	if(!document.getElementById("debug-window")){
			dv = document.createElement("DIV");
			dv.id = "debug-window";
			dv.innerHTML = '<div style="float:left;position:fixed; top:0px; left:0px; width:250px; border: thin solid #999; background-color:#aaa;text-align: justify"><div id="inside-debug" >'+url+"<br />"+msg+"<br />"+"Line: "+line+'</div><input id="close-debug-window" type="button" value="close" onclick ="closeDbgWin()" /></div>';
			document.body.appendChild(dv);
	}else{
			
			document.getElementById("inside-debug").innerHTML  += "<div>"+url+"<br />"+msg+"<br />"+"Line: "+line+"</div>";
	}
};


function closeDbgWin(){
document.body.removeChild(document.getElementById("debug-window"));
}

	console.log = function(msg){

				var dv = document.createElement("DIV");
				if(! document.getElementById("debug-window")){
						dv.id = "debug-window";
						dv.innerHTML = '<div style="position:fixed; ' +
						' top:100px; left:100px; width:500px; border: thin solid #999; '+ 
						'  background-color:#aaa;text-align: justify"><div id="inside-debug">'+msg+"</div><br />"+
						' <input id="close-debug-window" type="button" value="close" '+
						' onclick ="closeDbgWin()" /></div>';
						document.body.appendChild(dv);
				}else{
							document.getElementById("inside-debug").innerHTML +='<div>'+msg+'</div>';
				}
		};//~console.log
//alert("yes");
</script>
    <div id="container">
        
        <div id="my-logo"><img src="pix/logo.png" /> </div>
		<?php include("menu.php"); ?>
        <div id="our-slide-show">
			<h1>Privileges</h1>
	<table class="t-colapse" border="1">
	<thead>
	<tr>
	<th>S/N</th>
	<th> </th>
	<th>CONST NAME</th>
	<th>Description</th>
	<th>Code</th>
	</tr>
	</thead>
	<tbody> 
	 <?php 
	$SN =1;
	foreach ($Privileges AS $Key=>$stuff) { ?>
	<tr>
	<td><?php echo $SN++; ?></td>
	<td><input type="checkbox" class="cls-chk-privileges" value="<?php echo $stuff['id']; ?>"/></td>
	<td><?php echo $stuff['CONSTANT_NAME']; ?></td>
	<td><?php echo $stuff['description']; ?></td>
	<td><?php echo $stuff['code']; ?></td>
	</tr>
 <?php  }  ?>
 </tbody>
</table>
<form method="post">
	<table>
<tbody>
<tr>
<td>Constant Name</td>
<td><input id="privilege" class="txt" name="privilege" type="text" /></td>
</tr>
<tr>
<td>Description</td>
<td><input id="description" class="txt" name="description" type="text" />&nbsp;&nbsp;&nbsp;</td>
</tr>
<tr>
<td>Code&nbsp;&nbsp;&nbsp;</td>
<td><input id="code" class="txt" name="code" type="text" />&nbsp;&nbsp;&nbsp;</td>
</tr>
<tr>
<td>&nbsp;&nbsp;&nbsp;</td>
<td><input id="" class="btn" name="" type="submit" value="Create" /></td>
</tr>
</tbody>
</table>
<input type="hidden" name="task" value="add-privilege" />
</form>

	<form method="post" id="frm-privilege-delete">
		<input type="hidden" name="task" value="delete-privileges">
		<input type="hidden" name="privileges" value="" id="privilege-list" >
		<input type="button" id="btn-delete-privilege" value="delete" onclick="deletePrivilege()" />
	</form>
<textarea cols="80" rows="20">
<?php echo'<?php
'; ?>
<?php foreach ($Privileges AS $Key=>$stuff) { ?>
	define("<?php echo $stuff['CONSTANT_NAME']; ?>",<?php echo $stuff['code']; ?> );<?php 

	echo "//".$stuff['description']."\n"; ?>
<?php }  ?>
<?php echo'
?>'; ?>
</textarea> 
</div>

    </div>
<script>
	function deletePrivilege() {
	var checks = document.getElementsByClassName("cls-chk-privileges");
	var len = checks.length;
	var str = "";
	var first_done = 0;
	for(var i = 0; i<len; i++){
		if(checks[i].checked){
			if(first_done==0){
				str += checks[i].value;
				first_done++;
			}else{
				str += ","+checks[i].value;
			}
		}
	}
	
	document.getElementById("privilege-list").value= str;
	document.getElementById("frm-privilege-delete").submit();
}
</script>
</body>
</html>