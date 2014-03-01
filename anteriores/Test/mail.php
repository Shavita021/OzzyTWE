<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
// The message
$message = "Hola";
$from = "thef1@domain.com";
$headers = "From:$from";

// In case any of our lines are larger than 70 characters, we should use wordwrap()

// Send
$var = mail('torquemadage@gmail.com', 'Mensaje Nuevo', $message, $headers);

echo $var;
?>
