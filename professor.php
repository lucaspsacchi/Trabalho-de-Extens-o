<?php
  include('./connection/connection.php');

	//Realiza uma busca no banco de dados para listar os professores
	$scriptSQL = "SELECT id_professor, nome, descricao, foto
								FROM professor
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

		<!-- Professores -->
		<?php
			while($vetor=$result->fetch_object()) {
		?>
				<div class="card">
					<div class="row">
						<div class="col-xl-3 col-lg-4">
							<div class="container-img-prof">
								<img class="card-img" src="./Imagens/<?php echo $vetor->foto;?>">
							</div>
						</div>
						<div class="col-xl-9 col-lg-8">
							<div class="card-block-prof">
								<h4 class="card-text"><strong><?php echo $vetor->nome;?></strong></h4>
								<p id="over" class="card-text p-prof"><?php echo $vetor->descricao;?></p>
								<form class="btn-prof" method="post" action="./busca.php">
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

<script>
var x = document.getElementsByTagName("p");

// Retirado do 
function truncateText(element, maxLength) {
	var truncated = element.innerText; // Pega o texto

	if (truncated.length > maxLength) { // Se é maior que o maxLength passado pelo parâmetro
		truncated = truncated.substr(0,maxLength); // Copia apenas a parte menor
		// Procura o último espaço, copia apenas a parte anterior a esse index e concatenando com '...'
		truncated = truncated.substr(0, truncated.lastIndexOf(" ")) + '...';
	}
return truncated;
}

for (i = 0; i < x.length; i++) {
	x[i].innerHTML = truncateText(x[i], 400);
}

</script>