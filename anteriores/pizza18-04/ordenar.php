<html>
<head>
<title>Net Prog Pizza</title>
</head>
<body onLoad="document.forms[0].reset();">
<div>
  <p> <img src="logo.gif" alt="Net Prog Pizza" /></p>
  </div>
<p>La orden sera entregada a:</p>
<?php 
$phone = $_GET["phone"];
$order = $_GET["order"];
$address = $_GET["address"];
echo $address;
?>
<br>
<img id="ajax" src="ajax.jpg" />
<br>
<p>Los datos de la orden son:</p>
<br>
<?php 
echo $order;
?>
  </body>
</html>
