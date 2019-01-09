<?php
  include('./connection/connection.php');

	//Realiza uma busca no banco de dados em ordem decrescente pelo id do projeto
	$scriptSQL = "SELECT id_projeto, foto, nome, descricao
								FROM projeto
								WHERE enable = 1
								ORDER BY id_projeto DESC";

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
		$page = 1;
		include './includes/topnav.php'
	?>

	<br>
	<br>

	<div class="container">
		<?php
			$count = 0;
			while(($vetor=$result->fetch_object()) && $count != 4) {
		?>
				<div class="card">
					<div class="row">
						<div class="col-xl-4 col-lg-5 col-md-12">
							<div class="container-img-home">
								<img class="card-img" src="./Imagens/<?php echo $vetor->foto;?>">
							</div>
						</div>
						<div class="col-xl-8 col-lg-7 col-md-12">
							<div class="card-block-home">
								<h4 class="card-text h4-home"><strong><?php echo $vetor->nome;?></strong></h4>
								<p class="card-text p-home"><?php echo $vetor->descricao;?></p>
								<!--<button class="btn btn-secondary">Saiba mais</button>-->
								<form method="POST" action="./projeto.php">
									<input type="hidden" name="id_proj" value="<?php echo $vetor->id_projeto;?>">
									<input type="submit" class="btn btn-secondary btn-home" name="botao" value="Saiba mais">
								</form>
							</div>
						</div>
					</div>
				</div>
				<br>
		<?php
				$count++;
			}
		?>
		
		<br>
		<div class="d-flex flex-row justify-content-center col-md-12">
			<form name="form" action="./busca.php" method="post">
				<input type="hidden" id="todos_projetos" name="todos_proj" value="1">
				<button class="btn btn-secondary btn-home">Ver todos projetos</button>
			</form>
		</div>
	</div>

	<br><br>

	<!-- Footer -->
	<?php include './includes/footer.php'?>

</body>
</html>