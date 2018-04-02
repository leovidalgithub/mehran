<?php
	//phpinfo();
	session_name("PHPSESSID");
	session_start();

	if(isset($_SESSION['login_user'])){
		header("location: ./app/app.php");
	} else {
		header("location: ./app/login.php");
	}
?>
