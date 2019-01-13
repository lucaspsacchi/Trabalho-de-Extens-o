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
        
        <!-- <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
		<link rel="stylesheet" href="../js/bootstrap.min.js">
		<link rel="stylesheet" href="../js/bootstrap.bundle.min.js"> -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

		<link rel="stylesheet" href="../css/navbarfooter.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<link rel="stylesheet" href="../css/cadStyle.css">
		<!-- <link rel="stylesheet" href="../css/homeCadStyle.css"> -->

		<!-- Sweet Alert 2 -->
		<script src="../sweetalert2-master/dist/sweetalert2.min.js"></script>
		<link rel="stylesheet" href="../sweetalert2-master/dist/sweetalert2.min.css">

    </head>
    <body>

		<!-- Navbar -->
		<?php include '../includes/nav-cad.php'?>

				<div class="container">			
					<center>
						<!-- <div class="btn-group">
							<button type="button" class="btn btn-secondary dropdown-toggle btn-novo" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								NOVO
							</button>
							<div class="dropdown-menu dropdown-menu-right">
								<button class="dropdown-item" type="button">Projeto</button>
								<button class="dropdown-item" type="button">Professor</button>
							</div>
						</div> -->

						<div class="btn-group dropright">
							<button type="button" class="btn btn-secondary dropdown-toggle btn-novo" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								NOVO
							</button>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="cadastro_projeto.php">Projeto</a>
    							<a class="dropdown-item" href="cadastro_professor.php">Professor</a>
							</div>
						</div>						
					</center>

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
        
		<!-- Footer -->
		<?php include '../includes/footer-cad.php'?>

    </body>
</html>

<!-- Sweet Alert 2 -->

<!-- Cadastro de professor -->
<?php
if (isset($_SESSION['msg_conf'])) {
?>
<script>
$(document).ready(function() {
	Swal({
		type: 'success',
		title: '<?php echo $_SESSION['msg_conf'];?>',
		html: 'Usuário: <?php echo $_SESSION['usu_conf'];?><br>Senha: <?php echo $_SESSION['sen_conf'];?>',
		allowOutsideClick: false,
		showConfirmButton: true,
		confirmButtonText: 'OK',
	})
})
</script>

<?php
unset($_SESSION['msg_conf']);
unset($_SESSION['usu_conf']);
unset($_SESSION['sen_conf']);
}
?>

<!-- Cadastro de projeto -->
<?php
if (isset($_SESSION['msg_proj'])) {
?>
<script>
$(document).ready(function() {
	Swal({
		type: 'success',
		title: '<?php echo $_SESSION['msg_proj'];?>',
	})
})
</script>

<?php
unset($_SESSION['msg_proj']);
}
?>