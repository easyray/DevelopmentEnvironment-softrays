<?php

	$Images = scandir(dirname(__FILE__));

	foreach ($Images as $key => $value) {
		# code...
		if(
			'.'        != $value &&
			'crop.php' != $value &&
			'..'       != $value 
		){
			cropImage($value,0.2,"dst/$value");
		}
	}


	function cropImage($filename, $ratio,$dst){
	//get image into memory
		
		
		if(is_file($filename) ){

			$ext = getExtension($filename);
			
			if($ext == 'gif'){
				$m_Src = imagecreatefromgif($filename);
			}elseif($ext == 'jpg' ||  $ext == 'jpeg'){
				$m_Src = imagecreatefromjpeg($filename);
			}elseif($ext == 'png'){
				$m_Src = imagecreatefrompng($filename);
			}else{
				return 0;
			}// end if
		}else{
			return 0;
		}// end if


		//create a white image
		$DstWidth  = 276; 
		$DstHeight = 357;
		$m_Dst = imagecreatetruecolor($DstWidth, $DstHeight);		
		
		$color = imagecolorallocate($m_Dst ,255,255,255);
		echo ">$color<\r\n";
		imagefilledrectangle( $m_Dst, 0,0,$DstWidth,$DstHeight,$color);

		//Initial x,y cordinate-position for destination image
		$DstX = 0;
		$DstY = 0;


		//get the dimensions of the source image, 
		//and the coodinate to use

		list($Src_Width, $Src_Height) = getimagesize($filename);
		
		$SrcX = 0;
		$SrcY = 0;

		// coodinates to use to resize the image
		if($Src_Width  > (276/357)*$Src_Height){
			//image is not tall enough
			//get the gap then destination yposition and height
			$ExpectedHeight= intval((357/276)* $Src_Width);
			$GapRatio      = ($ExpectedHeight-$Src_Height)/$ExpectedHeight;
			$DstY          = intval(.5*$GapRatio * $DstHeight );
			$DstHeight     = intval(( 1 - $GapRatio)* $DstHeight);
		}
		
		if($Src_Width  < (276/357)*$Src_Height){
			//image is not wide enough
			//get the gap then destination xposition and width
			$ExpectedWidth  = intval((276/357)* $Src_Height);
			$GapRatio = ($ExpectedWidth-$Src_Width) /$ExpectedWidth;
			$DstX     = intval(.5*$GapRatio * $DstWidth );
			$DstWidth = intval(( 1 - $GapRatio)* $DstWidth);		
		}
		
		print_r($m_Dst);
		imagecopyresampled($m_Dst, $m_Src, $DstX, $DstY, $SrcX, $SrcY, $DstWidth, $DstHeight, $Src_Width, $Src_Height);
		
		$Dst        =  removeExtension($dst).".jpg";
		

		imagepng($m_Dst, 'image.png',9);
		
		return $Dst;		
	}

	function getExtension($name){
		$nameArr = explode(".", basename($name));
		return $nameArr[1];
	}

	function getFileName($name){
		$nameArr = explode(".", basename($name));
		return $nameArr[0];
	}
	
	function removeExtension($filename){
		
		$FileArray = explode('.', $filename);
		unset($FileArray[sizeof($FileArray)-1]);

		return implode('.', $FileArray);

	}
