<html>
<head>
<title>Customer Login Page</title>
</head>
<body>
	<?php
	$fields_1 = array("fusername" => "User Name","fpassword" => "Password");

	?>
	<h2>Login Form</h2>
	<form action="login.php" method="POST">
		<?php
		if (isset($message_1)){
			echo "<p class='errors'>$message_1</p>\n";
		}
		foreach($fields_1 as $field => $value){
			if(preg_match("/pass/i",$field))
				$type = "password";
			else
				$type = "text";
			echo "<div id='field'>
			<label for='$field'>$value</label>
			<input id='$field' name='$field' type='$type'
			value='".@$$field."' size='20' maxlength='50' />
			</div>\n";
		}
		?>
		<br> <input type="submit" name="Button" value="Login" />
	</form>
	<p>If you do not have an
		account, register now.</p>
	<form action="registerForm.php">
		<input type="submit" name="Button" value="Register" />
	</form>
</body>
</html>
