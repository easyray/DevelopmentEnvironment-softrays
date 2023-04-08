<?php
	include ("functions.php");
	

	if(is_file("module-routing.json")){
		$Tmp_Route = (array) json_decode(file_get_contents("assign-template.json"));
		
		$HeadCode = '<?php
		
		define ("_JEXEC",1);

		//Database connection
		$PDO = "";
		include ("forbidden/db_connect.php");
		
		//plugin
		include("plgin.php");

		// Get page name
		$PageName     = $_GET["p"];
		
		';
		
		
		$Tmp_Route2 = array();
		foreach( $Tmp_Route AS $Key=>$Value){
			$Tmp_Route2[$Value]= array();
		}

		foreach( $Tmp_Route AS $Key=>$Value){
			array_push($Tmp_Route2[$Value],$Key);
		}
		

		foreach( $Tmp_Route2 AS $Key=>$Value){
			$HeadCode .='
				switch($PageName ){
			';
			foreach($Value AS $VValue){	
				$HeadCode .= '
							case "'.$VValue.'":';
			}
			$HeadCode .= '  include("templates/'.$Key.'/index.php"); break ;';
			$HeadCode .= '
						}';
		}
			
			

		file_put_contents("../index.php", $HeadCode);
		
	}
	/*****/

	if(is_file("module-routing.json")){
		
		$Route = (array) json_decode(file_get_contents("module-routing.json"));
		
		$Default = (array) json_decode(file_get_contents("section-module.json"));
		
		
		$RouteCode = '<?php
	defined("_JEXEC") or die;
function route($PageName, $Section){
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

		file_put_contents("../router.php",$RouteCode);	
	}

	
	if(is_file("plugins.xml")){
		$Plugins = simplexml_load_string(file_get_contents("plugins.xml"));

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
		
		file_put_contents("../plgin.php",$PluginCode);
		
	}// end if	

