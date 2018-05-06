<?php 
	require_once 'includes/config.inc.php';
	require_once MYSQL;
	
	$grupo = $_SESSION['grupo']['id_grupo'];
	$query = mysqli_query($conn, "SELECT total_usuarios FROM grupos WHERE id_grupo = '$grupo'");
	$query = mysqli_fetch_array($query);
	$users = $query[0] - 1;
	$nquery = mysqli_query($conn, "UPDATE grupos SET total_usuarios = '$users' WHERE id_grupo = '$grupo'");
	
	session_destroy();
