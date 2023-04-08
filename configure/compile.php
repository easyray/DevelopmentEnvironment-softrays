<?php
    if( isset($_REQUEST["root-folder"]) ){
        $Folder = $_REQUEST["root-folder"].'/';
    }else{
	   $Folder = "";
    }

    $Folder_ = $Folder;

	if(! function_exists("getArrayFrom") ){
		include_once ("functions.php");
	}
	
	

	if(is_file($Folder_."configure/module-routing.json")){
		$Tmp_Route = (array) json_decode(file_get_contents($Folder_."configure/assign-template.json"));
		echo "got default templates<br />";
		$HeadCode = '<?php
		
	$CurrentSection ="";
	global $CurrentSection;
	define ("_JEXEC",1);	


	//Database connection
	$PDO = "";
	include ("forbidden/db_connect.php");
	
		
	// Get page name
	if( isset($_GET["p"])  ){
		$PageName = $_GET["p"];
	}else{
		$Path = parse_url($_SERVER["REQUEST_URI"])   ;
		$Path = $Path["path"];
		$PageName = basename($Path);
	}

	if(
		$PageName == "" ||
		$PageName == basename(SITE_FOLDER) ||
		$PageName == "admin"
	){
		$PageName = "index.php";
	}

		
		';
		$Tmp_Route2 = array();
		
		foreach( $Tmp_Route AS $Key=>$Value){
			$Tmp_Route2[$Value]= array();
		}




		foreach( $Tmp_Route AS $Key=>$Value){
			array_push($Tmp_Route2[$Value],$Key);
		}
		
	
		$HeadCode .='
			switch($PageName ){
			';

		foreach( $Tmp_Route2 AS $Key=>$Value){
			foreach($Value AS $VValue){	
				$HeadCode .= '
							case "'.$VValue.'":';
			}
			$HeadCode .= '  include("templates/'.$Key.'/index.php"); break ;';

		}
			
			
			$HeadCode .= '
					default: 
						echo "the url does not exist";
						break;					
				}

//====================================
/*
function substract($Base,$Path){
	return substr($Path,strlen($Base));
}				
*/
';
		file_put_contents($Folder_."index.php", $HeadCode);
		echo "Saved index <br />";
		
	}else{
		echo "routing file: module-routing.json (missing)";
	}
	/*****/

	if(is_file($Folder_."configure/module-routing.json")){
		
		$Route = json_decode(file_get_contents($Folder_."configure/module-routing.json"));
		$Route = objToArray($Route);

		$Default =  json_decode(file_get_contents($Folder_."configure/section-module.json"));
		$Default = objToArray($Default);
		
		$RouteCode = '<?php
	defined("_JEXEC") or die;
	function getCurrentSection(){
		global $CurrentSection;
		return $CurrentSection;
	}
function route($PageName, $Section){
	global $CurrentSection;
	$CurrentSection = $Section;
	
	$Includement = array();
	switch( $Section ){';
	
	 	foreach($Default AS $Key => $Value ) { 
	 		$counter =0;
	 		$RouteCode .= '
	 	case "'.$Key.'" : 
	 		';

			if(isset($Route[$Key]) && is_array($Route[$Key])){
				$RouteCode2 ="";
				$RouteCode .='
		if(';
				foreach($Route[$Key] AS $Ke2 => $Val ) { 
					if($counter == 0){
						$counter++;
					}else{
						$RouteCode .=' || ';
						$RouteCode2 .='
			';
					}

					$RouteCode .=' $PageName =="'.getKey($Val).'"';
					$RouteCode2 .= 'if( $PageName =="'.getKey($Val).'"){
				$Includement[] = "modules/'.getValue($Val).'/'.getValue($Val).'.php";
			}';
				}// end for
				$RouteCode .= ') { 
				'.$RouteCode2.'
		}else' ;
			}// end if	
		
				$RouteCode .= '		
				$Includement[] = "modules/'.$Value.'/'.$Value.'.php"; break;';
			

		}// end for	
		
		$RouteCode .='
	}
	
	return $Includement;
}';

		file_put_contents($Folder_."router.php",$RouteCode);
		echo "saved router <br />";
	}

	if(is_file($Folder_."configure/plugins.xml")){
		$Plugins = simplexml_load_string(file_get_contents($Folder_."configure/plugins.xml"));

		$Plugins = getArrayFrom($Plugins->plugin);

		$PluginCode = '<?php
	defined("_JEXEC") or die;
	
		
	';

		foreach ($Plugins as $key => $value) {
			$PluginCode .= '
	include("plugins/'.$value.'/'.$value.'.php");
	$_'.$value.' =  new '.$value.'();
	$_'.$value.'->onAfterInitialise();
	';
		}


		
		file_put_contents($Folder_."plgin.php",$PluginCode);
		echo "saved plgn<br />";
		echo "We got there " ; die();	
		
	}// end if	