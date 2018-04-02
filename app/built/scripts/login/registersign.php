<?php
	include("built/scripts/dbconn.php");
	include("openssl_encrypt.php");

	$errorDisplayed="";
	$username="";
	
	if (isset($_POST['submit'])) {
		$username       = trim($_POST['username']);
		$username       = strtolower($username);		
		$fullname       = trim($_POST['fullname']);
		$newpassword    = trim($_POST['newpassword']);
		$repeatpassword = trim($_POST['repeatpassword']);
		$username       = stripslashes($username);
		$fullname       = stripslashes($fullname);
		$newpassword    = stripslashes($newpassword);
		$repeatpassword = stripslashes($repeatpassword);

		if (empty($username) || empty($newpassword) || empty($repeatpassword) || empty($fullname) ) {
			$errorDisplayed = "Something is missing!";
			return;
		} elseif  ($newpassword != $repeatpassword) {
			$errorDisplayed = "Passwords must be equal!";
			return;
			} else {

			// password encrypt
			$newpassword = encrypt_decrypt('encrypt', $newpassword);

			// db connetion
			$conn = dbConnect();		
			if ($conn->connect_errno) {
				$errorDisplayed ="Error connecting to DB";
			} else {

				mysqli_set_charset($conn, 'utf8');

				// verify is username already exist
				$sql = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");
				$rowcount = mysqli_num_rows($sql);

				if ($rowcount > 0) { // username already exists
					$errorDisplayed = "Username already exists!";
					mysqli_free_result($sql);
					mysqli_close($conn);
					return;
				}

				// inserting the new user
				$sql = mysqli_query($conn, "INSERT INTO user (`fullname`, `username`, `password`, `type`) VALUES('" . $fullname . "', '" . $username . "', '" . $newpassword . "', '2');");

				mysqli_close($conn);

				$errorDisplayed = "Username created!";
				return;

			} // if ($conn)
		} // if some field is empty
	} // if $_POST['submit']

?>
