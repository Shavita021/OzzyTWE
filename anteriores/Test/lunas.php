<html>
<head>
<title>Lunas</title>
</head>
<body>
	<?php
	$lunas = array("Mercurio" => array(),
			"Venus" => array(),
			"Tierra" => array("Moon"),
			"Marte" => array("Phobos","Deimos"),
			"Jupiter" => array("Metis", "Amalthea","Thebe", "Io", "Europa",
					"Ganymede", "Callisto", "Himalia", "Elara", "Carme", "Pasiphae"),
			"Saturno" => array("Prometheus", "Pandora", "Epimetheus",
					"Janus", "Mimas", "Enceladus", "Tethys", "Dione", "Rhea",
					"Titan", "Hyperion", "Iapetus", "Phoebe"),
			"Urano" => array("Bianca", "Cressida", "Desdemona", "Juliet",
					"Portia","Rosalind","Belinda","Puck","Miranda","Ariel",
					"Umbriel","Titania", "Oberon", "Caliban", "Sycorax"),
			"Neptuno" => array("Naiad", "Thalassa", "Despina", "Galatea",
					"Larissa", "Proteus", "Triton", "Nereid"));

	echo "<h2>Mercurio no tiene lunas</h2>";
	echo "<h2>Venus no tiene lunas</h2>";
	echo "<h2>Tierra tiene 1 lunas</h2>";
	$i=1;
	foreach($lunas[Tierra] as $field){
		echo $i." ".$field;
		$i=i+1;
	}
	echo "<h2>Marte tiene 2 lunas</h2>";
	$i=1;
	foreach($lunas[Marte] as $field){
		echo $i." ".$field;
		echo "<br>";
		$i=$i+1;
	}
	echo "<h2>Jupiter tiene 11 lunas</h2>";
	$i=1;
	foreach($lunas[Jupiter] as $field){
		echo $i." ".$field;
		echo "<br>";
		$i=$i+1;
	}
	echo "<h2>Saturno tiene 13 lunas</h2>";
	$i=1;
	foreach($lunas[Saturno] as $field){
		echo $i." ".$field;
		echo "<br>";
		$i=$i+1;
	}
	echo "<h2>Urano tiene 15 lunas</h2>";
	$i=1;
	foreach($lunas[Urano] as $field){
		echo $i." ".$field;
		echo "<br>";
		$i=$i+1;
	}
	echo "<h2>Neptuno tiene 8 lunas</h2>";
	$i=1;
	foreach($lunas[Neptuno] as $field){
		echo $i." ".$field;
		echo "<br>";
		$i=$i+1;
	}
	?>
</body>
</html>
