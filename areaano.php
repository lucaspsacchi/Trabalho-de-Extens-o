<?php
  include('./connection/connection.php');

	// Busca pelo nome da área
	$script = "SELECT nome FROM area WHERE id_area = ".$_GET['id_area'];

	$nome = $conn->query($script);
	$var = $nome->fetch_object();

	//Realiza uma busca no banco de dados para listar as áreas
    $scriptSQL = "SELECT data_inicio, sem_ini, count(*) as num
    FROM projeto NATURAL JOIN area_proj 
    WHERE id_area = '".$_GET['id_area']."'
    GROUP BY sem_ini, data_inicio";

	$result = $conn->query($scriptSQL);
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
		$page = 3;
		include './includes/topnav.php'
	?>

	<div class="container">

		<!-- Breadcrumb -->
		<label><a href="./home.php">Home</a> > <?php echo $var->nome; ?></label>
		<hr><br>

		<div class="row text-center">
			<?php
				$count = 1;
				while($vetor=$result->fetch_object()) { // Exibe todos os valores dos projetos para cada tupla retornada do bd
			?>
					<div class="col-lg-3 col-md-4 col-sm-6">
						<div class="card">
							<div class="card-body">
								<h1 class="h1-ano"><strong><?php echo $vetor->data_inicio . '/' . ($vetor->sem_ini + 1);?></strong></h1>
								<p><?php echo $vetor->num;?> projetos encontrados</p>
								<form method="GET" action="./busca.php"> <!-- Redireciona para a página busca com o id da área escolhida -->
									<input type="hidden" name="id_area" value="<?php echo $_GET['id_area'];?>">
                                    <input type="hidden" name="ano" value="<?php echo $vetor->data_inicio;?>">
                                    <input type="hidden" name="sem" value="<?php echo $vetor->sem_ini;?>">
									<button class="btn btn-secondary">Ver projetos</button>
								</form>
							</div>
						</div>
					</div>
			<?php
				if ($count % 4 == 0) {
					echo '</div><br><div class="row text-center">';
				}
				$count++;
				}
			?>
		</div>
	</div>

	<br><br>

	<!-- Footer -->
	<?php include './includes/footer.php'?>

</body>
</html>