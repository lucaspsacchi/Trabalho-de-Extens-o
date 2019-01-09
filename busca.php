<?php
  include('./connection/connection.php');

	$flag = true;
	$act = 0;
	//Home
	if ($_POST['todos_proj'] == 1) {
		$scriptSQL = "SELECT id_projeto, nome, descricao, foto, enable
									FROM projeto
									ORDER BY id_projeto DESC";

		$result = $conn->query($scriptSQL);
	}
	//Professor
	else if ($_POST['id_prof'] != NULL) {
		$scriptSQL = "SELECT id_projeto, nome, descricao, foto, enable
									FROM projeto NATURAL JOIN proj_prof
									WHERE proj_prof.id_professor =".$_POST['id_prof']."
									ORDER BY id_projeto DESC";

		$result = $conn->query($scriptSQL);
	}
	//Área
	else if ($_POST['id_area'] != NULL) {
		$scriptSQL = "SELECT id_projeto, nome, descricao, foto, enable
									FROM projeto NATURAL JOIN area_proj
									WHERE area_proj.id_area =".$_POST['id_area']."
									ORDER BY id_projeto DESC";

		$result = $conn->query($scriptSQL);
	}
	//Ano
	else if ($_POST['ano'] != NULL) {
		$scriptSQL = "SELECT id_projeto, nome, descricao, foto, enable
									FROM projeto
									WHERE data_inicio =".$_POST['ano']."
									ORDER BY id_projeto DESC";

		$result = $conn->query($scriptSQL);
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
		$page = 0; // Default
		include './includes/topnav.php'
	?>

	<br>
	<br>

	<div class="container">

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
								<p class="card-text p-home"><?php echo $vetor->descricao;?></p>
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
