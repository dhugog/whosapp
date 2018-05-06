<!DOCTYPE HTML>
<html>
	<head>
		<?php				
		require_once 'includes/config.inc.php';		
		require_once MYSQL;
		
		$ip = $_SERVER['REMOTE_ADDR'];
		$checkBanned = mysqli_query($conn, "SELECT * FROM usuarios_banidos WHERE ip_usuario = '$ip'");
		if(mysqli_num_rows($checkBanned) > 0) { ?>
			<script>alert('Você foi banido do chat.')</script>
		<?php
			exit;
		}
		
		if(isset($_SESSION['grupo'])) { ?>
			<script>window.location.href = 'chat.php'</script>
                        <?php
			exit;
		}
		
		include_once 'includes/styles.inc.html';
		?>
		<style>		
			body {
				height: auto;					
			}
		
			#main-sec {
				overflow: hidden;
				padding-top: 60px;
				border-radius: 0px 0px 10px 10px;
			}
			
			form:first-child {
				margin-bottom: 60px;
			}
		</style>
	</head>
	
	<body onload="tBugReport()">
		<?php include_once 'includes/header.php' ?>
		<section id='main-sec'>
			<div class='box'>				
				<form method='post' action='criar-grupo.php' name='grupoExistente' class='default-form'>
					<fieldset>
						<p>Entrar em um grupo existente</p>
						<input name="nome" maxlength="50" placeholder="Nome do grupo" required autocomplete="off" />
						<input type="password" name="senha" maxlength="50" placeholder="Senha" />
						<input type='submit' name='btnEntrarGrupo' value='Entrar' />
					</fieldset>
				</form>
				<form method='post' action='criar-grupo.php' name='novoGrupo' class='default-form'>
					<fieldset>
						<p>Criar novo grupo</p>
						<input name="nome" maxlength="50" placeholder="Nome do grupo" required autocomplete="off" />
						<input type="number" name="max" min="1" max="999" placeholder="Máximo de usuários (Opcional)" />
						<input id="cadPass" type="password" name="senha" maxlength="50" placeholder="Senha" value="" />
						<table style="width: 100%;">
							<tr>
								<td style="text-align: center;"><input id="rsprivado" type="radio" name="privado" value="s" checked onClick="activePass()" /> <label for="rsprivado">Privado</label></td>
								<td style="text-align: center;"><input id="rnprivado" type="radio" name="privado" value="n"  onClick="disablePass()" /> <label for="rnprivado">Público</label></td>
							</tr>
						</table>
						<input type='submit' name='btnCriarGrupo' value='Criar' style="z-index: 1;" />
					</fieldset>
				</form>
				<?php
				if(isset($_SESSION['erro'])) { ?>
					<div id="alert-sec">
					<?php
						$erro = $_SESSION['erro'];
						if($erro == 'grupoExistente') {
							echo "<p class='invalid'>Nome ou senha já utilizada. Tente novamente.</p>";
						} elseif($erro == 'lotado') {
							echo "<p class='invalid'>O grupo já está lotado. Tente mais tarde.</p>";
						} elseif($erro == 'dadosIncorretos') {
							echo "<p class='invalid'>Nome ou senha incorreta. Tente novamente.</p>";
						}
						unset($_SESSION['erro']); 
					?>
					</div>
					<?php
				}
				?>
			</div>
		</section>
	
		<?php include_once 'includes/bugreport.html' ?>
		
		<?php include_once 'includes/footer.php' ?>
	</body>
</html>