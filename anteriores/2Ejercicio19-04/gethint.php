<?php
$a = array(
	"Anna","Brittany","Cinderella","Diana","Eva","Fiona","Gunda","Hege","Inga","Johanna",
	"Kitty","Linda","Nina","Ophelia","Petunia","Amanda","Raquel", "Rachel","Cindy","Doris","Eve","Evita","Sunniva","Tove",
	"Unni","Violet","Liza","Elizabeth","Ellen","Wenche","Vicky");

	$q1 = $_GET("q");
	$q=$q1.toUpperCase();
	$hint="";
	if (srlength($q) > 0) {		 
		for ($i=0; i<30; $i++){
			$test1=$a[i].substring(0,strlength($q));
			$test=strtoUpperCase($test1);
			if ($q==$test){
				if ($hint=="") 
					$hint=$a[i];
				else 
					$hint=$hint+", "+$a[i];
			}
		}
	}
	if ($hint=="")
		echo "no suggestion";
	else echo $hint;
?>