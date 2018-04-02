<?php
	session_name("PHPSESSID");
	session_start();
	session_destroy();
	
	echo json_encode(array());
?>