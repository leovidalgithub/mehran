<?php
	include("built/scripts/dbconn.php");
	include("openssl_encrypt.php");

	$errorDisplayed="";
	$username="";
	
	if (isset($_POST['submit'])) {
		$errorDisplayed = "Authenticating...";

			$username = trim($_POST['username']);
			$username = strtolower($username);
			$password = trim($_POST['password']);
			$username = stripslashes($username);
			$password = stripslashes($password);

			// verifing if some field is empty
			if (empty($_POST['username']) || empty($_POST['password'])) {
				$errorDisplayed = "User or Pass invalid!";
			} else {

			// password encrypt
			$password = encrypt_decrypt('encrypt', $password);

			// db connetion
			$conn = dbConnect();		
			if ($conn->connect_errno) {
				$errorDisplayed ="Error connecting to DB" . $conn->connect_error;
			} else {

				mysqli_set_charset($conn, 'utf8');

				$sql = mysqli_query($conn,"SELECT * FROM user WHERE username='$username' AND password='$password'");
				$rowcount = mysqli_num_rows($sql);

				if ($rowcount == 1) { // if 1 row match, user is ok
					$row=mysqli_fetch_assoc($sql);
					$_SESSION['id']=$row["id"];
					$_SESSION['username']=$row["username"];
					$_SESSION['password']=$row["password"];
					$_SESSION['type']=$row["type"];
					$_SESSION['dominio'] = 'http://' . $_SERVER['HTTP_HOST'];
					$_SESSION['start'] = time() + (30 * 60);

					// redirect to main app.php
					header("location: app.php");
				} else {
					$errorDisplayed = "User or pass invalid!";
				}
				mysqli_free_result($sql);
				mysqli_close($conn);
			} // if ($conn)
		} // if empty some field
	} // if $_POST['submit']

?>
