<?php
  include('./connection/connection.php');

	//Realiza uma busca no banco de dados para listar os professores
	$scriptSQL = "SELECT id_area, nome, descricao, foto
								FROM area
								ORDER BY nome ASC";

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

	<br>
	<br>

	<div class="container">
		
		<?php
			while($vetor=$result->fetch_object()) {
		?>
				<div class="card">
					<div class="row">
						<div class="col-xl-4 col-lg-5">
							<div class="container-img-area">
								<img class="card-img" src="./Imagens/<?php echo $vetor->foto;?>">
							</div>
						</div>
						<div class="col-xl-8 col-lg-7">
							<div class="card-block-area">
								<p class="card-desc p-area"><?php echo $vetor->descricao;?></p>
								<form class="btn-area" method="post" action="./busca.php">
									<input type="hidden" name="id_area" value="<?php echo $vetor->id_area;?>">
									<button class="btn btn-secondary">Ver projetos</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				<br>
		<?php
			}
		?>
	</div>

	<br><br>

	<!-- Footer -->
	<?php include './includes/footer.php'?>

</body>
</html>
