<?php
  include('./connection/connection.php');

	//Realiza uma busca no banco de dados para listar os anos em ordem decrescente e a quantidade de projetos do mesmo ano
	$scriptSQL = "SELECT data_inicio, count(data_inicio) as num
				FROM projeto
				WHERE enable = 1
				GROUP BY data_inicio
				ORDER BY data_inicio DESC";

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
		$page = 4;
		include './includes/topnav.php'
	?>

	<div class="container">

		<!-- Breadcrumb -->
		<!-- <label><a href="./home.php">Home</a> > Ano de início</label> -->
		<?php
		$_SESSION['bread'] = '<a href="./ano.php">Ano</a>';
		?>		
		<!-- <hr><br> -->

		<div class="row text-center">
			<?php
				$count = 1;
				while($vetor=$result->fetch_object()) { // Exibe todos os valores dos projetos para cada tupla retornada do bd
			?>
					<div class="col-lg-3 col-md-4 col-sm-6">
						<div class="card">
							<div class="card-body">
								<h1 class="h1-ano"><strong><?php echo $vetor->data_inicio?></strong></h1>
								<p><?php echo $vetor->num;?> projetos encontrados</p>
								<form method="GET" action="./busca.php">
									<input type="hidden" name="ano" value="<?php echo $vetor->data_inicio;?>">
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

	<br><br><br>

	<!-- Footer -->
	<?php include './includes/footer.php'?>

</body>
</html>
