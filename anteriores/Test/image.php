<?php 
header("Content-type: image/png");
$im = imagecreate (300, 200);
$blanco = imagecolorallocate($im, 255, 255, 255);
$blue = imagecolorallocate($im, 0, 0, 255);
imageline ($im, 5, 5, 195, 195, $blue);

imagerectangle ($im, 5 ,10 ,195, 50 ,$blue);
imagefilledrectangle ($im, 5, 100, 195, 140, $blue);

imagefilledarc ($im, 150, 50, 100, 100, 0, 0, $blue, IMG_ARC_PIE);

imagestring($im, 10, 10, 100, "Hello !", $blanco);

imagepng($im);

?>