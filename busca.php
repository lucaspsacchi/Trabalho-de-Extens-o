<?php
  include('./connection/connection.php');

	$flag = true;
	$act = 0;
	$page = 0;
	//Home
	if ($_POST['todos_proj'] == 1) {
		$scriptSQL = "SELECT id_projeto, nome, descricao, foto, enable
						FROM projeto
						WHERE enable = 1
						ORDER BY id_projeto DESC";

		$result = $conn->query($scriptSQL);
		$page = 1;
	}
	//Professor
	else if ($_POST['id_prof'] != NULL) {
		$scriptSQL = "SELECT id_projeto, nome, descricao, foto, enable
						FROM projeto NATURAL JOIN proj_prof
						WHERE proj_prof.id_professor =".$_POST['id_prof']."
						ORDER BY id_projeto DESC";

		$result = $conn->query($scriptSQL);

		// Busca pelas informações do professor
		$scriptSQL = "SELECT nome, descricao, foto, site
						FROM professor
						WHERE id_professor =".$_POST['id_prof']."";

		$rprof = $conn->query($scriptSQL);
		$prof=$rprof->fetch_object();
		$page = 2;
	}
	//Área
	else if ($_POST['id_area'] != NULL) {
		$scriptSQL = "SELECT id_projeto, nome, descricao, foto, enable
						FROM projeto NATURAL JOIN area_proj
						WHERE area_proj.id_area =".$_POST['id_area']."
						ORDER BY id_projeto DESC";

		$result = $conn->query($scriptSQL);
		$page = 3;
	}
	//Ano
	else if ($_POST['ano'] != NULL) {
		$scriptSQL = "SELECT id_projeto, nome, descricao, foto, enable
						FROM projeto
						WHERE data_inicio =".$_POST['ano']."
						ORDER BY id_projeto DESC";

		$result = $conn->query($scriptSQL);
		$page = 4;
	}
	//Busca
	else if ($_POST['search'] != NULL) {
		$string = "'%".$_POST['search']."%'";

		$scriptSQL = "SELECT projeto.id_projeto, projeto.nome, projeto.descricao, projeto.foto, projeto.enable
						FROM area, area_proj, projeto, proj_prof, professor
						WHERE area.id_area = area_proj.id_area AND projeto.id_projeto = area_proj.id_projeto AND projeto.id_projeto = proj_prof.id_projeto AND professor.id_professor = proj_prof.id_professor AND area.nome LIKE ".$string." OR projeto.nome LIKE ".$string." OR projeto.data_inicio LIKE ".$string."
						GROUP BY(projeto.id_projeto)";

		$result = $conn->query($scriptSQL);
		$rows = $result->num_rows;
		if ($rows == 0) {
			$scriptSQL = "SELECT projeto.id_projeto, projeto.nome, projeto.descricao, projeto.foto, projeto.enable
			FROM (proj_prof NATURAL JOIN projeto), professor 
			WHERE professor.id_professor = proj_prof.id_professor AND professor.nome LIKE ".$string." OR projeto.alunos LIKE".$string."
			GROUP BY(projeto.id_projeto)";

			$result = $conn->query($scriptSQL);
			$rows = $result->num_rows;
		}
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
		include './includes/topnav.php'
	?>


	<div class="container">

		<!-- Exibe as informações do professor se a busca vier da tela de professores -->
		<?php 
		if ($_POST['id_prof'] != NULL) {?>
		<div class="card-custom">
			<div class="col-12 col-md-12">
				<center>
					<label style="font-size: 26px;"><strong><?php echo $prof->nome; ?></strong></label><br> <!-- Nome -->
					<?php if ($prof->site != NULL) {
						// Verifica se tem http no começo da url
						if (strncmp('http', $prof->site, 4) == 0) {
							echo "<label><a href='$prof->site' target='_blank'>$prof->site</a></label><br>";
						}
						else {
							echo "<label><a href='http://$prof->site' target='_blank'>http://$prof->site</a></label><br>";
						}
					} ?>
				</center>
			</div>
			<div class="col-12 col-md-12">
				<div class="row">
					<div class="col-3 col-md-3">
						<div class="container-img-prof">
							<img class="card-img" src="./Imagens/<?php echo $prof->foto;?>">
						</div>
					</div>
					<div class="col-9 col-md-9">
						<div class="card-block-prof">
							<p id="over" class="card-text p-buscar"><?php echo $prof->descricao;?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		echo '<br><hr><br>';
		}
		?>

		<!-- Exibe os projetos da busca -->
		<?php
		if ($flag == true) { // Se foi feito alguma busca
			$cont = 0;
			while($vetor=$result->fetch_object()) {
				if ($vetor->enable) {
		?>
				<div class="card">
					<div class="row">
						<!-- Imagem do projeto -->
						<div class="col-xl-4 col-lg-5">
							<div class="container-img-home">
								<img class="card-img" src="./Imagens/<?php echo $vetor->foto;?>">
							</div>
						</div>
						<!-- Título, descrição e botão -->
						<div class="col-xl-8 col-lg-7">
							<div class="card-block-home">
								<h4 class="card-text h4-home"><strong><?php echo $vetor->nome;?></strong></h4>
								<p class="card-text p-home p-truncated"><?php echo $vetor->descricao;?></p>
								<form method="POST" action="./projeto.php">
									<input type="hidden" name="id_proj" value="<?php echo $vetor->id_projeto;?>"> <!-- Id do proheto é passado pelo método post -->
									<input type="submit" class="btn btn-secondary btn-home" name="botao" value="Saiba mais">
								</form>
							</div>
						</div>
					</div>
				</div>
				<br>
		<?php
				$cont++;
				}
			}
			if (!$cont) { // Não tem nenhuma tupla para aquela busca
			?>
				<h4 class="h4-home"><center>Nenhum resultado encontrado</center></h4>
			<?php				
			}
		}
		else { // Não encontrou nenhuma busca, ou seja, entrou na url busca sem vir de outra página por href
		?>
			<h4 class="h4-home"><center>Nenhum resultado encontrado</center></h4>
		<?php
			}
		?>
	</div>

	<br><br>

	<!-- Footer -->
	<?php include './includes/footer.php'?>

</body>
</html>

<!-- Import do js para limitar os caracteres da descrição -->
<script type="text/javascript" src="./js/truncated-proj.js"></script>