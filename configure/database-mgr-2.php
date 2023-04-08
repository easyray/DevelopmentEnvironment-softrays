<?php

include __DIR__."/lang.php";
include __DIR__."/DbClass.php";
include ($_REQUEST['root-folder']."/forbidden/db_connect.php");


//{"task":"backup","root-folder":"C:\/xampp\/htdocs\/front-end"}
if( isset($_REQUEST["task"]) ){
	
	switch ($_REQUEST['task']) {

		case 'backup' : backupDatabase(); break;
		case 'export' : exportSQL()     ; break;
		case 'export-2': exportSQL2()   ; break;
		case 'restore': echo restoreDB()   ; break;

		case 'import'  : 
		$query = file_get_contents($_FILES['userfile']['tmp_name']);
		importSQL($query)    ; break;
		 
		default:
			# code...
		break;
	}
}
//----------------------------------------------
function backupDatabase(){


	$F_Info =pathinfo(DATABASE_FILE) ;
	copy(
		DATABASE_FILE, 
		dirname(DATABASE_FILE).'/'.
		basename(
			DATABASE_FILE,
			$F_Info['extension']
		).date("_Y-m-d-H.i.s").'.'.
		$F_Info['extension']

	);

	//save-notes
	file_put_contents(
		dirname(DATABASE_FILE).'/'.
		basename(
			DATABASE_FILE,
			$F_Info['extension']
		).date("_Y-m-d-H.i.s").'.txt',
		$_REQUEST['notes']

	);
}
//----------------------------------------------
function exportSQL(){
	global $PDO;


	//connect to DB
	$data = getDefaultExData();
	$DB = new Database($data);

	
	
	//set Export details
	$drop_stmt = true;
	$exp_structure = true;
	$exp_data = true;
	$use_transaction = true;
	$add_comments = true;
	$tables = $DB->getTableNames();
	$FileName = str_replace('../forbs/', "", DATA_FILE);
	//Export database
	header('Content-Type: text/plain');
	// tell the browser we want to save it instead of displaying it
	header('Content-Disposition: attachment; filename="'.$FileName.
		date("_Y-m-d-H.i.s").
		'.sql";');

	$DB->export_sql(
		$tables, $drop_stmt, $exp_structure, 
		$exp_data, $use_transaction, $add_comments
	);

}
//----------------------------------------------
function exportSQL2(){
	global $PDO;


	//connect to DB
	$data = getDefaultExData();
	$DB = new Database($data);

	//set Export details
	$drop_stmt = true;
	$exp_structure = true;
	$exp_data = false;
	$use_transaction = true;
	$add_comments = true;
	$tables = $DB->getTableNames();
	$FileName = str_replace('../forbs/', "", DATA_FILE);
	//Export database
	header('Content-Type: text/plain');
	// tell the browser we want to save it instead of displaying it
	header('Content-Disposition: attachment; filename="'.$FileName.
		date("_Y-m-d-H.i.s").
		'.sql";');

	$DB->export_sql(
		$tables, $drop_stmt, $exp_structure, 
		$exp_data, $use_transaction, $add_comments
	);

}
//------------------------------------------------------
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
//----------------------------------------------
function restoreDB(){
	$HouseOfDb= dirname(DATABASE_FILE);
	$Db = scandir($HouseOfDb);
	
	$DDb=[];

	foreach ($Db as $key => $value) {

		if(
			is_dir("$HouseOfDb/$value") ||
			DATA_FILE == $value
		){
			continue;
		}

		$Ext = pathinfo($value);
		if(
			('db'== $Ext['extension']||
			'sqlite'==$Ext['extension'])
		){
			
			//Extract the original file name without date
			$G= explode("_", $value);
			$H= [];
			for($j=0; $j<sizeof($G)-1; $j++){
				$H[] = $G[$j];
			}
			$H= implode("_", $H);

			//Find the text file that has the same name
			//origninal name =$value. remove the extenstion
			
			$Txt_ = basename($value,$Ext['extension']).'txt';
			if(is_file("$HouseOfDb/$Txt_")){
				$Txt   = file_get_contents("$HouseOfDb/$Txt_");
				$Title = 'title="'.
				str_replace("\n", "", strip_tags(substr($Txt, 0,100))).
				'"';
			}else{
				$Txt = $Title = '';
			}

			

			$DDb[] = array(
				'filename'=>$H,
				'date'=>$G[sizeof($G)-1],
				//'text'=>$Txt,
				'title'=>$Title,
				"txt-file"=>$Txt_
			);

		}	
	}


	$Str = '<input type="button" id="clear-restore" class="std-input" value="Cancel" />
	<ul class="u-menu"> ' ;  
	 foreach($DDb as $database):
	 	$Str .= '<li><a '.$database['title'].'><strong>Name:</strong>'.
		$database['filename'] .
		'<br /><strong> date:</strong> '.
		str_replace(".sqlite", "", str_replace(".db", "", $database['date'])) 
		; 
	 	$Str .= '<br /><form method="post" > 
	 		<input name="date" type="hidden" value="'.$database['date'].'" />
	 		<input name="filename" type="hidden" value="'.$database['filename'].'" />
	 		<input name="root-folder" type="hidden" value="'.$_REQUEST['root-folder'].'" />
	 	<input type="submit" name="use" value="Use" />
	 	<input type="submit" name="delete"  value="delete" />
	 	</form></a></li>';  
	 endforeach; 
	 $Str .= '</ul>';

	 return $Str;
}
//----------------------------------------------
function importSQL($query){
	$data = getDefaultExData();
	$DB = new Database($data);	

	echo $DB->import_sql($query);


}


/*

*/