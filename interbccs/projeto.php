<?php
  include('../connection/connection.php');

	$flag = true;
	if (isset($_POST['id_proj'])) {
	//Realiza uma busca no banco de dados para os projetos
	$scriptSQL = "SELECT *
								FROM projeto
								WHERE id_projeto =".$_POST['id_proj'];

	$result = $conn->query($scriptSQL);
	$vetor = $result->fetch_object();
	
	//Realiza uma busca no banco de dados para os professores
	$scriptProf = "SELECT professor.nome, professor.sexo, professor.site
								FROM professor NATURAL JOIN proj_prof
								WHERE proj_prof.id_projeto =".$_POST['id_proj'];
		
	$resultProf = $conn->query($scriptProf);
	$profnum = $resultProf->num_rows;
	//Realiza uma busca no banco de dados para as áreas
	$scriptArea = "SELECT area.nome
								FROM area NATURAL JOIN area_proj
								WHERE area_proj.id_projeto =".$_POST['id_proj']."
								ORDER BY area.nome asc";
		
	$resultArea = $conn->query($scriptArea);
	$areanum = $resultArea->num_rows;
	}
else {
	$flag = false;
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<meta name="author" content="Lucas Penteado Sacchi">
	<meta name="author" content="Sofia de Almeida Machado da Silveira">	
	<title>InterBCCS</title>
	<link rel="shortcut icon" type="image/png" href="../Imagens/Inter%20BCCS%20Logo%20Fundo%20Branco.png">

	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../js/bootstrap.min.js">
	<link rel="stylesheet" href="../css/navbarfooter.css">
	<link rel="stylesheet" href="../css/projStyle.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>

	<div id="wrapperHeader">
		<div id="header">
			<a href="interbccs.php">
          <img src="../Imagens/CapaHeader.png" alt="imagem capa" width="100%"/>
        </a>
		</div>
	</div>

	<div class="topnav">
		<a class="nav-link" href="./interbccs.php">Home</a>
		<a class="nav-link" href="./professor.php">Professor</a>
		<a class="nav-link" href="./area.php">Área</a>
		<a class="nav-link" href="./ano.php">Ano</a>

		
		<div class="search-container">
			<form action="./busca.php" method="POST">
				<input type="hidden" name="busca" value="true">
				<input type="text" placeholder="Buscar" name="search">
				<button type="submit"><i class="fa fa-search"></i></button>
			</form>
		</div>
		
	</div>

	<br><br>

	<div class="container">
		<?php
		if ($flag) {
		?>
		<div class="card">
			<div class="card-proj">
				<div class="flex-row d-flex justify-content-center col-md-12">
					<div class="card-img">
						<img class="card-img" src="../Imagens/<?php echo $vetor->foto;?>">
					</div>
				</div>
				<div class="bloco">
					<div class="flex-row d-flex justify-content-center">
						<div class="card-block">
							<h3 class="card-text"><strong><?php echo $vetor->nome;?></strong></h3>
						</div>
					</div>
				</div>				
				<div class="bloco">
					<div class="flex-row d-flex justify-content-start">
						<div class="card-block">
							<p class="card-text text-justify"><?php echo nl2br($vetor->descricao);?></p>
						</div>
					</div>
				</div>
				<br>
				<?php
				if ($vetor->site_proj != NULL) {
				$str = $vetor->site_proj;
				?>
				<div class="bloco">
					<div class="flex-row d-flex justify-content-start">
						<?php
							if (substr($str, 0, 4) == "http") {
							?>
								<label><strong>Link do projeto:&nbsp;</strong></label>
								<a href="<?php echo "$vetor->site_proj";?>" target="_blank"><?php echo "$vetor->site_proj";?></a>
							<?php
							}
							else {
							?>
								<label><strong>Link do projeto:&nbsp;</strong></label>	
								<a href="<?php echo "http://$vetor->site_proj";?>" target="_blank"><?php echo "http://$vetor->site_proj";?></a>
							<?php
							}
						?>
					</div>
				</div>
				<?php
					}
				?>
				<div class="bloco">
					<div class="flex-row d-flex justify-content-start">
						<?php
							if ($profnum > 1) {
								echo '<label><strong>Docentes:&nbsp;</strong></label>';
							}
							else {
								echo '<label><strong>Docente:&nbsp;</strong></label>';
							}
			
							while ($prof = $resultProf->fetch_object()) {
								if ($prof->sexo == 'M') {
									if ($prof->site != NULL) {
										?>
											<a href="http://<?php echo $prof->site;?>" target="_blank">Prof. Dr. <?php echo $prof->nome;?></a>
										<?php	
									}
									else {
										?>
											<label>Prof. Dr. <?php echo $prof->nome;?></label>
										<?php											
									}			
								}
								else {
									if ($prof->site != NULL) {
										?>
											<a href="http://<?php echo $prof->site;?>" target="_blank">Profa. Dra. <?php echo $prof->nome;?></a>
										<?php	
									}
									else {
										?>
											<label>Profa. Dra. <?php echo $prof->nome;?></label>
										<?php											
									}
								}
								if ($profnum == 1) {
									
								}
								else if ($profnum == 2) {
									echo "&nbsp;e&nbsp;";
								}
								else {
									echo ",&nbsp;";
								}
								$profnum--;
							}
						?>
					</div>
				</div>
				<?php
					if ($vetor->alunos != NULL) {
				?>
				<div class="bloco">
					<div class="flex-row d-flex justify-content-start">
						<label><strong>Alunos participantes:&nbsp;</strong><?php echo $vetor->alunos;?></label>
					</div>
				</div>
				<?php
					}
				?>
				<div class="bloco">
					<div class="flex-row d-flex justify-content-start">
						<label><strong>Ano do início:&nbsp;</strong></label>
						<?php echo $vetor->data_inicio;?>
						<?php
						if ($vetor->concluido) {
							echo "(Concluído)";
						}
						else {
							echo "(Em andamento)";
						}
						?>
					</div>
				</div>
				<div class="bloco">
					<div class="flex-row d-flex justify-content-start">
						<?php
							if ($areanum > 1) {
								echo '<label><strong>Áreas:&nbsp;</strong></label>';
							}
							else {
								echo '<label><strong>Área:&nbsp;</strong></label>';
							}			
							while ($area = $resultArea->fetch_object()) {
								?>
									<label><?php echo $area->nome;?></label>
								<?php
								if ($areanum == 1) {
									
								}
								else if ($areanum == 2) {
									echo "&nbsp;e&nbsp;";
								}
								else {
									echo ",&nbsp;";
								}
								$areanum--;
							}
						?>
					</div>
				</div>				
			</div>
		</div>
		<?php
		}
		else {
		?>
		
		
		<?php
		}
		?>
	</div>

	<br><br>

	<footer class="mojFooter">
		<div class="footertexto py-3">
			<a class="footer-link" href="http://www.sorocaba.ufscar.br/ufscar/">Universidade Federal de São Carlos - Campus Sorocaba</a>
			<br>
			<a class="footer-link" href="https://dcomp.sor.ufscar.br">Departamento de Ciência da Computação</a>
			<a href="interbccs.html">
				<img src="../Imagens/Inter%20BCCS%20Logo%20Fundo%20Branco.png" class="float-right" alt="logo" width="8%"/>
			</a>
			<br><br>

			<p>Rodovia João Leme dos Santos (SP-264), Km 110<br>Bairro do Itinga - Sorocaba - São Paulo - Brasil<br>CEP 18052-780</p>
			<div class="foot" align="center">© 2018 InterBCCS. All rights reserved.</div>
		</div>
	</footer>

</body>

</html>
