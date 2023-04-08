<?php
	$_REQUEST['root-folder'] = str_replace("\\", "/", $_REQUEST['root-folder']);
	
	include ($_REQUEST['root-folder']."/forbidden/db_connect.php");

	//username,pssword,e-mail,address,new-york,pocket,concrete
	if(isset($_POST['table'])){
		$query = "SELECT * FROM ".$_POST['table'];
		$pds =  $PDO->query($query);
		$Dat =  $pds->fetchAll(2);	
	}
	
	if(isset($_POST['query'])){
		$pds = $PDO->query($_POST['query']);
		if(! $pds){
			$res= print_r($PDO->errorInfo(),true);
		}else{
			$res= "Ok";
		}
	}

	$query = "SELECT * FROM sqlite_master";
	$pds = $PDO->query($query);
	$Stuffs =  $pds->fetchAll(2);


	include("functions.php");
	if(isset($_POST['table-thing'])){
		$search ='/CREATE TABLE "(\w+)"/';
		preg_match_all($search,$_POST['table-thing'] , $res);


		if(is_array($res) && isset($res[0][0])  ){
			$search ='/"(\w+)"/';
			preg_match_all($search, $res[0][0],$res2);
		}
		
		if(isset($res2)&& is_array($res2) && isset($res2[1][0])  ){
			$TableName = $res2[1][0];
			$search ='/\s*"(\w+)"\s+[^,]+,/';
			preg_match_all($search,$_POST['table-thing'] , $res);			
			$ColumnNames = $res[1];
		}

		
	} 

	if(isset($_POST['print-thing'])){
		$search = '/\[([^\[\]]+)\]/';
		preg_match_all($search,$_POST['print-thing'] , $res);
		$FormVars = $res[1]; 
	}	
	// Process URL related messages
?><!DOCTYPE html>
<html>

<head>
<title>Strip Table</title>
<script src = "jquery-1.9.1.js" ></script>
<script src = "ListViewII.js" ></script>
<style type="text/css">
	body{
		padding: 50px;
	}
</style>
</head>
<body>
<form method="post" action="database-mgr-view.php">
	<input  value="Update Database"  type="submit" />
	<input  name="task"  value="database.update"  type="hidden" />
	<input  name="root-folder"  value="<?php 
		if(isset($_REQUEST['root-folder'])){
			echo  $_REQUEST['root-folder'];
		} ; ?>"  type="hidden" />

</form>	
<div style="margin-left: 400px; display: inline-block; "><h3>Database Manager</h3></div>
<div>
<form method="post" >
<textarea cols="20" rows="10" name="table-thing"  id="table-thing" ><?php 
	if(isset($TableName) ){
		echo "Table: $TableName\n";
		$count =0;
		foreach($ColumnNames AS $Column){
			if($count == 0){
				echo $Column;
				$count ++;
			}else{
				echo ", $Column";
			}
		}
	}
?></textarea>


<textarea cols="20" rows="10" name= "print-thing" id="print-thing"  ><?php 
	if(isset($FormVars) && is_array($FormVars)){
		$count =0;
		foreach($FormVars AS $Vars){
			if($count == 0){
				echo $Vars;
				$count ++;
			}else{
				echo ", $Vars";
			}
		}
	}else{
		echo "username,pssword,e-mail,address,new-york,pocket,concrete";
	}
?></textarea>
Dot<input type="checkbox" disabled="true" id="use-dot" />
<input type="hidden" name="root-folder" value="<?php 
	if(isset($_POST['root-folder'])){
		echo  $_POST['root-folder'] ; 
	}
	?>">
<input type="submit" value="submit (create & Array)" />
<input type="button" value="use csv" onclick="useCSV()" />
<!--<input type="text" id ="tablename" value="<?php 
if(isset($TableName)){
	echo $TableName;
}else{
	echo '';
}
?>" />-->
<?php 
//pretty_r($Stuffs);
$Stuff2 = array();
$Stuff2[] = array("tbl_name"=> "none");
foreach($Stuffs AS $Value){
	$Stuff2[] = $Value;

}
$H = new DropdownCreator();

$H ->setID("tablename");
$H ->setName("tablename");
//setValue
echo '<br />';
$H ->setDataArray($Stuff2);
$H ->setValuekey("tbl_name");
$H ->setTextkey("tbl_name");
echo $H ->getDropdownstring();
echo '<br />';
$H ->setID("tablename-2");
echo $H ->getDropdownstring();
echo '<br />';
$H ->setID("tablename-3");
echo $H ->getDropdownstring();
echo '<br />';
$H ->setID("tablename-4");
echo $H ->getDropdownstring();
echo '<br />';
?>

</div>


</form>

<hr />

<div id="list1" style="overflow: scroll; width: 300px; height: 200px; border: thin solid gray; float: left; margin-top: 50px"></div>
<div id="list2" style="overflow: scroll; width: 300px; height: 200px; border: thin solid gray; float:left; margin-top: 50px; margin-left: 50px"></div>
<div style="clear: both;"></div><br />
<div style="clear:both">
	<input type="checkbox" id="do-where">WHERE CLAUSE
	<input type="checkbox" id="rhs">ONLY RHS
	<input type="text" style="width: 500px; height: 40px; margin-bottom: 5px; margin-top: 5px" id="var-col" disabled="true" />
</div>

<div id="list3" style="overflow: scroll; width: 300px; height: 200px; border: thin solid gray; float:left; margin-top: 50px; margin-left: 50px"></div>
<div id="list4" style="overflow: scroll; width: 300px; height: 200px; border: thin solid gray; float:left; margin-top: 50px; margin-left: 50px"></div>
<div id="list5" style="overflow: scroll; width: 300px; height: 200px; border: thin solid gray; float:left; margin-top: 50px; margin-left: 50px"></div>

<div style="clear:both">
	<br>
	<br>
	<br>
	<br>
</div>
<form method="post" action="implement-query.php"  target="_blank" >
	<div  style="clear: both;" >
	<textarea id="selected-1" cols="20" rows="10"></textarea>
	<textarea id="selected-2" cols="20" rows="10" name="selection-1" ></textarea>
	<textarea id="selected-3" cols="20" rows="10" ></textarea>
	<textarea id="selected-4" cols="20" rows="10" name="selection2" ></textarea>
	</div>

	<div style="clear: both;">
		<input type="button" value="INSERT" onclick= "createInsert()" />
		<input type="button" value="UPDATE" onclick= "createUpdate()" />
		<input type="button" value="SELECT" onclick= "createSELECT()" />
		<input type="button" value="Make/Save Record Set" onclick= "saveRecordset()" />
		<input type="button" value="Save Record Set" onclick= "saveRecordset2()" />
	</div>
	<textarea id="output" rows="15" cols="70" name="q-text"></textarea>
	<input type="hidden" name="task" value="implement-query" />
	<input type="submit" value="Write-Query" />
</form>

<script src="ListViewII.js" ></script>


<?php if( isset($TableName)  ){ ?>
<script>

var Json = {
	<?php $count =0 ?>
	data:[<?php foreach( $ColumnNames AS $stuff) { ?><?php 
		 if($count ==0 ) { ?> 
			{"<?php echo $count++; ?>": "<?php echo $stuff; ?>"} 
			 <?php  }else{  ?>
 			,{"<?php  echo $count++; ?>": "<?php echo $stuff; ?>"}
			 <?php  } ?> 
 <?php  }  ?>],
	
	onItemSelected: item1Selected
};

var Lv1 = new ListView(Json);
document.getElementById("list1").appendChild(Lv1.getListView() );

Lv1 = new ListView(Json);
document.getElementById("list3").appendChild(Lv1.getListView() );
Lv1 = new ListView(Json);
document.getElementById("list4").appendChild(Lv1.getListView() );
Json = {
	<?php $count =0 ?>
	data:[<?php foreach( $FormVars AS $stuff) { ?><?php 
		 if($count ==0 ) { ?>
 
			{"<?php echo $count++; ?>": "<?php echo $stuff; ?>"} 
			 <?php  }else{  ?>
 			,{"<?php  echo $count++; ?>": "<?php echo $stuff; ?>"}
			 <?php  } ?> 
 <?php  }  ?>],
	onItemSelected: item2Selected
};
Lv1 = new ListView(Json);
document.getElementById("list2").appendChild(Lv1.getListView() );
Lv1 = new ListView(Json);
document.getElementById("list5").appendChild(Lv1.getListView() );
</script>
<?php } ?>

<script>
function item1Selected(div,index,id){
	//console.log(div.outerHTML);
	console.log("item-1");
	if(!document.getElementById("do-where").checked){

		document.getElementById("selected-1").value += div.innerHTML.trim()+',';
		
	}else{
		if(document.getElementById("rhs").checked){
			document.getElementById("selected-4").value += div.innerHTML.trim()+',';
			document.getElementById("var-col").value += "C,";
		}else{
			document.getElementById("selected-3").value += div.innerHTML.trim()+',';
		}
	}

}

function item3Selected(div,index,id){
	//console.log(div.outerHTML);
	console.log("item-2");
	document.getElementById("selected-3").value += 
	div.innerHTML.trim()+',';	

}

function item5Selected(div,index,id){
	console.log("item 5");
	document.getElementById("selected-4").value += div.innerHTML.trim()+',';
	document.getElementById("var-col").value += "C,";

}

function item2Selected(div,index,id){
	//console.log(div.outerHTML);	
	//selected-2
	console.log("item 2");
	
	if(!document.getElementById("do-where").checked){
		document.getElementById("selected-2").value += div.innerHTML.trim()+',';
	}else{
		document.getElementById("selected-4").value += div.innerHTML.trim()+',';
		document.getElementById("var-col").value += "V,";
	}	
}
function item4Selected(div,index,id){
	console.log("item 4");
	document.getElementById("selected-4").value += div.innerHTML.trim()+',';
	document.getElementById("var-col").value += "V,";
		
}
function getTable1(){
	
	if('none' != document.getElementById("tablename").value){
		return document.getElementById("tablename").value;
	}

	if('none' != document.getElementById("tablename-2").value){
		return document.getElementById("tablename-2").value;
	}

	if('none' != document.getElementById("tablename-3").value){
		return document.getElementById("tablename-3").value;
	}

	if('none' != document.getElementById("tablename-4").value){
		return document.getElementById("tablename-4").value;
	}	

	alert("No Table selected");

	return "no_table";
}
function getTable2(){
	var TableArray = [];
	var k =0;

	if('none' != document.getElementById("tablename").value){
		TableArray[k++] = document.getElementById("tablename").value;
	}

	if('none' != document.getElementById("tablename-2").value){
		TableArray[k++] = document.getElementById("tablename-2").value;
	}

	if('none' != document.getElementById("tablename-3").value){
		TableArray[k++] = document.getElementById("tablename-3").value;
	}

	if('none' != document.getElementById("tablename-4").value){
		TableArray[k++] = document.getElementById("tablename-4").value;
	}	


	return TableArray.join(",");
}

function createInsert(){

	var col_array = document.getElementById("selected-1").value.split(",");
	var var_array = document.getElementById("selected-2").value.split(",");
	var len = col_array.length;

	if( '' ==col_array[len-1].trim()  ){
		len -=1;
	}

	debugger;
	var CList=[], QList = [], VList =[];
	for (c=0 ; c<len; c++){
		if('$'== var_array[c].substr(0,1)){
			VList[c] = '\n'+var_array[c];
		}else{
			VList[c] = '\n$_POST["'+var_array[c]+'"]';
		}
		QList[c] ='?';
		CList[c] = col_array[c];
	}
	
	QList = QList.join();	
	VList = VList.join();	
	CList = CList.join();

	var Tablename = getTable1();
	var Out = 
			'global $PDO; \n'+
			'$query = "INSERT INTO '+Tablename+' ('+CList+') \n'+
			'VALUES ('+QList+') "; \n'+
			'$pds = $PDO->prepare($query); \n'+
			'$pds->execute(/****/ array('+VList+') ); ';
			document.getElementById("output").value = Out;
			console.log(Out);
}

function createUpdate(){
	var col_array = document.getElementById("selected-1").value.split(",");
	var var_array = document.getElementById("selected-2").value.split(",");
	var len = col_array.length;

	if( col_array[len-1].trim()===''   ){
		len -=1;
	}

	var RHSList;
	var CList=[], QList = [], VList =[];
	for (c=0 ; c<len; c++){
		if('$'== var_array[c].substr(0,1)){
			VList[c] = '\n'+var_array[c];
		}else{
			VList[c] = '\n$_POST["'+var_array[c]+'"]';
		}
		QList[c] =col_array[c]+'= ?';
		
	}
	
	QList = QList.join();		
	//CList = CList.join();


	col_array = document.getElementById("selected-3").value.split(",");
	var_array = document.getElementById("selected-4").value.split(",");
	RHSList   = document.getElementById("var-col").value.split(",");

	len = col_array.length;
	if( col_array[len-1].trim()===''   ){
		len -=1;
	}
	ll = VList.length;

	for (c=0 ; c<len; c++){
		if('C'==RHSList[c]){
			VList += '';
			CList[c] =col_array[c]+' = '+var_array[c];
		}else{
			if('$'== var_array[c].substr(0,1)){
				VList[ll++] = '\n'+var_array[c];
			}else{
				VList[ll++] = '\n$_POST["'+var_array[c]+'"]';
			}
			CList[c] = col_array[c]+'= ?';
		}		
	}//end for

	VList = VList.join();
	CList = CList.join(' AND\n');

	
	var Tablename = getTable2();
	var Out = 
		'global $PDO; \n'+
		'$query = "UPDATE '+Tablename+'\nSET '+QList+' \n'+
		'WHERE '+CList+' "; \n'+
		'$pds = $PDO->prepare($query); \n'+
		'$pds->execute(/****/ array('+VList+') ); ';

	document.getElementById("output").value = Out;
}

function createSELECT(){
	var Tablename = getTable2();

	var col_array = document.getElementById("selected-1").value.split(",");
	var len = col_array.length;
	
	if( col_array[len-1].trim()===''   ){
		len -=1;
	}

	var CList=[], QList = [], VList =[];
	

	for (c=0 ; c<len; c++){
		QList[c] = col_array[c];
	}
	$QList = QList.join(', ');


	col_array = document.getElementById("selected-3").value.split(",");
	var var_array = document.getElementById("selected-4").value.split(",");	

	len = col_array.length;
	if( col_array[len-1].trim()===''   ){
		len -=1;
	}
	
	var RHSList   = document.getElementById("var-col").value.split(",");
	var flag=0;

	for (c=0 ; c<len; c++){
			if('C'==RHSList[c]){
				CList[c] = col_array[c]+' = '+var_array[c];
			}else{
				CList[c] = col_array[c]+'= ?';
				if('$'== var_array[c].substr(0,1)){
					VList[c] = '\n'+var_array[c];
				}else{
					VList[c] = '\n$_POST["'+var_array[c]+'"]';
				}				
				
			}
	}

	VList = VList.join(',');
	CList = CList.join(' AND \n');

	var Out = 
			'global $PDO; \n'+
			'$query = "SELECT '+QList+
			'\n FROM '+Tablename+
			' \nWHERE '+CList+' ";\n'+
			'$pds = $PDO->prepare($query); \n'+
			'$pds->execute(/****/ array('+VList+') ); \n\n'+
			'$R = $pds->fetchAll(2); \n'+
			'return $R;'
			;
			document.getElementById("output").value = Out;	
}


function recordsetSaved(dat){
	console.log(dat);
	alert("Saved");
}

	function saveRecordset(){
		var col_array ;
		var FetchCode,AttribList,Len;

		createSELECT();

		col_array =  document.getElementById("selected-1").value.split(",");

		Len = col_array.length;
		for(c=0; c<Len; c++){
			col_array[c]= filterCol(col_array[c]).trim();
		}

		AttribList = col_array;
		FetchCode  = document.getElementById("output").value;
		dat = {"attribs":AttribList, "code":FetchCode};



		$.ajax({ 
			data: dat,
			type:"post",
			url: "save-recordset.php?d=<?php echo  $_REQUEST['root-folder'] ; ?>",
			success: recordsetSaved,
			error: function(a,b,c){ 
				console.log(a); 
				console.log(b);
				console.log(c); 
			} 
		});
	}

	function filterCol(Col){
		var Kol;

		Col = Col.replace('as','AS');
		Col = Col.replace('aS','AS');
		Col = Col.replace('As','AS');

		Kol = Col.split('AS');
		if (Kol.length>1){
			return Kol[1];
		}else{
			Kol = Col.split('.');
			if(Kol.length>1){
				return Kol[1];
			}else{
				return Col;
			}
		}
	}

	function saveRecordset2(){
		var col_array ;
		var FetchCode,AttribList,Len;


		col_array =  document.getElementById("selected-1").value.split(",");

		Len = col_array.length;
		for(c=0; c<Len; c++){
			col_array[c]= filterCol(col_array[c]).trim();
		}

		AttribList = col_array;
		FetchCode  = document.getElementById("output").value;
		dat = {"attribs":AttribList, "code":FetchCode};

		$.ajax({ 
			data: dat,
			type:"post",
			url: "save-recordset.php?d=<?php echo  $_REQUEST['root-folder'] ; ?>",
			success: recordsetSaved,
			error: function(a,b,c){ 
				console.log(a); 
				console.log(b);
				console.log(c); 
			} 
		});
	}

	function useCSV(){
		var list1 =  document.getElementById("table-thing").value.split(","); 
		var len = list1.length;
			
		if( list1[len-1].trim()===''   ){
			len -=1;
		}
	
		var outcome = [];
		for(var i = 0; i<len; i++){
			outcome[i] = createObj(i,list1[i]);
		}
			//table-thing
		//selected-1

		Json = {
		
			data:outcome,
			onItemSelected: item1Selected
		};
		Lv1 = new ListView(Json);
		document.getElementById("list1").appendChild(Lv1.getListView() );
		

		var list2 =  document.getElementById("print-thing").value.split(","); 
		len = list2.length;
			
		if( list2[len-1].trim()===''   ){
			len -=1;
		}
	
		outcome = [];
		
		for( i = 0; i<len; i++){
			outcome[i] = createObj(i,list2[i]);
		}
			//table-thing
		//selected-1

		Json = {
		
			data:outcome,
			onItemSelected: item2Selected
		};
		Lv1 = new ListView(Json);
		document.getElementById("list2").appendChild(Lv1.getListView() );

		Json = {
		
			data:outcome,
			onItemSelected: item4Selected
		};
		Lv1 = new ListView(Json);
		document.getElementById("list4").appendChild(Lv1.getListView() );
}
	
	function createObj(key, val){
		var obj  = {};
		obj[key] = val;
		return obj;
	}
	
	$("#tablename"  ).bind("change",fetche);
	$("#tablename-2").bind("change",fetche2);
	$("#tablename-3").bind("change",fetche2);
	$("#tablename-4").bind("change",fetche2);
	
	function fetche2(){
		document.getElementById("use-dot").checked = "true";

		var dat = {"tablename" : $(this).val(),"root-folder":"<?php echo  SITE_FOLDER ; ?>"};
		$.ajax({ 
			data: dat,
			type:"post",
			"url":"http://localhost/php-mvc-IDE/configure/process-table2.php",
			//url: "process-table.php", 
			success: fetched, error: function(a,b,c){ console.log(a+b+c); } });

	}
	
	function fetche(){
		var dat = {"tablename" : $(this).val(),"root-folder":"<?php echo  SITE_FOLDER ; ?>"};
		var page_name ="";

		if(document.getElementById("use-dot").checked){
			page_name = 'process-table2.php';
		}else{
			page_name = 'process-table.php';
		}
		
		console.log(dat);
		$.ajax({ 
			data: dat,
			type:"post",
			"url":"http://localhost/php-mvc-IDE/configure/"+page_name,
			//url: "process-table.php", 
			success: fetched, error: function(a,b,c){ console.log(a+b+c); } });
	}
	
	function fetched(dat){
		console.log(dat);
		dat = evaluate(dat);
		var len = dat.length;
		
		var outcome = [];

		for(var i = 0; i<len; i++){
			outcome[i] = createObj(i,evaluate(dat[i]) );
		}
		
		//table-thing
		//selected-1

		Json = {
			data:outcome,
			onItemSelected: item1Selected
		};

		//document.getElementById("list1").innerHTML = "";
		Lv1 = new ListView(Json);
		document.getElementById("list1").appendChild(Lv1.getListView() );

		Json = {
			data:outcome,
			onItemSelected: item3Selected
		};
		Lv1 = new ListView(Json);
		document.getElementById("list3").appendChild(Lv1.getListView() );

		Json = {
			data:outcome,
			onItemSelected: item5Selected
		};
		Lv1 = new ListView(Json);
		document.getElementById("list5").appendChild(Lv1.getListView() );
	}

	function evaluate(str){
		return window['eval']("("+str+")");
	}
</script>
</body>
</html>