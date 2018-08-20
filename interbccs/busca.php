<?php
  include('../connection/connection.php');

	$flag = true;
	$act = 0;
	//Home
	if ($_POST['todos_proj'] == 1) {
		$scriptSQL = "SELECT id_projeto, nome, descricao, foto
									FROM projeto
									ORDER BY id_projeto DESC";

		$result = $conn->query($scriptSQL);
		$act = 1;
	}
	//Professor
	else if ($_POST['id_prof'] != NULL) {
		$scriptSQL = "SELECT id_projeto, nome, descricao, foto
									FROM projeto NATURAL JOIN proj_prof
									WHERE proj_prof.id_professor =".$_POST['id_prof']."
									ORDER BY id_projeto DESC";

		$result = $conn->query($scriptSQL);
		$act = 2;
	}
	//Área
	else if ($_POST['id_area'] != NULL) {
		$scriptSQL = "SELECT id_projeto, nome, descricao, foto
									FROM projeto NATURAL JOIN area_proj
									WHERE area_proj.id_area =".$_POST['id_area']."
									ORDER BY id_projeto DESC";

		$result = $conn->query($scriptSQL);
		$act = 3;
	}
	//Ano
	else if ($_POST['ano'] != NULL) {
		$scriptSQL = "SELECT id_projeto, nome, descricao, foto
									FROM projeto
									WHERE data_inicio =".$_POST['ano']."
									ORDER BY id_projeto DESC";

		$result = $conn->query($scriptSQL);
		$act = 4;
	}
	//Busca
	else if ($_POST['search'] != NULL) {
		$string = "'%".$_POST['search']."%'";

		$scriptSQL = "SELECT projeto.id_projeto, projeto.nome, projeto.descricao, projeto.foto
									FROM area, area_proj, projeto, proj_prof, professor
									WHERE area.id_area = area_proj.id_area AND projeto.id_projeto = area_proj.id_projeto AND projeto.id_projeto = proj_prof.id_projeto AND professor.id_professor = proj_prof.id_professor AND area.nome LIKE ".$string." OR projeto.nome LIKE ".$string." OR professor.nome LIKE ".$string." OR projeto.data_inicio LIKE ".$string."
									GROUP BY(projeto.id_projeto)";

		$result = $conn->query($scriptSQL);
		$act = 5;
	}
	else {
		$flag = false;
	}

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
		<a class="nav-link <?php if ($act == 1) echo 'active';?>" href="./interbccs.php">Home</a>
		<a class="nav-link <?php if ($act == 2) echo 'active';?>" href="./professor.php" >Professor</a>
		<a class="nav-link <?php if ($act == 3) echo 'active';?>" href="./area.php">Área</a>
		<a class="nav-link <?php if ($act == 4) echo 'active';?>" href="./ano.php">Ano</a>


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
		if ($flag == true) {
			$cont = 0;
			while($vetor=$result->fetch_object()) {
		?>
				<div class="card">
					<div class="row">
						<div class="col-xl-4 col-lg-5">
							<div class="container-img">
								<img class="card-img" src="../Imagens/<?php echo $vetor->foto;?>">
							</div>
						</div>
						<div class="col-xl-8 col-lg-7">
							<div class="card-block">
								<h4 class="card-text"><strong><?php echo $vetor->nome;?></strong></h4>
								<p class="card-text"><?php echo $vetor->descricao;?></p>
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
				$cont++;
			}
			if (!$cont) {
			?>
				<h4><center>Nenhum projeto encontrado</center></h4>
			<?php				
			}
		}
		else {
		?>
			<h4><center>Nenhum projeto encontrado</center></h4>
		<?php
			}
		?>
	</div>

	<br><br>
	<footer class="mojFooter">
		<div class="footertexto py-3">
			<a class="footer-link" href="http://www.sorocaba.ufscar.br/ufscar/">Universidade Federal de São Carlos - Campus Sorocaba</a>
			<br>
			<a class="footer-link" href="https://dcomp.sor.ufscar.br">Departamento de Ciência da Computação</a>
			<a href="interbccs.html">
				<img src="../Imagens/Inter%20BCCS%20Logo%20Fundo%20Branco.png" class="float-right" alt="logo" width="8%"/>
			</a>
			<br><br>
			
			<p>Rodovia João Leme dos Santos (SP-264), Km 110<br>Bairro do Itinga - Sorocaba - São Paulo - Brasil<br>CEP 18052-780</p>
			<div class="foot" align="center">© 2018 InterBCCS. All rights reserved.</div>
		</div>
	</footer>

</body>

</html>
