<?php
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
		var $SearchIndex, $DataSize;
		
		function __construct(){
			$this->SearchIndex = 0;
		}

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
			$ths->DataSize   = sizeof($Darray);
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
		
		function getTextFromKey($I_Key){
			foreach($this->DataArray AS $Key => $Value){
				if($I_Key !='' && $I_Key == $Value[$this->ValueKey]){
					return $Value[$this->TextKey];
				}
			}//end foreach

		}

		function getNextTextFromKey($I_Key){
			
			if(
				$I_Key =='' ||
				$this->SearchIndex >= $this->DataSize

			){
				return 0;
			}

			for($i=$this->SearchIndex;$i < $this->DataSize ; ++$i){
				if( 
					$I_Key == ($this->DataArray[$i])[$this->ValueKey]
				){
					return ($this->DataArray[$i])[$this->TextKey];
				}
			}

			return 0;
		}


		function getNextTextFromKeys($KV_pairs){
			
			if(
				$this->SearchIndex >= $this->DataSize
			){
				return 0;
			}//end-if

			for($i=$this->SearchIndex;$i < $this->DataSize ; ++$i){
				if( 
					$this->rowMatch($KV_pairs,$this->DataArray[$i])
				){
					return ($this->DataArray[$i])[$this->TextKey];
				}//end-if
			}//endfor

			return 0;
		}

		function getNextRowFromKeys($KV_pairs){
			
			if(
				$this->SearchIndex >= $this->DataSize
			){
				return 0;
			}//end-if

			for($i=$this->SearchIndex;$i < $this->DataSize ; ++$i){
				if( 
					$this->rowMatch($KV_pairs,$this->DataArray[$i])
				){
					return ($this->DataArray[$i]);
				}//end-if
			}//endfor

			return 0;
		}
		function rowMatch($KV_pairs,$Row){
			
			foreach ($KV_pairs as $key => $value) {
				if($Row[$key] != $value)	{
					return 0;
				}
			}
		
			return 1;
		}

		function resetSearch(){
			$this->SearchIndex = 0;			
		}
}