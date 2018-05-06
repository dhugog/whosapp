<?php
	DEFINE('HOST', 'localhost');
	DEFINE('USER', 'root');
	DEFINE('PASS', '');
	DEFINE('DB', 'whosapp');
	
	$conn = new mysqli(HOST, USER, PASS, DB);
	
	mysqli_query($conn, "SET NAMES 'utf8'");
	mysqli_query($conn, 'SET character_set_connection=utf8');
	mysqli_query($conn, 'SET character_set_client=utf8');
	mysqli_query($conn, 'SET character_set_results=utf8');
?>