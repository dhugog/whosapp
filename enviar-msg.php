<?php
require_once 'includes/config.inc.php';
require_once MYSQL;

if(trim($_POST['msg']) != "") {
	$msg = filter_input(INPUT_POST, 'msg', FILTER_SANITIZE_SPECIAL_CHARS);
	$grupo = $_SESSION['grupo']['id_grupo'];
	$usuario = $_SESSION['usuario']['id_usuario'];
	$ipUsuario = $_SERVER['REMOTE_ADDR'];
	$data = date('Y-m-d H:i:s');
	
	mysqli_query($conn, "INSERT INTO mensagens VALUES(default, '$msg', '$grupo', '$data', '$usuario', '$ipUsuario')");		
}
?>				
