<?php
// session_name("PHPSESSID");
// 	if (session_status() == PHP_SESSION_NONE) {
// 		session_set_cookie_params(0, '/', '.melanieconfortti.es');
// 		session_start();
// 	}

function dbConnect() {
	$hostname = "85.214.196.189:3306";
	$dbuser = "adminuser";
	$dbpass = "uGpc7#24";
	$dbname = "admin_mehran";

	$conn = new mysqli($hostname,$dbuser,$dbpass,$dbname);

	if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
	} 
	
	return $conn;
}
?>