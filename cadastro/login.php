<?php
$erro_login = 0;
if (isset($_POST['inputUser'])) {

    include('../connection/connection.php');

    $user = addslashes($_POST['inputUser']);
    $senha = addslashes($_POST['inputPassword']);

    $string_query = "SELECT *
                    FROM professor 
                    WHERE usuario='".$user."' and senha=MD5('".$senha."')
                    LIMIT 1;";


    if ($result = $conn->query($string_query)) {
        if ($result->num_rows > 0) {

            $obj = $result->fetch_object();

            ini_set('session.gc_maxlifetime', 3600);
            session_set_cookie_params(3600);

            session_start();
            $_SESSION['logado'] = 1;
            $_SESSION['idSave'] = $obj->id_professor;
						
            $result->close();

            header("Location: ./home.php");
        } else {
            $erro_login = 1;
        }
    } else {
        die("Error: %s\n" . $mysqli->error);
    }

    $conn->close();
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
        <link rel="stylesheet" type="text/css" href="../css/loginStyle.css">
        <link rel="stylesheet" href="../js/bootstrap.min.js">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    </head>
    <body>

			<!-- <nav class="navbar navbar-expand-sm my-nav">
					<a class="navbar-brand">
							<img src="../Imagens/Inter%20BCCS%20Logo%20Fundo%20Branco.png" width="5%" height="5%" alt="logo">
					</a>
					<h4>INTERBCCS</h4>
			</nav> -->


        <!-- "Margin top" -->
        <br><br>

        <div class="container">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 custom-box">
                <form class="custom-form" action="login.php" method="POST">
                    <div class="text-center"> <!-- Imagem e título centralizado -->
                        <a href="#"><img src="../Imagens/Inter%20BCCS%20Logo%20Fundo%20Branco.png" width="5%" height="5%" alt="logo"></a> <!-- Logo -->
                        <br><br>
                        <h1 class="h3 mb-3">Acesse sua conta INTERBCCS</h1>
                            <?php
                            // Mensagem de erro caso o usuário informe usuário ou senha incorreto
                            if ($erro_login == 1) {
                                echo '<div class="form-group row justify-content-center"><div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><div class="alert alert-danger">
                                    <strong>Usuário e/ou senha incorretos</strong><br>
                                    Digite novamente os seus dados.</div></div></div>';
                            }
                            ?>
                    </div>
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
                                                <input type="text" class="form-control" id="inputUser" name="inputUser" pattern=".{4,20}" required autofocus>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Group para senha -->
                                    <div class="form-group">
                                        <div class="row d-flex justify-content-between"> <!-- Between está posicionando senha e esqueceu nas extremidades -->
                                            <div class="">
                                                <label for="loginPassword" class="">Senha</label>
                                            </div>
                                            <div class="">
                                                <label for="esqueceu" class=""><a href="./esqueceu.php">Esqueceu sua senha?</a></label>
                                            </div>
                                        </div>
                                        <div class="row d-flex">
                                            <div class="custom-input">
                                                <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="4 a 20 caracteres" pattern=".{4,20}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Group para botão entrar -->
                                    <div class="form-group">
                                        <div class="row d-flex">
                                            <div class="btn-custom">
                                                <button type="submit" class="btn btn-success btn-block">Entrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <br><br>

		<!-- Footer -->
		<?php include '../includes/footer-cad.php'?>

    </body>
</html>

<script>
    // Trigger para alterar o tab de "Esqueceu a sua senha?" para Senha
    //Campo nome
    var x = document.getElementById('inputUser');

    x.addEventListener("keydown",
    function(e) {
        //Verifica se o evento foi um enter
        if (e.keyCode == 9) {
            e.preventDefault();
            document.getElementById('inputPassword').focus();
        }
    }
    );    
</script>