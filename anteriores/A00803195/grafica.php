<?php
$seleccion = $_POST["opcion"];
$cxn = mysqli_connect("localhost","root","torque","MEXICO") or die("Query died: connect");
$sql = "SELECT grupo1,grupo2,grupo3 FROM poblacion WHERE censo=$seleccion";
$result = mysqli_query($cxn,$sql) or die("Query died: fuser_name");

$row = mysqli_fetch_array($result);
$valor1 = $row["grupo1"]*.01;
$valor2 = $row["grupo2"]*.01;
$valor3 =  $row["grupo3"]*.01;
mysql_free_result($result);
mysql_close($cxn);
header("Content-type: image/png");
$im = imagecreate (500, 500);
$blanco = imagecolorallocate($im, 255, 255, 255);
$negro = imagecolorallocate($im, 0, 0, 0);
$rojo = imagecolorallocate($im, 255, 0, 0);
$amarillo = imagecolorallocate($im, 255, 255, 0);
$verde = imagecolorallocate($im, 102, 204, 0);

imagestring($im, 5, 10, 15, "Poblacion de Mexico en $seleccion", $negro);

imagefilledarc ($im, 250, 250, 300, 300, 0, ($valor1*360), $rojo, IMG_ARC_PIE);
imagefilledarc ($im, 250, 250, 300, 300, ($valor1*360), (($valor2*360)+($valor1*360)), $amarillo, IMG_ARC_PIE);
imagefilledarc ($im, 250, 250, 300, 300, (($valor2*360)+($valor1*360)), 360, $verde, IMG_ARC_PIE);
imagearc($im, 250, 250, 300, 300, 0, 360, $negro);

imagefilledrectangle ($im, 10, 440, 25, 450, $rojo);
imagefilledrectangle ($im, 10, 455, 25, 465, $amarillo);
imagefilledrectangle ($im, 10, 470, 25, 480, $verde);

$valor1 = $valor1*100;
$valor2 = $valor2*100;
$valor3 = $valor3*100;
imagestring($im, 3, 40, 440, "0-29 anios $valor1%", $negro);
imagestring($im, 3, 40, 455, "30-59 anios $valor2%", $negro);
imagestring($im, 3, 40, 470, "> 60 anios $valor3%", $negro);

imagepng($im);
?>