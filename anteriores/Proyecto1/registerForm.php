<html>
<head>
<title>Register Page</title>
</head>
<body>
	<?php
	$fields_2 = array("user_name"=> "User Name","password"=> "Password",
			"email"=> "Email","first_name"=> "First Name",
			"last_name"=> "Last Name","street"=> "Street",
			"city"=> "City","state"=> "State","zip"=> "Zip",
			"phone"=> "Phone","fax"=> "Fax");
	?>
	<h2>Register Form</h2>
	<form action="register.php" method="POST">
		<?php
		if(isset($message_2)){
			echo "<p class='errors'>$message_2</p>\n";
		}
		foreach($fields_2 as $field => $value){
			if(preg_match("/pass/i",$field))
				$type = "password";
			else
				$type = "text";
			echo "<div id='field'>
			<label for='$field'>$value</label>
			<input id='$field' name='$field' type='$type'
			value='".@$$field."' size='40' maxlength='65' />
			</div>\n";
		} // end foreach field
		?>
		<br> <input type="submit" name="Button" value="Register" />
	</form>
	<p>If you already have an account, log in.</p>
	<form action="loginForm.php">
		<input type="submit" name="Button" value="Login" />
	</form>
</body>
</html>





