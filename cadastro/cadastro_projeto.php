<?php
include('../connection/connection.php');

ini_set('session.gc_maxlifetime', 3600);
session_set_cookie_params(3600);
//Cria a sessão e verifica se o usuário está logado
session_start();
if (!isset($_SESSION['logado']) && !isset($_SESSION['idSave'])) {
    header("Location: ../cadastro/login.php?erro_login=1");
}

	//Realiza uma busca no banco de dados para buscar todas as áreas
	$scriptArea = "SELECT id_area, nome
								FROM area";

	$resultArea = $conn->query($scriptArea);

	//Realiza uma busca no banco de dados para buscar todos os professores
	$scriptProf = "SELECT id_professor, nome
								FROM professor";

	$resultProf = $conn->query($scriptProf);

	//Validação dos campos
	//Site
	if (isset($_POST['site'])) {
		$var_site = $_POST['site'];
	}
	else {
		$var_site = NULL;
	}
	//Alunos
	if (isset($_POST['alunos'])) {
		$var_alunos = $_POST['alunos'];
	}
	else {
		$var_alunos = NULL;
	}

	if (isset($_POST['salvar_dados'])) {
		
		if (count($_POST['checkarea'])) {
		
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


			//Inserção dos dados do projeto no banco de dados
			if ($var_site == NULL && $var_alunos == NULL) {
				$insertSQL = "INSERT INTO `interbccs`.`projeto` (`nome`, `foto`, `descricao`, `data_inicio`, `concluido`, `enable`) VALUES ('".$_POST['nome']."', '".$novoNome."', '".$_POST['descricao']."', '".$_POST['data']."', '".$_POST['andamento']."', '1');";
			}
			else if ($var_site == NULL) {
				$insertSQL = "INSERT INTO `interbccs`.`projeto` (`nome`, `foto`, `descricao`, `alunos`, `data_inicio`, `concluido`, `enable`) VALUES ('".$_POST['nome']."', '".$novoNome."', '".$_POST['descricao']."', '".$var_alunos."', '".$_POST['data']."', '".$_POST['andamento']."', '1');";
			}
			else if ($var_alunos == NULL) {
				$insertSQL = "INSERT INTO `interbccs`.`projeto` (`nome`, `foto`, `site_proj`, `descricao`, `data_inicio`, `concluido`, `enable`) VALUES ('".$_POST['nome']."', '".$novoNome."', '".$var_site."', '".$_POST['descricao']."', '".$_POST['data']."', '".$_POST['andamento']."', '1');";			
			}
			else {
				$insertSQL = "INSERT INTO `interbccs`.`projeto` (`nome`, `foto`, `site_proj`, `descricao`, `alunos`, `data_inicio`, 		`concluido`, `enable`) VALUES ('".$_POST['nome']."', '".$novoNome."', '".$var_site."', '".$_POST['descricao']."', '".$var_alunos."', '".$_POST['data']."', '".$_POST['andamento']."', '1');";			
			}
			
			if (mysqli_query($conn, $insertSQL) == TRUE) {
				$index = mysqli_insert_id($conn);
			}
			else {
				?>
				<script>
					alert("Ocorreu um erro inesperado");
				</script>
				<?php
			}

			//Manipulação e inserção das áreas do projeto inserido
			if (isset($_POST['checkarea'])) {
				foreach ($_POST['checkarea'] as $key => $value) {
					$insertArea = "INSERT INTO `interbccs`.`area_proj` (`id_area`, `id_projeto`) VALUE ('".$value."', '".$index."')";
					mysqli_query($conn, $insertArea);
				}
			}
			//Manipulação e inserção dos professores do projeto inserido
			if (isset($_POST['checkprof'])) {
				foreach ($_POST['checkprof'] as $key => $val) {
					$insertProf = "INSERT INTO `interbccs`.`proj_prof` (`id_professor`, `id_projeto`) VALUE ('".$val."', '".$index."')";
					mysqli_query($conn, $insertProf);
				}
			}
			//Insere o professor que está cadastrando um projeto
			$insertProf = "INSERT INTO `interbccs`.`proj_prof` (`id_professor`, `id_projeto`) VALUE ('".$_SESSION['idSave']."', '".$index."')";
			mysqli_query($conn, $insertProf);

			$_SESSION['mensagem'] = "Projeto cadastrado com sucesso!";
			header('Location: ./home.php');			
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
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
			<link rel="stylesheet" href="../js/bootstrap.min.js">
			<link rel="stylesheet" href="../css/navbarfooter.css">
			<link rel="stylesheet" href="../css/cadStyle.css">
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

					<form name="form" class="form-horizontal" method="post" enctype="multipart/form-data">
						<div class="text-center">
							<h2>Cadastrar projeto</h2>
							<p>Insira nos campos abaixo os dados do projeto</p>
						</div>
						<div class="row">
							<div class="col-7">
								<div class="form-group">
									<label for="usr">NOME<span class="ast">*</span></label>
									<input type="text" class="form-control" id="nome" name="nome" maxlength="150" value="" required placeholder="Insira o nome do projeto">
								</div>
							</div>
							<div class="col-5 vertical-line">
								<div class="form-group">
									<label for="usr">LINK DO PROJETO</label>
									<input type="text" class="form-control" id="site" name="site" maxlength="150" value="" placeholder="Insira a url (opcional)">
								</div>
							</div>
						</div>
						<hr>
						<div class="form-group">
							<label for="comment">DESCRIÇÃO<span class="ast">*</span></label>
							<textarea type="text" name="descricao" class="form-control" rows="3" required maxlength="1000" id="description" placeholder="Insira a descrição do projeto"></textarea>
						</div>
						<hr>
						<div class="row">
							<div class="col-6">
								<label>ÁREAS<span class="ast">*</span></label>
								<div class="form-group">
								<?php
										$res_area = $conn->query($scriptArea);
										$rowarea = $res_area->num_rows;

										while ($obj_area=$res_area->fetch_object()) {
								?>
											<input type="checkbox" name="checkarea[]" value="<?php echo $obj_area->id_area;?>">
											<label><?php echo $obj_area->nome;?></label>
								<?php
											echo '<br>';
										}
								?>
								</div>
							</div>
								<div class="col-6 vertical-line">
									<label>PROFESSORES</label>
									<div class="form-group">
									<?php
											$res_prof = $conn->query($scriptProf);
											$rowprof = $res_prof->num_rows;

											while ($obj_prof=$res_prof->fetch_object()) {
									?>
												<input type="checkbox" name="checkprof[]" value="<?php echo $obj_prof->id_professor;?>" <?php
												if($_SESSION['idSave']==$obj_prof->id_professor) echo "checked disabled"; ?>>
												<label><?php echo $obj_prof->nome;?></label>
									<?php
												echo '<br>';
											}
									?>
									</div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-3">
								<div class="form-group">
									<label>ANO DE INÍCIO DO PROJETO<span class="ast">*</span></label>
									<input type="text" id="data" name="data" pattern="{0,9}[4]" value="" placeholder="AAAA" maxlength="4" size="5" style="text-align:center;" required>
								</div>
							</div>
							<div class="col-3 vertical-line">
								<div class="form-group">
									<label>STATUS DO PROJETO<span class="ast">*</span></label><br>
									<input type="radio" id="andamento" name="andamento" value="0" checked>
									<label> Em andamento</label><br>
									<input type="radio" id="concluido" name="andamento" value="1">
									<label> Concluído</label>
								</div>
							</div>
							<div class="col-6 vertical-line">
								<center>
									<div class="form-group">
										<img id="photo" src="../Imagens/imgindisponivel.jpg" class="img-rounded" width="330" height="210">
										<br>
										<label for="comment">FOTO DO PROJETO<span class="ast">*</span> </label>
										<input type="file" name="file" id="file" required/>
									</div>
								</center>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									<label for="comment">ALUNOS PARTICIPANTES</label>
									<textarea type="text" name="alunos" class="form-control" rows="2" maxlength="200" id="alunos" placeholder="Insira os nomes dos alunos participantes"></textarea>
								</div>
							</div>
						</div>
						<h6><span class="ast">* Campos obrigatórios</span></h6>
						<hr>
						<div class="d-flex flex-row justify-content-end col-12">
								<button class="btn btn-secondary" name="salvar_dados">Salvar</button>
						</div>
						<div id="erro"></div>
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
                $('#photo').attr('width', '330px');
                $('#photo').attr('height', '210px');
            }
        });
    </script>
	
		<!-- Trigger para validar as entradas do teclado -->
		<script>
			//Campo nome
			var x = document.getElementById('nome');
			var y = document.getElementById('site');
			var z = document.getElementById('data');
			
			x.addEventListener("keydown",
			function(e) {
				//Verifica se o evento foi um enter
				if (e.keyCode == 13) {
					e.preventDefault();
					document.getElementById('site').focus();
				}
			}
			);
			
			y.addEventListener("keydown",
			function(e) {
				//Verifica se o evento foi um enter
				if (e.keyCode == 13) {
					e.preventDefault();
					document.getElementById('description').focus();
				}
			}
			);

			z.addEventListener("keydown",
			function(e) {
				//Verifica se o evento foi um enter
				if (e.keyCode == 13) {
					e.preventDefault();
					document.getElementById('andamento').focus();
				}
			}
			);			
		</script>
</html>