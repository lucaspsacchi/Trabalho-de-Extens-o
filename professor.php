<?php
  include('./connection/connection.php');

	//Realiza uma busca no banco de dados para listar os professores
	$scriptSQL = "SELECT DISTINCT id_professor, nome, descricao, foto
					FROM professor NATURAL JOIN proj_prof
					WHERE enable = 1
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
		$page = 2;
		include './includes/topnav.php'
	?>

	<div class="container">

		<!-- Breadcrumb -->
		<!-- <label>Professores</label> -->
		<?php
		$_SESSION['bread'] = '<a href="./professor.php">Professores</a>'; // Esse caso é impossível
		?>		
		<!-- <hr><br> -->

		<!-- Professores -->
		<?php
			while($vetor=$result->fetch_object()) {
		?>
				<div class="card">
					<div class="row">
						<div class="col-xl-3 col-lg-4 col-md-4">
							<div class="container-img-prof">
								<img class="card-img" id="img-resp-prof" src="./Imagens/<?php echo $vetor->foto;?>">
							</div>
						</div>
						<div class="col-xl-9 col-lg-8 col-md-8">
							<div class="card-block-prof">
								<h4 class="card-text"><strong><?php echo $vetor->nome;?></strong></h4>
								<p id="over" class="card-text p-prof p-truncated"><?php echo $vetor->descricao;?></p>
								<form class="btn-prof" method="get" action="./busca.php">
									<input type="hidden" name="id_prof" value="<?php echo $vetor->id_professor;?>">
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

<!-- Import do js para limitar os caracteres da descrição -->
<script type="text/javascript" src="./js/truncated-prof.js"></script>