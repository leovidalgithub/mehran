<?php
	// include("built/scripts/dbconn.php");
	include("openssl_encrypt.php");

	include_once 'built/scripts/dbConnect.php';
	include_once 'built\scripts\class.userstype.php';
	include_once 'built\scripts\login\class.users.php';

	$errorDisplayed="";
	$username="";

	//	Getting Users Type
	$USERSTYPE = new USERSTYPE($DB_connect);
	$usersType = $USERSTYPE->getAllUsersType();

	if (isset($_POST['btn_register'])) {
		$username       = stripslashes(strtolower(trim($_POST['username'])));
		$newpassword    = stripslashes(trim($_POST['newpassword']));
		$repeatpassword = stripslashes(trim($_POST['repeatpassword']));
		$fullname       = stripslashes(trim($_POST['fullname']));
		$address        = stripslashes(trim($_POST['address']));
		$phone          = stripslashes(trim($_POST['phone']));
		$email          = stripslashes(trim($_POST['email']));
		$usertype       = $_POST['usertype'];

		if (empty($username) || empty($newpassword) || empty($repeatpassword) || empty($fullname) ) {
			$errorDisplayed = "Something is missing!";
			return;
		} elseif  ($newpassword != $repeatpassword) {
			$errorDisplayed = "Passwords must be equal!";
			return;
		} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errorDisplayed = 'Please enter a valid email address!';
		} else {
			// password encrypt
			$newpassword = encrypt_decrypt('encrypt', $newpassword);

			$USERS = new USERS($DB_connect);

			if ($USERS->isUsernameAlreadyTaken($username)) {
				$errorDisplayed = 'Oops! The username is already taken!';
				return;
			}

			if ($USERS->registerNewUser($username, $newpassword, $fullname, $address, $phone, $email, $usertype)) {
				header("location: ./login.php?username=$username");
			} else {
				$errorDisplayed = 'Oops! Something went wrong!';
			}
		}
	}
?>
