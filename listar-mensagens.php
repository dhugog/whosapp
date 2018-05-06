<?php		
	require_once 'includes/config.inc.php';
	require_once MYSQL;
		
	$grupo = $_SESSION['grupo']['id_grupo'];
	$query = mysqli_query($conn, "SELECT id_mensagem, mensagem, DATE_FORMAT(data_envio, '%H:%i') as data_envio, id_usuario, total_usuarios, max_usuarios FROM mensagens RIGHT JOIN grupos ON mensagens.grupo = grupos.id_grupo WHERE grupos.id_grupo = '$grupo' and mensagem != ''");
	while($row = mysqli_fetch_assoc($query)) {
		$msgs[] = array_map('htmlentities', $row);					
	}	
	
	echo html_entity_decode(json_encode($msgs));
?>
