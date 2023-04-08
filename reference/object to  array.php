<?
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
