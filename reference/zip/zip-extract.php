<?php
// Function to Extract ZIP Archive. Returns an Array with the path and name of each file in archive, or error message
// receives 2 arguments: the path-name of the Zip file to open, the directory on server where the ZIP will be extracted
function extractZip($zip_file, $dir_extract) {
  // PHP-MySQL Course - https://coursesweb.net/php-mysql/
  $re_arr = array();     // will store and return the name of the files in archive

  // create ogject of ZipArchive class, and open $zip_file
  $zip = new ZipArchive();
  $res = $zip->open($zip_file);

  // if the $zip_file can be opened
  if($res === TRUE) {
    // traverse the index number of the files in archive, store in array the name of the files in archive
    for($i = 0; $i < $zip->numFiles; $i++) {
      $re_arr[] = $zip->getNameIndex($i);
    }

    // extract the files
    $zip->extractTo($dir_extract);
    $zip->close();    

    return $re_arr;
  }
  else  echo "Failed to open $zip_file , code: $res";
}

  /* Example */

// the path-name of the zip file, and directory to unzip
$zip_file = 'path/name.zip';
$dir_extract = 'dir_to_unzip';

// unzip the $zip_file, get and output the array with names of the extracted files
$files_zip = extractZip($zip_file, $dir_extract);
print_r($files_zip);
?> 