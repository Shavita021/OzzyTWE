<?php
/* File: SecretPage.php
 * Desc: Displays a welcome page when the user
*
successfully logs in or registers.
*/
echo "<html>";
session_start();
if(@$_SESSION['auth'] != "yes"){
	header("Location: loginForm.php");
	exit();
}
echo "<head><title>Secret Page</title></head>
<body>";
echo "<p style='text-align: center; font-size: 1.5em;
font-weight: bold; margin-top: 1em'>
The User ID, {$_SESSION['logname']}, has
successfully logged in</p>";
echo "</body></html>";
?>



