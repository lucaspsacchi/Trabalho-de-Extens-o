<?php
include('../connection/connection.php');

ini_set('session.gc_maxlifetime', 3600);
session_set_cookie_params(3600);
//Cria a sessão e verifica se o usuário está logado
session_start();
if (!isset($_SESSION['logado']) && !isset($_SESSION['idSave'])) {
    header("Location: ../cadastro/login.php?erro_login=1");
}


	$id = $_SESSION['idSave'];

	if (isset($_SESSION['mensagem'])) {
		?>
		<script>
			alert("<?php echo $_SESSION['mensagem']; ?>");
		</script>
		<?php
		unset($_SESSION['mensagem']);
	}

	//Realiza uma busca no banco de dados para listar os projetos de um professor em específico
	$scriptSQL = "SELECT projeto.id_projeto, projeto.nome, projeto.enable
								FROM projeto NATURAL JOIN proj_prof
								WHERE id_professor = ".$id."
								ORDER BY projeto.id_projeto DESC";

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
				<link rel="stylesheet" href="../css/cadStyle.css">
				<link rel="stylesheet" href="../css/homeCadStyle.css">
				<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    </head>
    <body>

			<nav class="navbar navbar-expand-md my-nav">
				<div class="d-flex flex-row justify-content-between col-md-12">
					<div class="d-flex col-2">
						<a class="nav-item" href="home.php">
								<img src="../Imagens/Inter%20BCCS%20Logo%20Fundo%20Branco.png" width="50px" height="50px" alt="logo">
						</a>
					</div>

					<div class="d-flex justify-content-center">
						<h4>INTERBCCS</h4>
					</div>

					<div class="d-flex flex-row flex-nowrap col-2 justify-content-end">
						<a class="nav-link" href="./perfil.php">PERFIL</a>
						<a class="nav-link" href="./sair.php">SAIR</a>
					</div>
				</div>
			</nav>
        
				<div class="container">
					<center><a href="cadastro_projeto.php"><button class="btn btn-secondary">ADICIONAR PROJETO</button></a></center>
			
					<br>
					
					<div id="lista_produto" class="list-group">
							<?php
							while ($vetor = $result->fetch_object()) {
								if ($vetor->enable == 1) {
							?>
									<a id="listItem" href="./alterar_cadastro.php?id=<?php echo $vetor->id_projeto;?>" class="list-group-item"><?php echo $vetor->nome; ?></a>
							<?php
								}
							}
							?>
					</div>
				</div>
        

			<footer>
				<div class="footertexto">
           <div class="foot" align="center">© 2018 InterBCCS. All rights reserved.</div>
				</div>
			</footer>

    </body>
</html>