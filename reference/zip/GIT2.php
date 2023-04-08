<?php 

$RootFolder = "../..";
$NewFiles =
"index.php
modules/top_nav_bar/top_nav_bar.php
modules/user_account/edit-account.php
modules/user_account/model.php
modules/user_account/no-account.php
modules/user_account/user_account.php
plugins/login/login.php
router.php";

$NewFiles = explode("\r\n", $NewFiles);

$zip = new ZipArchive;

if ($zip->open('new_files.zip', ZipArchive::CREATE) === TRUE)
{

	foreach($NewFiles AS $Value){
		// Add random.txt file to zip and rename it to newfile.txt
		$zip->addFile("$RootFolder/$Value", "$Value");
	}
	// All files are added, so close the zip file.
	$zip->close();
}



