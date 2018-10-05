<?php
include('../connection/connection.php');

ini_set('session.gc_maxlifetime', 3600);
session_set_cookie_params(3600);
//Cria a sessão e verifica se o usuário está logado
session_start();
if (!isset($_SESSION['logado']) && !isset($_SESSION['idSave'])) {
    header("Location: ../cadastro/login.php?erro_login=1");
}
?>
<?php
	$id = $_SESSION['idSave'];

	//Realiza uma busca no banco de dados passando o id do professor
	$scriptSQL = "SELECT *
	FROM professor
	WHERE id_professor =".$id.";";

	$result = $conn->query($scriptSQL);
	$vetor = $result->fetch_object();

	if (isset($_POST['salvar_dados'])) {
		
		if (isset($_FILES["file"]["type"])) {
			$validextensions = array("jpeg", "jpg", "png");
			$temporary = explode(".", $_FILES["file"]["name"]);
			$file_extension = end($temporary);

			if (in_array($file_extension, $validextensions)) {//Verifica se está de acordo com a extensão
				if ($_FILES["file"]["error"] > 0) {

				} else {

					$novoNome = uniqid(time()) . '.' . $file_extension;
					$destino = '../Imagens/' . $novoNome;
					$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable

					move_uploaded_file($sourcePath, $destino); // Moving Uploaded file
				}
			}
    }

    if (isset($_POST['photo_change']) && $_POST['photo_change'] != "") {
        if (isset($vetor->foto) && $vetor->foto != "") {
            $file = "../Imagens/" . $vetor->foto;
            if (file_exists($file)) {
               unlink($file);
            }
        }
    }
		
		if (!isset($novoNome) || $novoNome == "") {
        $novoNome = $vetor->foto;
    }
		
		//Alteração de senha
		$flagPass = 0;
		if (isset($_POST['password']) && $_POST['password'] != "" && $_POST['password'] != " ") {
			$senha = MD5($_POST['password']);

			//Verifica se a senha foi alterada
			if (strcmp($senha, $_POST['passOld']) != 0) {
				$flagPass = 1;
			}
		}
		$flagSite = 0;
		//Alteração do site
		if (isset($_POST['site'])) {
			$flagSite = 1;
		}
		if ($flagPass) {
			if ($flagSite) {
				$scriptSQL = "UPDATE `interbccs`.`professor`
				SET `nome` ='".$_POST['nome']."', `usuario` ='".$_POST['usuario']."', `descricao` ='".$_POST['descricao']."', `senha` ='".$senha."', `site` = '".$_POST['site']."', `foto` = '".$novoNome."'
				WHERE id_professor =".$id.";";				
			}
			else {
				$scriptSQL = "UPDATE `interbccs`.`professor`
				SET `nome` ='".$_POST['nome']."', `usuario` ='".$_POST['usuario']."', `descricao` ='".$_POST['descricao']."', `senha` ='".$senha."', `foto` = '".$novoNome."'
				WHERE id_professor =".$id.";";
			}
		}
		else {
			if ($flagSite) {
				$scriptSQL = "UPDATE `interbccs`.`professor`
				SET `nome` ='".$_POST['nome']."', `usuario` ='".$_POST['usuario']."', `descricao` ='".$_POST['descricao']."', `site` = '".$_POST['site']."', `foto` = '".$novoNome."'
				WHERE id_professor =".$id.";";			
			}
			else {
				$scriptSQL = "UPDATE `interbccs`.`professor`
				SET `nome` ='".$_POST['nome']."', `usuario` ='".$_POST['usuario']."', `descricao` ='".$_POST['descricao']."', `foto` = '".$novoNome."'
				WHERE id_professor =".$id.";";
			}	
		}
		
		if (mysqli_query($conn, $scriptSQL) == TRUE) {
			//Recarrega a página com os novos dados
			$scriptSQL = "SELECT *
			FROM professor
			WHERE id_professor =".$id.";";

			$result = $conn->query($scriptSQL);
			$vetor = $result->fetch_object();
			
			$_SESSION['mensagem'] = "Perfil atualizado com sucesso!";
			header('Location: ./home.php');
		}
		else {
			?>
			<script>
				alert("Ocorreu um erro inesperado");
			</script>
			<?php
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
			<link rel="stylesheet" href="../js/bootstrap.min.js">
			<link rel="stylesheet" href="../css/navbarfooter.css">
			<link rel="stylesheet" href="../css/cadStyle.css">
			<link rel="stylesheet" href="../css/perfilStyle.css">
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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

			<br><br>
			<div class="container">

				<form name="form" class="form-horizontal" action="#" method="post" enctype="multipart/form-data">
					<div class="text-center">
						<h2>Editar perfil</h2>
						<p>Altere os campos abaixo para atualizar os dados do perfil</p>
					</div>
					<div class="row">
						<div class="col-7">
							<div class="form-group">
								<label for="usr">USUÁRIO<span class="ast">*</span></label>
								<input type="text" class="form-control" id="usuario" name="usuario" maxlength="20" value="<?php echo $vetor->usuario; ?>" required placeholder="Alterar nome do usuário">
							</div>
						</div>
						<div class="col-5 vertical-line">
							<div class="form-group">
								<label for="usr">SENHA<span class="ast">*</span></label>
								<input type="password" class="form-control" id="password" name="password" pattern=".{4,20}" value="password" placeholder="Digite uma nova senha">
								<input type="hidden" name="passOld" value="<?php echo $vetor->senha; ?>">
							</div>
						</div>						
					</div>
					<hr>					
					<div class="row">
						<div class="col-7">
							<div class="form-group">
								<label for="usr">NOME<span class="ast">*</span></label>
								<input type="text" class="form-control" id="nome" name="nome" maxlength="50" value="<?php echo $vetor->nome; ?>" required placeholder="Insira o nome completo">
							</div>
						</div>
						<div class="col-5 vertical-line">
							<div class="form-group">
								<label for="usr">SITE PESSOAL</label>
								<input type="text" class="form-control" id="site" name="site" maxlength="150" value="<?php echo $vetor->site; ?>" placeholder="Insira a url (opcional)">
							</div>
						</div>						
					</div>
					<hr>
					<div class="row">
						<div class="col-7">
							<div class="form-group">
								<label for="comment">SOBRE<span class="ast">*</span></label>
								<textarea type="text" name="descricao" class="form-control" rows="5" required maxlength="400" id="description" placeholder="Escreva um pouco sobre você e sua formação"><?php echo $vetor->descricao; ?></textarea>
							</div>
						</div>
						<div class="col-5 vertical-line">
	
								<div class="form-group">
									<img id="photo" src="../Imagens/<?php echo $vetor->foto;?>" class="img-rounded" width="200" height="210">
									<br>
									<label for="comment">ALTERAR FOTO DE PERFIL<span class="ast">*</span> </label>
									<input type="file" name="file" id="file" value="0">
									<div class="form-group">
											<input type="hidden" id="photo_change" name="photo_change">
									</div>
								</div>
						</div>	
					</div>
					<h6><span class="ast">* Campos obrigatórios</span></h6>
					<hr>
					<div class="d-flex flex-row justify-content-end col-12">
							<button class="btn btn-secondary" name="salvar_dados">Salvar</button>
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

    <script>
        $(document).ready(function (e) {
            // Function to preview image after validation
            $(function () {
                $("#file").change(function () {
                    var file = this.files[0];
                    var imagefile = file.type;
                    var match = ["image/jpeg", "image/png", "image/jpg"];
                    if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2])))
                    {
                        $('#photo').attr('src', 'noimage.png');
                        $("#message").html("<p id='error'>Please Select A valid Image File</p>" + "<h4>Note</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
                        return false;
                    }
                    else
                    {
                        var reader = new FileReader();
                        reader.onload = imageIsLoaded;
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            });
            function imageIsLoaded(e) {
							$('#photo').attr('src', e.target.result);
							$('#photo').attr('width', '200px');
							$('#photo').attr('height', '210px');
							$('#photo_change').attr('value', 'true');
            }

        });
    </script>	

		<!-- Trigger para validar as entradas do teclado -->
		<script>
			//Campo nome
			var a = document.getElementById('usuario');
			var b = document.getElementById('password');
			var c = document.getElementById('nome');
			var d = document.getElementById('site');
			
			a.addEventListener("keydown",
			function(e) {
				//Verifica se o evento foi um enter
				if (e.keyCode == 13) {
					e.preventDefault();
					document.getElementById('password').focus();
				}
			}
			);
			
			b.addEventListener("keydown",
			function(e) {
				//Verifica se o evento foi um enter
				if (e.keyCode == 13) {
					e.preventDefault();
					document.getElementById('nome').focus();
				}
			}
			);

			c.addEventListener("keydown",
			function(e) {
				//Verifica se o evento foi um enter
				if (e.keyCode == 13) {
					e.preventDefault();
					document.getElementById('site').focus();
				}
			}
			);

			d.addEventListener("keydown",
			function(e) {
				//Verifica se o evento foi um enter
				if (e.keyCode == 13) {
					e.preventDefault();
					document.getElementById('description').focus();
				}
			}
			);						
		</script>
</html>
