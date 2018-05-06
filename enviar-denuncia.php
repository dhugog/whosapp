<?php
	require_once 'includes/config.inc.php';
	require MYSQL;
	
	$idMsg = $_POST['idMsg'];
		
	$msg = mysqli_query($conn, "SELECT * FROM mensagens WHERE id_mensagem = '$idMsg'");
	$msg = mysqli_fetch_array($msg);
	$data = $msg['data_envio'];
	$grupo = $msg['grupo'];
	$denunciado = $msg['ip_usuario'];
	$denunciador = $_SERVER['REMOTE_ADDR'];
	$data = date('Y-m-d H:i:s');
	
	$denuncias = mysqli_query($conn, "SELECT * FROM denuncias WHERE denunciador = '$denunciador' and mensagem = '$idMsg'");

	if($denunciado == $denunciador) {
		echo 'Tem certeza que deseja se denunciar? KKK';
	} else if(mysqli_num_rows($denuncias) >= 1) {
		echo 'Mensagem já denunciada. Aguarde enquanto verificamos.';
	} else {
		mysqli_query($conn, "INSERT INTO denuncias VALUES(default, '$idMsg', '$data', '$denunciado', '$denunciador', '$grupo', '$data')");
		echo 'Mensagem denunciada! Aguarde enquanto analisamos.';
	}
?>
