<?php

error_reporting(0);

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
echo '<?xml version="1.0" encoding="utf-8"?>';

$tempFile = $_FILES['Filedata']['tmp_name'];
$fileName = $_FILES['Filedata']['name'];
$fileSize = $_FILES['Filedata']['size'];
$result=move_uploaded_file($tempFile, "uploads/" . $fileName);

preg_match("/\[(.*)\]/", $fileName , $matches);
file_put_contents("totalcopies.txt",$matches[1]." ".randomFile("blankshot.jpg"));

if ($matches[1] % 2) {
//echo "This number is not even.";
	copy("blankshot.jpg","uploads/".randomFile("blankshot.jpg"));
}

$totalCopies = $matches[1] -1 ;

for($i=0;$i<$totalCopies;$i++) {
	copy("uploads/" . $fileName,"uploads/".randomFile($fileName));
}

function randomFile($filename) {
	$extension_pos = strrpos($filename, '.'); // find position of the last dot, so where the extension starts
	$thumb = substr($filename, 0, $extension_pos) . '_' . generateRandomString() . substr($filename, $extension_pos);
	return $thumb;
}

function generateRandomString($length = 5) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

if(!$result || $_FILES['Filedata']['error']>0) {
	die("<result><status>Error</status><message>Upload error server returned ".$_FILES['Filedata']['error']."</message></result>");
}

$src = imagecreatefromjpeg("uploads/" . $fileName);
$dest = imagecreatetruecolor(1860, 612);

imagecopy($dest,$src,0,0,0,0,620,612);
imagecopy($dest,$src,620,0,0,614,620,612);
imagecopy($dest,$src,1240,0,0,1228,620,612);

if(!imagejpeg($dest,"slideshow/" . $fileName,90)) {
	die("<result><status>Error</status><message>Error creating slideshow jpeg</message></result>");
}

  die("<result><status>OK</status><message>Image uploaded successfully.</message></result>");

?>
