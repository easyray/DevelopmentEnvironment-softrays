<!DOCTYPE html>
<html>
		<head>
			<style>
			#div1{
				width: 45%;
				border: thin solid gray;
				float: left;
			}
			#div12{
				width: 45%;
				float: left;				
			}
			</style>
		</head>
<body>
	<h3>Custom dialog</h3>
		<?php
		session_start(); 

			$RecordSet = json_decode($_SESSION['ide-recorset']);
			$RecordSet = (array) $RecordSet;
			
			//[ide-recorset] => {"attribs":["surname","firstname","phone",""],"code":"global $PDO; \n$query = \"SELECT surname, firstname, phone FROM users \nWHERE designation= ? \";\n$pds = $PDO->prepare($query); \n$pds->execute(\/****\/ array(\n$_POST[\"student-class\"]) ); \n\n$R = $pds->fetchAll(2); \nreturn $R;"}
		
		?>
	<div id="div1">
		<div>Input Type</div>
		<select id="input-type">
			<option>Text</option>
			<option>Radio</option>
			<option>Textarea</option>
			<option>Button</option>
			<option>CheckBox</option>
			<option>Select/Option</option>
			<option>Span</option>
		</select>

<div style="margin-top: 25px">Select List</div>
<textarea rows="10" style="width:95%; margin:0px; padding: 0px" id="sel-list">
</textarea>
	</div>
	<div id="div2">
<table>
<tbody>
<tr>
<td>Name</td>
<td> <input type="text" id="i-name" /></td>
</tr>
<tr>
<td>ID </td>
<td><input type="text" id= "i-id"/> </td>
</tr>
<tr>
<td>Class </td>
<td><input type="text" id="i-class"/> </td>
</tr>
<tr>
<td>Value </td>
<td><input type="text" id="i-value"/> </td>
</tr>
<tr>
<td>Create Record Set </td>
<td><input type="checkbox" id="choose-recset" />
	<?php
	
		$Attribs = (array)$RecordSet['attribs'];
	
	?>
	<select id="use-recordset" onchange="setIValue()">
		
		<?php foreach ($Attribs as $key => $value) : ?>
		<option value="&lt?php echo $recordset<key>['<?php echo  $value ; ?>'] ; ?&gt"><?php echo  $value ; ?></option>
		<?php endforeach; ?>
	</select>
	<input type="button" id="re-use-recordset" value="use" onclick="setIValue()" />
	<input type="button" value="Recordset Function Code" onclick="putRecordsetFunction()" />
</td>
</tr>
<tr>
	<td>Recordset-Name</td>
	<td><input type="text" id="recordset-name" value="<?php
	//$_SESSION['ide-recorset-2']={"recordset":"$recrdset","record":"$record"}
		if(isset($_SESSION['ide-recorset-2'])){
			echo $_SESSION['ide-recorset-2']['recordset'];
		}else{
			echo '$Recordset';
		}
		?>"/>
</tr>
<tr>
	<td>Recordset Key</td>
	<td><input type="text" id="recordset-key" value="" />
</tr>
<tr>
	<td>Record Name</td>
	<td><input type="text" id="record-name" value="<?php
	//$_SESSION['ide-recorset-2']={"recordset":"$recrdset","record":"$record"}
		if(isset($_SESSION['ide-recorset-2'])){
			echo $_SESSION['ide-recorset-2']['record'];
		}else{
			echo '$Record';
		}
		?>" />
</tr>
<tr>
	<td>fetch function</td>
	<td><input type="text" id="recordset-fn-name" />
</tr>
<tr>
<td><input type="button" value="Add" id="btn-add" onclick="addInput()" /> </td>
<td>&nbsp;</td>
</tr>
</tbody>
</table>
		
	</div>
<div style="clear:both">
	 <textarea style="display: " id="content"></textarea>
	 <textarea style="display: " id="content2"></textarea>

</div>
<script>
	function setIValue(){
		var Key, Value;
		Key   = document.getElementById("recordset-key").value.trim();
		Value = document.getElementById("use-recordset").value;
		if(""==Key){
			Value = Value.replace('<key>','');
			Value = Value.replace('$recordset','$record');
		}else{
			Value = Value.replace('<key>','['+Key+']');
		}
		document.getElementById("i-value").value = Value ;
	}

	function putRecordsetFunction(){
		document.getElementById("content2").value=<?php echo  json_encode($RecordSet['code']) ; ?>;
	}

	function addInput(){

		var InputType =  document.getElementById("input-type").value;
		switch(InputType){
			case "Text": doText();
			break;
			case "Select/Option": doSelect();
			break;
			case "Radio": doRadio();
			break;
			case "Textarea": doTextarea();
			break;
			case "Button": doButton();
			break;
			case "CheckBox": doCheckBox();
			case "Span": doSpan();
			break;				
			
		}



	}

			
	function doText(){
		
		var Str ="";
		var IId, IClass, IName,IValue;
		
		IId    = document.getElementById("i-id").value ;
		IClass = document.getElementById("i-class").value ;
		IName  = document.getElementById("i-name").value ;
		IValue = document.getElementById("i-value").value ;

		if("" !=IId){
			IId = ' id="'+IId+'" ';
		}else{
			IId ="";
		}
		
		if("" !=IClass){
			IClass = ' class="'+IClass+'" ';
		}else{
			IClass ="";
		}
		if("" !=IName){
			IName = ' name="'+IName+'" ';
		}else{
			IName ="";
		}
		
		if("" !=IValue){
			IValue = ' value="'+IValue+'" ';
		}else{
			IValue ="";
		}

		Str = '<input '+IId+IClass+IName+IValue+' type="text" />';

		document.getElementById("content").value += Str;
	}
	
	
	function doSelect(){
		var Str ="";
		var IId, IClass, IName,IValue;
		
		IId    = document.getElementById("i-id").value ;
		IClass = document.getElementById("i-class").value ;
		IName  = document.getElementById("i-name").value ;
		IValue = document.getElementById("i-value").value ;

		if("" !=IId){
			IId = ' id="'+IId+'" ';
		}else{
			IId ="";
		}
		
		if("" !=IClass){
			IClass = ' class="'+IClass+'" ';
		}else{
			IClass ="";
		}
		if("" !=IName){
			IName = ' name="'+IName+'" ';
		}else{
			IName ="";
		}
		
		if("" !=IValue){
			IValue = ' value="'+IValue+'" ';
		}else{
			IValue ="";
		}


		Str = '<select '+IId+IClass+IName+'>';
		
		var List = document.getElementById("sel-list").value.split(",") ;
		for(var i in List){
			Str +='<option value="'+List[i]+'">'+List[i]+'</option>';
		}

		Str += '</select>';
		
		document.getElementById("content").value += Str;
	
	}


function doRadio()
{
		var Str ="";
		var IId, IClass, IName,IValue;
		
		IId    = document.getElementById("i-id").value ;
		IClass = document.getElementById("i-class").value ;
		IName  = document.getElementById("i-name").value ;
		IValue = document.getElementById("i-value").value ;

		if("" !=IId){
			IId = ' id="'+IId+'" ';
		}else{
			IId ="";
		}
		
		if("" !=IClass){
			IClass = ' class="'+IClass+'" ';
		}else{
			IClass ="";
		}
		if("" !=IName){
			IName = ' name="'+IName+'" ';
		}else{
			IName ="";
		}
		
		if("" !=IValue){
			IValue = ' value="'+IValue+'" ';
		}else{
			IValue ="";
		}





		//var List = document.getElementById("sel-list").value.split(",") ;
		Str = '<input '+IId+IClass+IName+IValue+' type="radio"  />';
		
		document.getElementById("content").value += Str;

}
function doTextarea(){
	
			var Str ="";
			var IId, IClass, IName,IValue;
			
			IId    = document.getElementById("i-id").value ;
			IClass = document.getElementById("i-class").value ;
			IName  = document.getElementById("i-name").value ;
			IValue = document.getElementById("i-value").value ;

			if("" !=IId){
				IId = ' id="'+IId+'" ';
			}else{
				IId ="";
			}
			
			if("" !=IClass){
				IClass = ' class="'+IClass+'" ';
			}else{
				IClass ="";
			}
			if("" !=IName){
				IName = ' name="'+IName+'" ';
			}else{
				IName ="";
			}
			
			var List = document.getElementById("sel-list").value.split(",") ;
			Str = '<textarea '+IId+IClass+IName+' rows="'+List[0]+'" cols="'+List[1]+'">'+IValue+'</textarea>';
			
			document.getElementById("content").value += Str;
	
}
function doButton(){
			var Str ="";
			var IId, IClass, IName,IValue;
			
			IId    = document.getElementById("i-id").value ;
			IClass = document.getElementById("i-class").value ;
			IName  = document.getElementById("i-name").value ;
			IValue = document.getElementById("i-value").value ;

			if("" !=IId){
				IId = ' id="'+IId+'" ';
			}else{
				IId ="";
			}
			
			if("" !=IClass){
				IClass = ' class="'+IClass+'" ';
			}else{
				IClass ="";
			}
			if("" !=IName){
				IName = ' name="'+IName+'" ';
			}else{
				IName ="";
			}
			
			if("" !=IValue){
				IValue = ' value="'+IValue+'" ';
			}else{
				IValue ="";
			}

			Str = '<input '+IId+IClass+IName+IValue+' type="button" />';

			Str = Str.replace(
				"$recordset",
				document.getElementById('recordset-name').value
			);
			
			document.getElementById("content").value += Str;
	
}
function doCheckBox(){
			var Str ="";
			var IId, IClass, IName,IValue;
			
			IId    = document.getElementById("i-id").value ;
			IClass = document.getElementById("i-class").value ;
			IName  = document.getElementById("i-name").value ;
			IValue = document.getElementById("i-value").value ;

			if("" !=IId){
				IId = ' id="'+IId+'" ';
			}else{
				IId ="";
			}
			
			if("" !=IClass){
				IClass = ' class="'+IClass+'" ';
			}else{
				IClass ="";
			}
			if("" !=IName){
				IName = ' name="'+IName+'" ';
			}else{
				IName ="";
			}
			
			if("" !=IValue){
				IValue = ' value="'+IValue+'" ';
			}else{
				IValue ="";
			}			

			Str = '<input '+IId+IClass+IName+IValue+' type="checkbox" />';
			
			document.getElementById("content").value += Str;

}

	function doSpan(){
		var Str ="";
		var IId, IClass, IName,IValue;
		
		IId    = document.getElementById("i-id").value ;
		IClass = document.getElementById("i-class").value ;
		IName  = document.getElementById("i-name").value ;
		IValue = document.getElementById("i-value").value ;

		if("" !=IId){
			IId = ' id="'+IId+'" ';
		}else{
			IId ="";
		}
		
		if("" !=IClass){
			IClass = ' class="'+IClass+'" ';
		}else{
			IClass ="";
		}
		if("" !=IName){
			IName = ' name="'+IName+'" ';
		}else{
			IName ="";
		}
		
		if("" !=IValue){
			IValue = ' value="'+IValue+'" ';
		}else{
			IValue ="";
		}			

		Str = '<span '+IId+IClass+IValue+' >'+IValue+'</span>';
		
		document.getElementById("content").value += Str;

	}
		/*
					console.log(Str);
		content
	"input-type
	i-name"
	i-id
	.i-class
btn-addbtn-done	
*/
</script>
</body>
</html>