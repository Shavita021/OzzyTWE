<?php
include("db.inc");
$n_per_page = 2;
if(isset($_POST['Products'])){
	if(!isset($_POST['interest'])){
		header("location: catalog.php");
		exit();
	}
	else{
		if(isset($_POST['n_end'])){
			if($_POST['Products'] == "Previous"){
				$n_start = $_POST['n_end']-($n_per_page)-1;
			}
			else{
				$n_start = $_POST['n_end'] + 1;
			}
		}
		else{
			$n_start = 1;
		}
		$n_end = $n_start + $n_per_page - 1;
		$cxn = mysqli_connect($host,$user,$password,$database);
		$query = "SELECT * FROM Furniture WHERE type='$_POST[interest]' ORDER BY name";
		$result = mysqli_query($cxn,$query)
		or die ("query died: furniture");
		$n=1;
		while($row = mysqli_fetch_assoc($result)){
			foreach($row as $field => $value){
				$products[$n][$field]=$value;
			}
			$n++;
		}
		$n_products = sizeof($products);
		if($n_end > $n_products){
			$n_end = $n_products;
		}
		include("furnitureProducts.php");
	} // end else isset interest
} // end if isset products
else{
	$cxn = mysqli_connect($host,$user,$password,$database);
	$query = "SELECT DISTINCT category,type FROM Furniture ORDER BY category,type";
	$result = mysqli_query($cxn,$query) or die ("Query died: category");
	while($row = mysqli_fetch_array($result)){
		$furn_categories[$row['category']][]=$row['type'];
	}
	include("furnitureIndex.php");
}
?>
