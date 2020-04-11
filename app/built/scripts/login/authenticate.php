<?php
	include("openssl_encrypt.php");

	include_once 'built/scripts/dbConnect.php';
	include_once 'built/scripts/login/class.users.php';

	$errorDisplayed='';
	$msgDisplayed = '';
	$username='';
	
	if (isset($_POST['btn_login'])) {

		$username = stripslashes(strtolower(trim($_POST['username'])));
		$password = stripslashes(trim($_POST['password']));

		// verifing if some field is empty
		if (empty($username) || empty($password)) {
			$errorDisplayed = "User or Password invalid!";
		} else {

			// password encrypt
			$password = encrypt_decrypt('encrypt', $password);

			$USERS = new USERS($DB_connect);

			if ($USERS->isLoginCorrect($username, $password)) {
				header("location: app.php");
			} else {
				$errorDisplayed = "User or password invalid!";
			}

			//	$_SESSION['id']=$row["id"];
			//	$_SESSION['username']=$row["username"];
			//	$_SESSION['password']=$row["password"];
			//	$_SESSION['type']=$row["type"];
			//	$_SESSION['dominio'] = 'http://' . $_SERVER['HTTP_HOST'];
			//	$_SESSION['start'] = time() + (30 * 60);
		}
	}
?>
