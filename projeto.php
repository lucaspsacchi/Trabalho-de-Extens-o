<?php
  include('./connection/connection.php');

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

<!-- Head -->
<?php include './includes/head.php'?>

<body>

	<!-- Capa -->
	<?php include './includes/capa.php'?>

	<!-- Topnav -->
	<?php
		$page = 0; // Default
		include './includes/topnav.php'
	?>

	<br><br>

	<div class="container">
		<?php
		if ($flag) {
		?>
		<div class="card">
			<div class="card-proj">
				<div class="flex-row d-flex justify-content-center col-md-12">
					<div class="">
						<img class="card-img" src="./Imagens/<?php echo $vetor->foto;?>">
					</div>
				</div>
				<div class="bloco">
					<div class="flex-row d-flex justify-content-center">
						<div class="card-block-proj">
							<h3 class="card-text"><strong><?php echo $vetor->nome;?></strong></h3>
						</div>
					</div>
				</div>				
				<div class="bloco">
					<div class="flex-row d-flex justify-content-start">
						<div class="card-block-proj">
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

	<!-- Footer -->
	<?php include './includes/footer.php'?>

</body>
</html>
