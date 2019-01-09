<?php
$erro_login = 0;
if (isset($_POST['inputUser'])) {

    include('../connection/connection.php');

    // Procura o usuário no bd
    $script = "SELECT *
                FROM professor
                WHERE usuario = '".$_POST['inputUser']."'";
    $result = $conn->query($script);

    // Se encontrou algum professor com o usuário
    if ($result->num_rows != 0) {
        // Pega o id do professor
        $obj = $result->fetch_object();
        $id = $obj->id_professor;

        // Atualiza a nova senha
        $script = "UPDATE professor
                        SET senha = MD5('".$_POST['inputPass']."')
                        WHERE id_professor = '".$id."'";

        $result = $conn->query($script);
        header('Location: login.php');
    }
    else { // Se não
        $erro_login = 1;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <footer>
    </footer>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <meta name="author" content="Lucas Penteado Sacchi">
        <meta name="author" content="Sofia de Almeida Machado da Silveira">			
        <title>InterBCCS</title>
        <link rel="shortcut icon" type="image/png" href="../Imagens/Inter%20BCCS%20Logo%20Fundo%20Branco.png">
        
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../css/loginStyle.css">
        <link rel="stylesheet" href="../js/bootstrap.min.js">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        
        <!-- Chamada da função js para validar os campos da senha -->
        <script type="text/javascript" src="../js/senha.js"></script>
    </head>
    <body>

        <!-- "Margin top" -->
        <br><br>

        <div class="container">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 custom-box">
                <div class="text-center"> <!-- Imagem e título centralizado -->
                <a href="./login.php"><img src="../Imagens/Inter%20BCCS%20Logo%20Fundo%20Branco.png" width="5%" height="5%" alt="logo"></a> <!-- Logo -->
                    <br><br>
                    <h1 class="h3 mb-3">Redefina sua senha</h1>
                    <?php
                    // Mensagem de erro caso o usuário informe usuário ou senha incorreto
                    if ($erro_login == 1) {
                        echo '<div class="form-group row justify-content-center"><div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><div class="alert alert-danger">
                            <strong>Usuário e/ou senha incorretos</strong><br>
                            Digite novamente os seus dados.</div></div></div>';
                    }
                    ?>
                </div>
                <form id="cadastro" class="custom-form" action="esqueceu.php" method="POST">
                    <div class="d-flex justify-content-center">
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            <div class="card shadow"> <!-- Shadow na borda do card -->
                                <div class="card-body">
                                    <!-- Group para usuário -->
                                    <div class="form-group">
                                        <div class="row d-flex">
                                            <label for="loginUser" class="">Usuário</label>
                                        </div>
                                        <div class="row d-flex">
                                            <div class="custom-input">
                                                <input type="text" class="form-control" name="inputUser" pattern=".{4,20}" required autofocus>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Group para nova senha -->
                                    <div class="form-group">
                                        <div class="row d-flex justify-content-between">
                                            <div class="">
                                                <label for="loginPass" class="">Nova senha</label>
                                            </div>
                                        </div>
                                        <div class="row d-flex">
                                            <div class="custom-input">
                                                <input type="password" class="form-control" id="inputPass" name="inputPass" placeholder="4 a 20 caracteres" pattern=".{4,20}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Group para confirmar a nova senha -->
                                    <div class="form-group">
                                        <div class="row d-flex justify-content-between">
                                            <div class="">
                                                <label for="loginConfPass" class="">Confirme a senha</label>
                                            </div>
                                        </div>
                                        <div class="row d-flex">
                                            <div class="custom-input">
                                                <input type="password" class="form-control" id="inputConfPass" name="inputConfPass" data-toggle="popover" placeholder="4 a 20 caracteres" pattern=".{4,20}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Group para botão -->
                                    <div class="form-group">
                                        <div class="row d-flex">
                                            <div class="btn-custom">
                                                <button type="submit" class="btn btn-secondary btn-block">Entrar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Hr com voltar para home -->
                                    <div class="">
                                        <hr>
                                        <div class="">
                                            <center>
                                                <label>Voltar para <a href="./login.php">login</a></label>
                                            </center>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <br><br><br>

		<!-- Footer -->
		<?php include '../includes/footer-cad.php'?>

    </body>
</html>