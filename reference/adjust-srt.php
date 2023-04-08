<?php
	$File ="outcome.srt";
	$StartTime = convertToSeconds("00:00:12,000");
	echo "StartTime $StartTime \n";
	$StopTime  = convertToSeconds("02:10:10,359");
	echo "StopTime $StopTime";
	$CorrectStartTime = convertToSeconds("00:00:12,000");
	$CorrectStopTime  = convertToSeconds("01:58:22,000");	

	$srt = file_get_contents($File);
	
	$search   = '/\d+:\d+:\d+,\d+/';
    
	
	preg_match_all($search, $srt, $res);
	
	$res[1] = array();
	
	$c = 1;
	
	$Total1 = $StopTime - $StartTime;
	$Total2 = $CorrectStopTime - $CorrectStartTime;
	
	$Start_Seconds = $StartTime;
	$Start_Seconds2= $CorrectStartTime;
	
	foreach($res[0] AS $Key => $Value){
		
		$sec = convertToSeconds($Value);
		
		if($sec>= $StartTime){
			$sec2 = $Start_Seconds2 + (($sec - $Start_Seconds)/$Total1)*$Total2;
			$res[1][$Key] = convertToT($sec2);
			/*
			echo "sec $sec\n";
			echo "Start_Seconds $Start_Seconds\n";
			echo "Total1 $Total1\n";
			echo "Total2 $Total2\n";
			exit;*/
		}else{
			$res[1][$Key] = $res[0][$Key];
		}
		
	}

	
	
	$out = str_replace($res[0],$res[1], $srt);
	$out = preg_replace('/(\d\d)\.d+/','0$1',$out);
	//echo $out;
	file_put_contents("outcome.srt",$out);
	
	
	
	function convertToSeconds($pattern){
		$pattern = str_replace(',',':',$pattern);
		try{
		$PArray = explode(':',$pattern);
		if(
		!isset($PArray[0]) || 
		!isset($PArray[1]) || 
		!isset($PArray[2]) || 
		!isset($PArray[3])  
		){
			echo ">$pattern<"."\n";
		}
		$Sec = 
		intVal  ($PArray[0])*3600 + 
		intVal  ($PArray[1])*60   +
		intVal  ($PArray[2])      +
		floatval($PArray[3])/1000;
		}catch(Exception $D){
			echo ">$pattern<";
		}
		return $Sec;
	}


	function convertToT($Sec){
		
		
		$Fr = ( $Sec - intVal($Sec) ) * 1000;
		
		$Sec = intVal($Sec);
		
		$T = "";
		$T .= withMinLen(intVal($Sec/3600)."",2);
		
		$Sec = $Sec%3600;
		$T .= ":". withMinLen(intVal($Sec/60)."",2);
		
		$Sec = $Sec%60;
		$T .= ":".withMinLen(intVal($Sec)."",2);
		
		$T.= ",".substr(withMinLen($Fr,3),0,3);
		
		return $T;
	}
	
	function  withMinLen($str,$min){
		$extra_zeroes = $min-strlen($str);
		
		$createed_Z = "";
		for($c= 0 ; $c< $extra_zeroes; $c++){
			$createed_Z .="0";
		}
		
		return $createed_Z .$str;
	}
	//echo $ret;
?>