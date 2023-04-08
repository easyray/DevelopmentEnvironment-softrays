<?php
	class DropdownCreator{ 
		
		var $TableName, $DataArray, $ParentKey;
		var $ValueKey,$TextKey, $Level;
		var $Name, $Parent;
		
		function setParent($PName){
			$this->	Parent = $PName;
		}
		
		
		function 		setDataArray($Darray){
			$this->DataArray = $Darray;
		}

		function settParentkey($PKey){
			$this->ParentKey = $PKey;
		}
		
		function setValuekey($Vkey){
			$this->ValueKey = $Vkey;
		}
		
		function setTextkey($TKey){
			$this->TextKey = $TKey;
		}
		
		function setLevel($L){
			$this->Level = $L;
		}
		
		function setName($Nm){
			$this->Name = $Nm;
		}
				
		function getDropdownstring(){
			$Ret = '<select name="'.$this->Name.'" >'."\n";

			foreach($this->DataArray AS $Key => $Value){
				$Ret .= '<option value="'.$Value[$this->ValueKey].'"';
				
				if($this->Parent == $Value[$this->ParentKey]){
					$Ret .= ' selected ';
				}
				$Ret .= '>'.$Value[$this->TextKey].'</option>'."\n";
			}
				
				
				
				$Ret .= '</select >' ;
				
				return $Ret;
			}

			
		}
