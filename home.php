<?php
  include('./connection/connection.php');

	//Realiza uma busca no banco de dados em ordem decrescente pelo id do projeto
	$scriptSQL = "SELECT id_projeto, foto, nome, descricao
				FROM projeto
				WHERE enable = 1
				ORDER BY id_projeto DESC
				LIMIT 4";

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

	<div class="container">
		<!-- Breadcrumb -->
		<label>Home</label>
		<hr><br>

		<?php
			while(($vetor=$result->fetch_object())) { // Exibe os 4 projetos mais recentes
		?>
				<div class="card">
					<div class="row">
						<!-- Imagem do projeto -->
						<div class="col-xl-4 col-lg-5 col-md-12">
							<div class="container-img-home">
								<img class="card-img" id="img-resp-proj" src="./Imagens/<?php echo $vetor->foto;?>">
							</div>
						</div>
						<div class="col-xl-8 col-lg-7 col-md-12">
							<!-- Título, descrição e botão -->
							<div class="card-block-home">
								<h4 class="card-text h4-home"><strong><?php echo $vetor->nome;?></strong></h4>
								<p class="card-text p-home p-truncated"><?php echo $vetor->descricao;?></p>
								<!--<button class="btn btn-secondary">Saiba mais</button>-->
								<form method="GET" action="./projeto.php?id_proj">
									<input type="hidden" name="id_proj" value="<?php echo $vetor->id_projeto;?>">
									<button type="submit" class="btn btn-secondary btn-home">Saiba mais</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				<br>
		<?php
			}
		?>
		
		<br>
		<div class="d-flex flex-row justify-content-center col-md-12">
			<form name="form" action="./busca.php" method="GET">
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

<!-- Import do js para limitar os caracteres da descrição -->
<script type="text/javascript" src="./js/truncated-proj.js"></script>