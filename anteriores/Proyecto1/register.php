<?php
foreach($_POST as $field => $value){
	if ($field != "fax"){
		if ($value == ""){
			$blanks[] = $field;
		}
		else{
			$good_data[$field] = strip_tags(trim($value));
		}
	}
}
if(isset($blanks)){
	$message_2 = "The following fields are blank. Please enter the required information: ";
	foreach($blanks as $value){
		$message_2 .="$value, ";
	}
	extract($good_data);
	include("registerForm.php");
	exit();
} // end if blanks found

/* validate data */
foreach($_POST as $field => $value){
	if(!empty($value)){
		if(preg_match("/name/i",$field) and
				!preg_match("/user/i",$field) and
				!preg_match("/log/i",$field)){
			if (!preg_match("/^[A-Za-z' -]{1,50}$/",$value)){
				$errors[] = "$value is not a valid name. ";
			}
		}
		if(preg_match("/street/i",$field) or
				preg_match("/addr/i",$field) or
				preg_match("/city/i",$field)){
			if(!preg_match("/^[A-Za-z0-9.,' -]{1,50}$/",$value)){
				$errors[] = "$value is not a valid address or city. ";
			}
		}
		/*if(preg_match("/state/i",$field)){
			if(!preg_match("/^[A-Z][A-Z]$/",$value)){
				$errors[] = "$value is not a valid state code. ";
			}
		}*/
		if(preg_match("/email/i",$field)){
			if(!preg_match("/^.+@.+\\..+$/",$value)){
				$errors[] = "$value is not a valid email address. ";
			}
		}
		if(preg_match("/zip/i",$field)){
			if(!preg_match("/^[0-9]{5,5}(\-[0-9]{4,4})?$/", $value)){
				$errors[] = "$value is not a valid zipcode. ";
			}
		}
		if(preg_match("/phone/i",$field) or preg_match("/fax/i",$field)){
			if(!preg_match("/^[0-9)(xX -]{7,20}$/",$value)){
				$errors[] = "$value is not a valid phone number. ";
			}
		}
	} // end if not empty
} // end foreach POST
foreach($_POST as $field => $value){
	$$field = strip_tags(trim($value));
}
if(@is_array($errors)){
	$message_2 = "";
	foreach($errors as $value){
		$message_2 .= $value."Please try again<br />";
	}
	include("registerForm.php");
	exit();
} // end if errors are found

/* check to see if user name already exists */
include("db.inc");
$cxn = mysqli_connect($host,$user,$password,$database) or die("Query died: connect");
$sql = "SELECT user_name FROM Customer WHERE user_name='$user_name'";
$result = mysqli_query($cxn,$sql) or die("Query died: user_name.");
$num = mysqli_num_rows($result);
if($num > 0){
	$message_2 = "$user_name already used. Select another User Name.";
	include("registerForm.php");
	exit();
}else{
	$today = date("Y-m-d");
	$sql = "INSERT INTO Customer (user_name,create_date,password,first_name,last_name,street,city,state,zip,phone,fax,email) VALUES
	('$user_name','$today','$password','$first_name', '$last_name','$street','$city','$state','$zip','$phone','$fax','$email')";
	mysqli_query($cxn,$sql);
	$_SESSION['auth']="yes";
	$_SESSION['logname'] = $user_name;
	/* send email to new Customer */
	$emess = "You have successfully registered. ";
	$emess .= "Your new user name and password are: ";
	$emess .= "\n\n\t$user_name\n\t";
	$emess .= "$password\n\n";
	$emess .= "We appreciate your interest. \n\n";
	$emess .= "If you have any questions or problems,";
	$emess .= " email service@ourstore.com";
	$subj = "Your new customer registration";
	$mailsend=mail($email,$subj,$emess);
	header("Location: SecretPage.php");

} // end else no errors found

?>