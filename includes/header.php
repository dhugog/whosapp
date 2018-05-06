<header>
	<h1>Who's App</h1>
	<?php 
		if(isset($_SESSION['grupo'])) {
			$id = $_SESSION['grupo']['id_grupo'];
			$nomeGrupo = $_SESSION['grupo']['nome'];
			
			$totUsers = mysqli_query($conn, "SELECT total_usuarios FROM grupos WHERE id_grupo = $id");
			$totUsers = mysqli_fetch_array($totUsers);
			
			$_SESSION['grupo']['total_usuarios'] = $totUsers[0];
			$maxUsuarios = $_SESSION['grupo']['max_usuarios'];
			$totalUsuarios = $_SESSION['grupo']['total_usuarios'];
			
			echo 
			"<div id='group-info'>
				<ul>
					<li><h2 id='nomeGrupo'>Grupo $nomeGrupo</h2></li>
					<li><span id='totUsers'>$totalUsuarios / $maxUsuarios</span></li>
				</ul>
			</div>";			
		}
	?>
	<p id="bugReport" onClick="document.getElementById('secBugReport').style.display = 'block'"><span>Contato</span></p>
</header>
