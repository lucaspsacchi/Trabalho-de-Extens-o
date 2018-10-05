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

    </head>
    <body>

			<nav class="navbar navbar-expand-sm my-nav">
					<a class="navbar-brand">
							<img src="../Imagens/Inter%20BCCS%20Logo%20Fundo%20Branco.png" width="5%" height="5%" alt="logo">
					</a>
					<h4>INTERBCCS</h4>
			</nav>



        <br><br><br>
			
        <div class="container">
            <form class="text-center" action="login.php" method="POST">
                <h1 class="h3 mb-3">Login</h1>
								<?php
								if ($erro_login == 1) {
									echo '<div class="form-group row justify-content-center"><div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><div class="alert alert-danger">
										<strong>Usuário e/ou senha incorretos</strong><br>
										Digite novamente os seus dados.</div></div></div>';
								}
								?>
                <div class="form-group row justify-content-center">
                    <label for="loginUser" class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-form-label">Usuário</label>
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                        <input type="text" class="form-control" name="inputUser" pattern=".{4,20}" required autofocus>
                    </div>
                </div>
                <div class="form-group row justify-content-center">
                    <label for="loginPassword" class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-form-label">Senha</label>
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                        <input type="password" class="form-control" name="inputPassword" placeholder="4 a 20 caracteres" pattern=".{4,20}" required>
                    </div>
                </div>
                <div class="form-group row justify-content-end">
                    <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                        <button type="submit" class="btn btn-secondary">Entrar</button>
                    </div>
                </div>
							
            </form>
        </div>


        <br><br>

			<footer>
				<div class="footertexto">
           <div class="foot" align="center">© 2018 InterBCCS. All rights reserved.</div>
				</div>
			</footer>

    </body>
</html>