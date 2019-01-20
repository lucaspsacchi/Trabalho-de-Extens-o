<?php
include('../connection/connection.php');

ini_set('session.gc_maxlifetime', 3600);
session_set_cookie_params(3600);
//Cria a sessão e verifica se o usuário está logado
session_start();
if (!isset($_SESSION['logado']) && !isset($_SESSION['idSave'])) {
    header("Location: ../cadastro/login.php?erro_login=1");
}
// Verifica se tem alguma mensagem na sessão
if (isset($_SESSION['error'])) {
    alert($_SESSION['error']);
    unset($_SESSION['error']);
}

if (isset($_POST['salvar_dados'])) {

    if (!isset($_POST['sexo'])) {
        $_SESSION['error'] = "Campo 'Gênero' deve ser preenchido";
        header('Location: ./cadastro_projeto.php');
    }

    // Separa o nome completo pelos espaços
    $split = explode(" ", $_POST['nome']);

    // Criando o usuário
    $usuario = 'inter' . strtolower($split[0]);

    // Criando a senha
    $senha = 'bccs' . strtolower($split[0]) . '18';

    // Insert para o novo professor
    $script = "INSERT INTO professor (nome, usuario, senha, foto, sexo, enable) value ('".$_POST['nome']."', '".$usuario."', '".MD5($senha)."', 'perfil.png', '".$_POST['sexo']."', 1)";

    $result = $conn->query($script);

    $_SESSION['msg_conf'] = 'Professor cadastrado com sucesso!';
    $_SESSION['usu_conf'] = $usuario;
    $_SESSION['sen_conf'] = $senha;
    header('Location: ./home.php');
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
    </head>
    <body>

		<!-- Navbar -->
		<?php include '../includes/nav-cad.php'?>

				<div class="container">			
                    <!-- Breadcrumb -->
                    <label><a href="./home.php">Home</a> > Cadastrar Professor</label>
                    <hr><br>
                    
                    <form name="form" class="form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="text-center">
                            <h2>Cadastrar professor</h2>
                        </div>
                        <br>
                        <h6><span class="ast">* Campos obrigatórios</span></h6>
                        <hr>

                        <div class="col-12 col-md-12">
                            <div class="row">
                                <div class="col-9 col-md-9">
                                    <div class="form-group">
                                        <label for="usr">NOME COMPLETO<span class="ast">*</span></label>
                                        <input type="text" class="form-control" id="nome" name="nome" maxlength="150" required placeholder="Insira o nome completo">
                                    </div>
                                </div>
                                <div class="col-3 col-md-3 vertical-line">
                                    <div class="form-group">
                                        <label>GÊNERO<span class="ast">*</span></label><br>
                                        <input type="radio" id="masc" name="sexo" value="0" checked>
                                        <label> Masculino</label><br>
                                        <input type="radio" id="femi" name="sexo" value="1">
                                        <label> Feminino</label><br>							
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
						<div class="d-flex flex-row justify-content-end col-12">
							<div class="row">
								<a class="btn btn-secondary" href="./home.php" name="cancelar_dados">Cancelar</a>
								<div class="" style="border-left: 1px solid #5A6268; margin-left: 15px; margin-right: 15px;"></div>
								<button class="btn btn-success" name="salvar_dados">Salvar</button>
							</div>
						</div>
					</form> 
				</div>
        
		<!-- Footer -->
		<?php include '../includes/footer-cad.php'?>

    </body>
</html>