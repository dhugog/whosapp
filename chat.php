<!DOCTYPE HTML>
<html>
	<head>			
		<?php
		require_once 'includes/config.inc.php';
		require_once MYSQL;

		
		if(!isset($_SESSION['grupo'])) {
			echo "<script>window.location.href = 'index.php';</script>";
			exit;
		}
				
		$ip = $_SERVER['REMOTE_ADDR'];				
		$checkBanned = mysqli_query($conn, "SELECT * FROM usuarios_banidos WHERE ip_usuario = '$ip'");
		if(mysqli_num_rows($checkBanned) > 0) {
			header("Location: index.php");
			exit;
		}
		
		include_once 'includes/styles.inc.html';
		?>		
		<link rel='stylesheet' href='css/chatForm.css' />
		<link rel='stylesheet' href='css/chat.css' />		 	
		<script src="js/ajax.js"></script>
	</head>
	
	<body>
		<?php include_once 'includes/header.php' ?>
		<div id="options">
			<ul>
				<li id='li_denunciar'>Denunciar mensagem</li>
			</ul>
		</div>
		<section id='main-sec'>
		
		</section>
		<form method='post' id='chatForm' action="javascript:void(0);">
			<input name="msg" id="msg" placeholder="Envie aquela direta" autofocus autocomplete="off" onpaste="return false" oncopy="return false" />
			<input type='submit' name='btnEnviar' style="display: none;" />
		</form>
		<div onClick='window.location.reload()' style="cursor: pointer;" id='btnSair'>Sair</div>
		
		<?php include_once 'includes/bugreport.html' ?>
		
		<?php include_once 'includes/footer.php' ?>				
	</body>
</html>
