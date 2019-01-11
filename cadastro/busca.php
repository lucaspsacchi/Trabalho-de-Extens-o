<?php
include('../connection/connection.php');

ini_set('session.gc_maxlifetime', 3600);
session_set_cookie_params(3600);
//Cria a sessão e verifica se o usuário está logado
session_start();
if (!isset($_SESSION['logado']) && !isset($_SESSION['idSave'])) {
    header("Location: ../cadastro/login.php?erro_login=1");
}

$script = "SELECT * FROM projeto WHERE nome LIKE '%".$_GET['nome']."%' or alunos LIKE '%".$_GET['nome']."%' or data_inicio LIKE '%".$_GET['nome']."%' or descricao LIKE '%".$_GET['nome']."%'";

$result = $conn->query($script);
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
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<link rel="stylesheet" href="../css/cadStyle.css">
		<!-- <link rel="stylesheet" href="../css/homeCadStyle.css"> -->
    </head>
    <body>

		<!-- Navbar -->
		<?php include '../includes/nav-cad.php'?>
        
				<div class="container">
                
				<!-- Breadcrumb -->
				<label><a href="./home.php">Home</a> > Resultados da Busca</label>
                <hr><br>
                
					<div id="lista_produto" class="list-group">
							<?php
							if ($result->num_rows == 0) {
								echo "Não foram encontrados resultados para '".$_GET['nome']."'"; 
							}
							else {
								while ($vetor = $result->fetch_object()) {
									if ($vetor->enable == 1) {
								?>
										<a id="listItem" href="./alterar_cadastro.php?id=<?php echo $vetor->id_projeto;?>" class="list-group-item"><?php echo $vetor->nome; ?></a>
								<?php
									}
								}
							}
							?>
					</div>
				</div>
        
		<!-- Footer -->
		<?php include '../includes/footer-cad.php'?>

    </body>
</html>