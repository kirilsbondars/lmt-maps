<?php
require_once("../src/initialize.php");

//$ds = DIRECTORY_SEPARATOR;
//
//$storeFolder = 'uploads';
//
//if (!empty($_FILES)) {
//$tempFile = $_FILES['fileToUpload']['tmp_name'];
//$targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;
//$targetFile =  $targetPath . $_FILES['fileToUpload']['name'];
//move_uploaded_file($tempFile,$targetFile);
//}

header('HTTP/1.1 500 Internal Server Error');
header('Content-type: text/plain');
exit('An error occurred while attempting to upload the file.');

//$layer = new Layer("fileToUpload");
//$layer->upload();
