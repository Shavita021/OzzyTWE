<?php
$columna = $_GET["columna"];
$poner = $_GET["poner"];
$id = $_GET["id"];
$numFila = $_GET["numFila"];
$borrarID = $_GET["borrarID"];
if(isset($borrarID)){
	$cxn = mysqli_connect("localhost","root","torque","usuarios") or die("No se pudo conectar a la base de datos");
	$sql = "DELETE FROM registrados WHERE id=$borrarID";
	$result = mysqli_query($cxn,$sql) or die("No se pudo ejecutar el queri");
	mysqli_free_result($result);
	mysqli_close($cxn);
}
if(isset($numFila)){
	$numFila = $numFila+1;
	$cxn = mysqli_connect("localhost","root","torque","usuarios") or die("No se pudo conectar a la base de datos");
	$sql = "INSERT INTO registrados VALUES('$numFila','Nombre','Apellido','Direccion','Codigo','Ciudad','0','Email')";
	$result = mysqli_query($cxn,$sql) or die("No se pudo ejecutar el queri");
	mysqli_free_result($result);
	mysqli_close($cxn);
	echo "<tr id='$numFila'>";
	echo "<td id='nombre' class='celda' ondblclick='modificar(this)'>Nombre</td>";
	echo "<td id='apellido' class='celda' ondblclick='modificar(this)'>Apellido</td>";
	echo "<td id='direccion' class='celda' ondblclick='modificar(this)'>Direccion</td>";
	echo "<td id='codigo' class='celda' ondblclick='modificar(this)'>Codigo</td>";
	echo "<td id='ciudad' class='celda' ondblclick='modificar(this)'>Ciudad</td>";
	echo "<td id='hijos' class='celda' ondblclick='modificar(this)'>0</td>";
	echo "<td id='email' class='celda' ondblclick='modificar(this)'>Email</td>";
	echo "<td>";
	echo "<input type='button' name='$numFila' value='Borrar Fila' onclick='borrarFila(this)'/></td>";
	echo "</td>";
	echo "</tr>";
}else
	if(isset($columna) && isset($poner) && isset($id)){
	$cxn = mysqli_connect("localhost","root","torque","usuarios") or die("No se pudo conectar a la base de datos");
	$sql = "UPDATE registrados SET $columna='$poner' WHERE id='$id'";
	$result = mysqli_query($cxn,$sql) or die("No se pudo ejecutar el queri");
	mysqli_free_result($result);
	mysqli_close($cxn);

}else{

	$cxn = mysqli_connect("localhost","root","torque","usuarios") or die("No se pudo conectar a la base de datos");
	$sql = "SELECT * FROM registrados ORDER BY(id)";
	$result = mysqli_query($cxn,$sql) or die("No se pudo ejecutar el queri");

	echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.1//EN' 'http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd'>
	<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='fr'>
	<head>
	<meta http-equiv='Content-Type' content='text/html;charset=iso-8859-1' />
	<title>Modificacion 'en linea' desde una pagina web</title>
	<link rel='StyleSheet' type='text/css' href='tabla.css' />
	<script type='text/javascript' src='modificacion.js'></script>
	</head>
	<body>
	<h1>Lista de usuarios</h1>
	<table id='tabla-usuarios'>
	<tr>
	<th>Nombre</th>
	<th>Apellido</th>
	<th>Direccion</th>
	<th>Codigo Postal</th>
	<th>Ciudad</th>
	<th>Hijos</th>
	<th>Email</th>
	</tr>";

	while($row = mysqli_fetch_array($result)){
		$ID = $row["id"];
		$nombre = $row["nombre"];
		$apellido = $row["apellido"];
		$direccion = $row["direccion"];
		$codigo = $row["codigo"];
		$ciudad = $row["ciudad"];
		$hijos = $row["hijos"];
		$email = $row["email"];

		echo "<tr id='$ID'>";
		echo "<td id='nombre' class='celda' ondblclick='modificar(this)'>$nombre</td>";
		echo "<td id='apellido' class='celda' ondblclick='modificar(this)'>$apellido</td>";
		echo "<td id='direccion' class='celda' ondblclick='modificar(this)'>$direccion</td>";
		echo "<td id='codigo' class='celda' ondblclick='modificar(this)'>$codigo</td>";
		echo "<td id='ciudad' class='celda' ondblclick='modificar(this)'>$ciudad</td>";
		echo "<td id='hijos' class='celda' ondblclick='modificar(this)'>$hijos</td>";
		echo "<td id='email' class='celda' ondblclick='modificar(this)'>$email</td>";
		echo "<td>";
		echo "<input type='button' name='$ID' value='Borrar Fila' onclick='borrarFila(this)'/></td>";
		echo "</td>";
		echo "</tr>";
	}
	mysqli_free_result($result);
	mysqli_close($cxn);
	echo "	</table>
	<input type='button' id='agregar' value='Agregar Fila' onclick='agregarFila()'/>
	<div id='oculto'></div>
	</body>
	</html>";
}

?>