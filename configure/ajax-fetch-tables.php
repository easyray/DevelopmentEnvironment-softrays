<?php
include __DIR__."/lang.php";
include __DIR__."/DbClass.php";
include ($_REQUEST['root-folder']."/forbidden/db_connect.php");

	switch ($_REQUEST['command']) {
	 	case 'change-t-name':	fetchTables(); break;
	 	case 'add-col'      :
	 	case 'remove-col'   :
	 	case 'change-c-name':	fetchCols(); break;
	 	case 'only-columns' : fetch_Cols() ; break;
	 		# code...
	 		break;
	 	default:
	 		# code...
	 		break;
	 } 

function fetchTables(){
	#code
	//connect to DB
	$data = getDefaultExData();
	$DB = new Database($data);

	$Tables =$DB->getTableNames();
	$Str = '<select class="std-input" name="old-name" > ' ;  
 	foreach($Tables AS $Table){
	 $Str .= '<option>'.$Table.'</option>';  
 	} 
	$Str .= '</select>
	<input type="text" class="std-input" style="padding-left:15px" placeholder="new-name" name="new-name" />
	<input type="submit" value="Rename" class="std-input" />
	<input type="button" value="Cancel" id="cancel-rename" class="std-input" />		
	';
	
	echo json_encode($Str);


}
function getDefaultExData(){
	$data =[];
	$data["path"]  =DATABASE_FILE;
	$data['type']   =0;
	$data["name"]   = basename(
		DATA_FILE,
		pathinfo(DATA_FILE)['extension'] 
	);
	$data["writable"] =true;
	$data["writable_dir"]=true;

	return $data;
}
function fetchCols(){
	$data = getDefaultExData();
	$DB = new Database($data);

	$Tables =$DB->getTableNames();
	$Str = '<select class="std-input" name="old-name" id="old-name">';  
 	foreach($Tables AS $Table){
	 $Str .= '<option>'.$Table.'</option>';  
 	} 
	$Str .= '</select>';
	$Str .= '<select class="std-input" name="old-col-name" id="old-col-name">';  
 	$Columns = $DB->getColumnNames($Tables[0]);
 	foreach($Columns AS $Col){
	 $Str .= '<option>'.$Col.'</option>';  
 	} 
	$Str .= '</select>
		<input type="text" class="std-input" style="padding-left:15px" placeholder="new-name" id="con-rename" name="new-name" />
	<input type="submit" value="Rename" class="std-input" />
	<input type="button" value="Cancel" id="cancel-rename" class="std-input" />		
	';
	
	echo json_encode($Str);
	
}
function fetch_Cols(){
	$data = getDefaultExData();
	$DB = new Database($data);

 	$Columns = $DB->getColumnNames($_REQUEST['table']);

 	$Str = '<select class="std-input" name="old-col-name" id="old-col-name">';
 	
 	foreach($Columns AS $Col){
	 $Str .= '<option>'.$Col.'</option>';  
 	} 
	$Str .= '</select>';
	
	echo json_encode($Str);	
}
?>