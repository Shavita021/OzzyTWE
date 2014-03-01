<?php
/* Script name: fileUpload.php
 * Description: Uploads a file via HTTP with a POST form.
*/
if(!isset($_POST['Upload']))
{
	include("formUpload.html");
}
else
{
	if($_FILES['pix']['tmp_name'] == "none")
	{
		echo "<p style='font-weight: bold'>
		File did not successfully upload. Check the
		file size. File must be less than 500K.</p>";
		include("formUpload.html");
		exit();
	}
	if(!preg_match("/image/",$_FILES['pix']['type']))
	{
		echo "<p style='font-weight: bold'>
		File is not a picture. Please try another
		file.</p>";
		include("formUpload.html");
		exit();
	}
	else
	{
		$destination="/var/www/".$_FILES['pix']['name'];
		$temp_file = $_FILES['pix']['tmp_name'];
		move_uploaded_file($temp_file,$destination);
		echo "<p style='font-weight: bold'>
		The file has successfully uploaded:
		{$_FILES['pix']['name']}
		({$_FILES['pix']['size']})</p>";
	}
}
?>