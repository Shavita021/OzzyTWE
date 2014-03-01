<?php
$phone = $_GET["phone"];

$cxn = mysqli_connect("localhost","root","torque","pizzeria") or die("No se pudo conectar");
$sql = "SELECT * FROM netprog WHERE phone=$phone";
$result = mysqli_query($cxn,$sql) or die("No se puedieron extraer los datos");

while($row = mysqli_fetch_array($result)){
	print($row[phone]."\n");
	print($row[name]."\n");
	print($row[street1]."\n");
	print($row[city]."\n");
	print($row[state]."\n");
	print($row[zipCode]."\n");
}



?>
