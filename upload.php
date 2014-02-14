<?php
$tempFile = $_FILES['Filedata']['tmp_name'];
$fileName = $_FILES['Filedata']['name'];
$fileSize = $_FILES['Filedata']['size'];
move_uploaded_file($tempFile, "uploads/" . $fileName);

$src = imagecreatefromjpeg("uploads/" . $fileName);
$dest = imagecreatetruecolor(1860, 612);

imagecopy($dest,$src,0,0,0,0,620,612);
imagecopy($dest,$src,620,0,0,614,620,612);
imagecopy($dest,$src,1240,0,0,1228,620,612);

imagejpeg($dest,"slideshow/" . $fileName,90);

?>
