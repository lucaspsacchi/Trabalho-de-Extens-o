<?php
  include('../connection/connection.php');

	//Realiza uma busca no banco de dados em ordem decrescente pelo id do projeto
	$scriptSQL = "SELECT id_projeto, foto, nome, descricao
								FROM projeto
								WHERE enable = 1
								ORDER BY id_projeto DESC";

	$result = $conn->query($scriptSQL);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<meta name="author" content="Lucas Penteado Sacchi">
	<meta name="author" content="Sofia de Almeida Machado da Silveira">
	<title>InterBCCS</title>
	<link rel="shortcut icon" type="image/png" href="../Imagens/Inter%20BCCS%20Logo%20Fundo%20Branco.png">

	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../js/bootstrap.min.js">
	<link rel="stylesheet" href="../css/navbarfooter.css">
	<link rel="stylesheet" href="../css/homeStyle.css">
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
		<a class="nav-link active" href="./interbccs.php">Home</a>
		<a class="nav-link" href="./professor.php">Professor</a>
		<a class="nav-link" href="./area.php">Área</a>
		<a class="nav-link" href="./ano.php">Ano</a>

		
		<div class="search-container">
			<form action="./busca.php" method="POST">
				<input type="hidden" name="busca" value="true">
				<input type="text" placeholder="Buscar" name="search">
				<button type="submit"><i class="fa fa-search"></i></button>
			</form>
		</div>
		
	</div>

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
							<div class="container-img">
								<img class="card-img" src="../Imagens/<?php echo $vetor->foto;?>">
							</div>
						</div>
						<div class="col-xl-8 col-lg-7 col-md-12">
							<div class="card-block">
								<h4 class="card-text"><strong><?php echo $vetor->nome;?></strong></h4>
								<p class="card-text"><?php echo $vetor->descricao;?></p>
								<!--<button class="btn btn-secondary">Saiba mais</button>-->
								<form method="POST" action="./projeto.php">
									<input type="hidden" name="id_proj" value="<?php echo $vetor->id_projeto;?>">
									<input type="submit" class="btn btn-secondary" name="botao" value="Saiba mais">
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
				<button class="btn btn-secondary">Ver todos projetos</button>
			</form>
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