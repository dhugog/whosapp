<?php
	require_once 'includes/config.inc.php';
	require MYSQL;

	if(isset($_POST['btnCriarGrupo'])) {
		$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);	
		if(isset($_POST['senha']) && $_POST['senha'] != "") {
			$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);	
			$stmtVerify = "SELECT * FROM grupos WHERE nome like '$nome' or senha like '$senha'";
			$query = mysqli_query($conn, $stmtVerify);
			$registers = mysqli_num_rows($query);			
		} else {						
			$stmtVerify = "SELECT * FROM grupos WHERE nome like '$nome'";
			$query = mysqli_query($conn, $stmtVerify);
			$registers = mysqli_num_rows($query);
                        $senha = '';
		}
		
		if(!empty($_POST['max'])) {
			$max = $_POST['max'];
		} else {
			$max = 256;
		}
		
		if($registers > 0) {
			$_SESSION['erro'] = 'grupoExistente';
			header("Location: index.php#alert-sec");
			exit;
		} else {			
			$stmt = "INSERT INTO grupos VALUES(default, '$nome', '$senha', '$max', default)";
			mysqli_query($conn, $stmt);		
			$nstmt = "SELECT * FROM grupos WHERE nome like '$nome' and senha like '$senha'";
			$nstmt = mysqli_query($conn, $nstmt);
			$nGroup = mysqli_fetch_array($nstmt);
			$_SESSION['grupo'] = $nGroup;
			$_SESSION['usuario']['id_usuario'] = $_SESSION['grupo']['total_usuarios'];
			header("Location: chat.php");
			exit;			
		}
	} 
	
	elseif(isset($_POST['btnEntrarGrupo'])) {
		$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
		if(isset($_POST['senha']) && $_POST['senha'] != "") {
			$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);	                        		
		} else {
			$senha = '';
		}
		
		$stmtVerify = "SELECT * FROM grupos WHERE nome like '$nome' and senha like '$senha'";	
		$queryVerify = mysqli_query($conn, $stmtVerify);
		
		if(mysqli_num_rows($queryVerify) > 0) {
			$grupo = mysqli_fetch_array($queryVerify);
			if($grupo['total_usuarios'] < $grupo['max_usuarios']) {
				$_SESSION['grupo'] = $grupo;		
				$_SESSION['grupo']['total_usuarios'] += 1;		
				$user = $_SESSION['grupo']['total_usuarios'];
				$_SESSION['usuario']['id_usuario'] = $user;
				$stmtUsers = mysqli_query($conn, "UPDATE grupos SET total_usuarios = '$user' WHERE nome like '$nome' and senha like '$senha'");
				header("Location: chat.php");
				exit;				
			} else {
				$_SESSION['erro'] = 'lotado';
				header("Location: index.php#alert-sec");
				exit;
			}
		} else {
			$_SESSION['erro'] = 'dadosIncorretos';
			header("Location: index.php#alert-sec");
			exit;
		}
	}
?>