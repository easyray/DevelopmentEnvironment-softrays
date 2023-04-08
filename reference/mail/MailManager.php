<?php 

class MailManager{
	var $SenderName, $SenderAddress;
	var $RecepientAddress;
	var $Subject;
	var $Headers;
	var $Message;
	var $MIME_Type;
	var $AttachmentSet;
	var $Content_Type;
	var $Attachment;

	function __construct(){
		$this->SenderName="";
		$this->SenderAddress="";
		$this->RecepientAddress="";
		$this->Subject="";
		$this->Headers="";
		$this->MIME_Type = "MIME-Version: 1.0\r\n";
		$this->AttachmentSet = 0;
		$this->Content_Type = "text/plain";

	}
//----------------------------------------------------
	function setHTMLContent(){
		
		$this->Content_Type = "text/html";

	}
//---------------------------------------------------------

	function addAttachment($File){
		if(!is_file($File)){
			echo "Attachment file ($File) does not exist";
		}
		$this->Attachment = $File;
		$this->AttachmentSet = 1;
	}
//---------------------------------------------------------
	function sendMail(){
		if($AttachmentSet){
			$this->CreateComplexHeader();
			$Result = $this->sendAttachmentMentMail();
		}else{
			$this->CreateSimpleHeader();
			$Result = $this->sendSimpleMail();
		}

		if($Result){
			echo "Could not send mail";
		}

	}
//---------------------------------------------------------	
	function sendSimpleMail(){
		mail(
			$this->RecepientAddress, 
			$this->Subject, 
			$this->Message,
			$this->Headers
		);
	}
//---------------------------------------------------------
	function sendAttachmentMentMail(){
		mail(
			$this->RecepientAddress, 
			$this->Subject, 
			"",
			$this->Headers
		);
	}
//---------------------------------------------------------

	function 	CreateSimpleHeader(){
		//From
		$this->Headers = "From: ".
		$this->SenderName." <".
		$this->SenderAddress.">\r\n";
		//MIME
		$this->Headers .= "MIME-Version: 1.0\r\n";
		//Content Type
		$this->Headers .= "Content-Type: ".
		$this->Content_Type.
		"; charset=ISO-8859-1\r\n";
	}
//---------------------------------------------------------
	function CreateComplexHeader(){
	
	//read file
	$file_size = filesize($this->Attachment);
	$handle = fopen($this->Attachment, "r");
	$content = fread($handle, $file_size);
	fclose($handle);
	
	$content = chunk_split(base64_encode($content));
	
	$uid = md5(uniqid(time()));
	
	$header = "From: ".
	$this->SenderName." <".
	$this->SenderAddress.">\r\n";


	$this->Headers .= "MIME-Version: 1.0\r\n";
	$this->Headers .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
	$this->Headers .= "This is a multi-part message in MIME format.\r\n";
	$this->Headers .= "--".$uid."\r\n";

	$this->Headers .= "Content-type: ".
	$this->Content_Type.
	"; charset=iso-8859-1\r\n";


	$this->Headers .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
	
	$this->Headers .= $this->Message."\r\n\r\n";

	$this->Headers .= "--".$uid."\r\n";
	
	//Attachment
	$this->Headers .= "Content-Type: application/octet-stream; name=\"".
	basename($this->Attachment).
	"\"\r\n"; 

	$this->Headers .= "Content-Transfer-Encoding: base64\r\n";
	$this->Headers .= "Content-Disposition: attachment; filename=\"".
	basename($this->Attachment).
	"\"\r\n\r\n";

	$this->Headers .= $content."\r\n\r\n";
	$this->Headers .= "--".$uid."--";

	}
//---------------------------------------------------------	
}