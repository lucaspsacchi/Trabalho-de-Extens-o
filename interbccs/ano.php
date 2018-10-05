<?php
  include('../connection/connection.php');

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
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Lucas Penteado Sacchi">
	<meta name="author" content="Sofia de Almeida Machado da Silveira">
	<meta charset="utf-8">
	<title>InterBCCS</title>
	<link rel="shortcut icon" type="image/png" href="../Imagens/Inter%20BCCS%20Logo%20Fundo%20Branco.png">

	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../js/bootstrap.min.js">
	<link rel="stylesheet" href="../css/navbarfooter.css">
	<link rel="stylesheet" href="../css/anoStyle.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>

	<div id="wrapperHeader">
		<div id="header">
			<a href="interbccs.php">
          <img src="../Imagens/CapaHeader.png" alt="imagem capa" width="100%"/>
        </a>
		</div>
	</div>

	<div class="topnav">
		<a class="nav-link" href="./interbccs.php">Home</a>
		<a class="nav-link" href="./professor.php">Professor</a>
		<a class="nav-link" href="./area.php">Área</a>
		<a class="nav-link active" href="./ano.php">Ano</a>

		
		<div class="search-container">
			<form action="./busca.php" method="POST">
				<input type="hidden" name="busca" value="true">
				<input type="text" placeholder="Buscar" name="search">
				<button type="submit"><i class="fa fa-search"></i></button>
			</form>
		</div>
		
	</div>

	<br><br>

	<div class="container">
		<div class="row text-center">
			<?php
				$count = 1;
				while($vetor=$result->fetch_object()) {
			?>
					<div class="col-lg-3 col-md-4 col-sm-6">
						<div class="card">
							<div class="card-body">
								<h1><strong><?php echo $vetor->data_inicio?></strong></h1>
								<p><?php echo $vetor->num?> projetos encontrados</p>
								<form method="post" action="./busca.php">
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

	<br><br>

	<footer class="mojFooter">
		<div class="footertexto py-3">
			<a class="footer-link" href="http://www.sorocaba.ufscar.br/" target="_blank">Universidade Federal de São Carlos - Campus Sorocaba</a>
			<br>
			<a class="footer-link" href="https://dcomp.sor.ufscar.br" target="_blank">Departamento de Ciência da Computação</a>
			<a href="./interbccs.php">
				<img src="../Imagens/Inter%20BCCS%20Logo%20Fundo%20Branco.png" class="float-right" alt="logo" width="8%"/>
			</a>
			<br><br>

			<p>Rodovia João Leme dos Santos (SP-264), Km 110<br>Bairro do Itinga - Sorocaba - São Paulo - Brasil<br>CEP 18052-780</p>
			<div class="foot" align="center">© 2018 InterBCCS. All rights reserved.</div>
		</div>
	</footer>

</body>

</html>
