<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>File Upload</title>
</head>
<body>
	<ol>
		<li>Enter the file name of the product picture you want to upload or
			use the browse button to navigate to the picture file.</li>
		<li>When the path to the picture file shows in the text field, click
			the Upload Picture button.</li>
	</ol>
	<div style='text-align: center'>
		<hr />
		<form enctype="multipart/form-data" action="fileUpload.php"
			method="POST">
			<p>
				<input type="hidden" name="MAX_FILE_SIZE" value="500000" /> <input
					type="file" name="pix" size="60" />
			</p>
			<p>
				<input type="submit" name="Upload" value="Upload Picture" />
			</p>
		</form>
	</div>
</body>
</html>
