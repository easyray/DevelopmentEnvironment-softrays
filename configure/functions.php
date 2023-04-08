<?php

	function removeItem( $ArrayItems1, $ArrayItems2){
		$Tmp = array();
		
		$counter = 0;
		
		foreach($ArrayItems1 AS $Value){
			if(!in_array($counter, $ArrayItems2)){
				$Tmp[] = (string) $Value;
			}
			
			$counter++;
		}

		return $Tmp;
	}
	
	
	function getArrayFrom($ArrayItems1){
		$Tmp = array();
		
		$counter = 0;
		
		foreach($ArrayItems1 AS $Value){
			$Tmp[] = (string) $Value;
			$counter++;
		}

		return $Tmp;		
	}

	function get_ArrayFrom($ArrayItems1){
		$Tmp = array();
		
		$counter = 0;
		
		foreach($ArrayItems1 AS $Value){
			$Tmp[] =  $Value;
			$counter++;
		}

		return $Tmp;		
	}
	
	function saveXML($Root, $ATag, $TagArray,$FileName){

		$Str = '<?xml version="1.0" encoding="UTF-8"?>'."\n<$Root>";
		foreach($TagArray as $Value){
			$Str .="\n\t<$ATag>$Value</$ATag>";
		}
		
		$Str .= "\n</$Root>";
		
		file_put_contents($FileName,$Str);
	}
	
	function tempList($ArrayVals,$Class,$Val,$Name){
		$Str ="";
		
		$Str .='<select class="'.$Class.'"   name = "'.$Name.'" >';
		foreach($ArrayVals AS $Key=>$Value){
			$Str .= '<option value="'.$Value.'"';
			if($Value == $Val){
				$Str .=" selected ";
			}
			$Str .= '>'.$Value.'</option>';
		}
		$Str .="</select>";
		
		return $Str;
		
	}

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

function getKey($Arr){
	foreach ( $Arr AS $Key=>$Value){
		break;
	}
	return $Key;
}

function getValue($Arr){
	foreach ( $Arr AS $Key=>$Value){
		break;
	}
	return $Value;
}

function urlOrSectionExists($str, $UrlOrSection){
	if(!is_array($UrlOrSection)) return 0;
	$Exists = false;
	foreach ($UrlOrSection as $key => $value) {
		if($str == $value['string']){
			$Exists = true;
			break;
		}
	}

	return $Exists;
}





	function createMenu(){
		global $PDO;


		 $query = "INSERT INTO admin_menu(string, parent, levl,url) 
		     VALUES(? ,? ,?,?)";

		$pds = $PDO->prepare($query);
		$pds->execute( array(
				$_POST['name'],
				'0',
				$_POST['level'],
				" "
			)
		);

		return $PDO->lastInsertId();
	}

	function createUserMenu(){
		global $PDO;


		 $query = "INSERT INTO menu(string, parent, levl,url) 
		     VALUES(? ,? ,?,?)";

		$pds = $PDO->prepare($query);
		$pds->execute( array(
				$_POST['name'],
				'0',
				$_POST['level'],
				" "
			)
		);

		return $PDO->lastInsertId();
	}

	function updateMenu(){
		
		if(isset($_POST['del'])){
			return deleteMenu($_POST['id']);
		}

		global $PDO;
		pretty_r($_POST);
		 $query = "UPDATE admin_menu SET string =?,  levl=?, url= ?, privilege =?
		     WHERE id=?";

		if( levelChanged($_POST['id'],$_POST['level'])  ){
			detachCHildren($_POST['id']);
			detachParent($_POST['id']);
		}

		if($_POST['level']< '1') {
			$_POST['level'] = '1';
		}
		
		$pds = $PDO->prepare($query);


		$pds->execute( array(
				$_POST['name'],
				$_POST['level'],
				$_POST['url'],
				$_POST['privilege'],
				$_POST['id']
			)
		);

		return "1";
			
	}

	function updateuserMenu(){
		
		if(isset($_POST['del'])){
			return deleteUserMenu($_POST['id']);
		}

		global $PDO;
		 $query = "UPDATE menu SET string =?,  levl=?, url= ?
		     WHERE id=?";

		if( levelChanged($_POST['id'],$_POST['level'])  ){
			detachCHildren($_POST['id']);
			detachParent($_POST['id']);
		}

		if($_POST['level']< '1') {
			$_POST['level'] = '1';
		}
		
		$pds = $PDO->prepare($query);


		$pds->execute( array(
				$_POST['name'],
				$_POST['level'],
				$_POST['url'],
				$_POST['id']
			)
		);

		return "1";
			
	}


	function deleteMenu($id){
		global $PDO;
		 $query = "DELETE FROM admin_menu WHERE id=?";

		$pds = $PDO->prepare($query);
		$pds->execute( array( $id ) );

		return "1";
	}

	function deleteUserMenu($id){
		global $PDO;
		 $query = "DELETE FROM menu WHERE id=?";

		$pds = $PDO->prepare($query);
		$pds->execute( array( $id ) );

		return "1";
	}	

	function levelChanged($id, $level){
		global $PDO;

		$query = "SELECT * FROM admin_menu WHERE id= ? ";

		$pds = $PDO->prepare($query);
		$pds->execute( array( $id ) );
		
		$Result = $pds->fetch();

		return ($Result['levl'] != $level);

	}

	function detachCHildren($id){
		global $PDO;
		$query = "UPDATE admin_menu SET parent= '0'
		     WHERE parent=?";

		$pds = $PDO->prepare($query);
		return $pds->execute( array( $id ) );
	}

	function detachParent($id){
		global $PDO;
		$query = "UPDATE admin_menu SET parent= '0'
		     WHERE id=?";

		$pds = $PDO->prepare($query);
		return $pds->execute( array( $id ) );
	}

	function saveParents(){
		global $PDO;
		$Pdata = json_decode($_POST['parents']);

		foreach ($Pdata as $key => $value) {
			$Pdata[$key] = (array)($value );
		}

		$query = "UPDATE admin_menu SET parent= ?
		     WHERE id=?";

		$pds = $PDO->prepare($query);

		foreach ($Pdata as $key => $value) {
			foreach ($value as $key2 => $value2) {
				$pds->execute( array($value2,$key2 ) );
			}//foreach
		}//foreach
	}




function createList($Dat,$id,$level, $Val="0",$class=NULL){
	
	$Str = '<select id="'.$id.'" value="'.$Val.'" class ="'.$class.'" >';
	
	
	foreach ($Dat as $key => $value) {
		
		if($value["levl"]==$level){
			
			$Str .= "\n".'<option value="'.$value["id"].'"';
			
			if($value['id'] == $Val){
				$Str .= ' selected ';
			}

			$Str .= '>'.
			$value["string"].
			'</option>';
			
		}
	}

	$Str .= '</select >';
	return $Str;
}

	function getMenus(){
		global $PDO;

		$query = "SELECT * FROM  admin_menu WHERE 1 ";
		$Result = $PDO->query($query);

		return $Result->fetchAll(2);
	}


	function prePrint_r($Rsc){
		echo "<pre>";
			print_r($Rsc);
		echo "</pre>";
	}
	
	function showError($Err){
		echo $Err;
		die;
	}


class DropdownCreator{ 
		/*
setClass
setID
setName
setValue
setDataArray
setValuekey
setTextkey
getDropdownstring
		*/
		var $TableName, $DataArray, $Value;
		var $ValueKey,$TextKey;
		var $Name, $Class, $ID;
		
		function setClass($C){
			$this->Class = $C;
		}

		function setID($Id){
			$this->ID = $Id;
		}


		function setName($Nm){
			$this->Name = $Nm;
		}
		
		function setValue($Val){
			$this->Value = $Val;
		}
		
		function setDataArray($Darray){
			$this->DataArray = $Darray;
		}

		
		function setValuekey($Vkey){
			$this->ValueKey = $Vkey;
		}
		
		function setTextkey($TKey){
			$this->TextKey = $TKey;
		}
		
		
				
		function getDropdownstring(){
			$Ret = '<select name="'.$this->Name.'" ';
			if($this->ID !=''){
				$Ret .= ' id="'.$this->ID.'" ';
			}
			if($this->Class !=''){
				$Ret .= ' class="'.$this->Class.'" ';
			}

			$Ret .=' >'."\n";
			
			foreach($this->DataArray AS $Key => $Value){
				$Ret .= '<option value="'.$Value[$this->ValueKey].'"';
				
				if($this->Value !='' && $this->Value == $Value[$this->ValueKey]){
					$Ret .= ' selected ';
				}
				$Ret .= '>'.$Value[$this->TextKey].'</option>'."\n";
			}
				
				
				
				$Ret .= '</select >' ;
				
				return $Ret;
			}
}

function objToArray($Obj){
	$ret = array();
	foreach($Obj AS $Key=> $Value){
		if(gettype($Value)	=="object"){
			$ret[$Key]= objToArray($Value);
		}else{
			$ret[$Key]= $Value;
		}
	}//end foreach
	
	return $ret;
}

function createModuleFolder($value,$Folder){
	mkdir("$Folder/$value");

	file_put_contents("$Folder/$value/$value.php", '<?php 
defined(\'_JEXEC\') or die; 
');

}

function removeModuleFolder($Module,$Folder){
	$List = scandir("$Folder/$Module");
	foreach ($List as $key => $value) {
		if( 
			"."!=$value  &&
			".."!=$value &&
			is_file("$Folder/$Module/$value") 
		){
			unlink("$Folder/$Module/$value");
		}elseif (
			"."!=$value  &&
			".."!=$value &&
			is_dir("$Folder/$Module/$value")
		){
			removeModuleFolder("$Folder/$Module/","$value");
		}
	}

	rmdir("$Folder/$Module");
}
?>
