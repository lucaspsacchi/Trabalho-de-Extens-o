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
								FROM area
								GROUP BY nome ASC";

	$resultArea = $conn->query($scriptArea);

	//Realiza uma busca no banco de dados para buscar todos os professores
	$scriptProf = "SELECT id_professor, nome, enable
								FROM professor
								ORDER BY nome ASC";

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

		// Verifica se os campos de checkbox foram preenchidos
		if ($_POST['checkarea'] == NULL) {
			$_SESSION['msg_erro'] = 'Pelo menos uma área deve ser selecionada';
		}


		
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

							$flag_img = move_uploaded_file($sourcePath, $destino); // Moving Uploaded file
							//if ($flag_img != TRUE) {
								?>
								<script>
									alert("Ocorreu um erro inesperado com a imagem");
								</script>
								<?php
							//}
					}
				}
			}


			//Inserção dos dados do projeto no banco de dados
			if ($var_site == NULL && $var_alunos == NULL) {
				$insertSQL = "INSERT INTO projeto (nome, foto, descricao, data_inicio, concluido, enable, sem_ini, tipo_proj) VALUES ('".$_POST['nome']."', '".$novoNome."', '".$_POST['descricao']."', '".$_POST['data']."', '".$_POST['andamento']."', '1', '".$_POST['sem_ini']."', '".$_POST['tipo_proj']."');";
			}
			else if ($var_site == NULL) {
				$insertSQL = "INSERT INTO projeto (nome, foto, descricao, alunos, data_inicio, concluido, enable, sem_ini, tipo_proj) VALUES ('".$_POST['nome']."', '".$novoNome."', '".$_POST['descricao']."', '".$var_alunos."', '".$_POST['data']."', '".$_POST['andamento']."', '1', '".$_POST['sem_ini']."', '".$_POST['tipo_proj']."');";
			}
			else if ($var_alunos == NULL) {
				$insertSQL = "INSERT INTO projeto (nome, foto, site_proj, descricao, data_inicio, concluido, enable, sem_ini, tipo_proj) VALUES ('".$_POST['nome']."', '".$novoNome."', '".$var_site."', '".$_POST['descricao']."', '".$_POST['data']."', '".$_POST['andamento']."', '1', '".$_POST['sem_ini']."', '".$_POST['tipo_proj']."');";			
			}
			else {
				$insertSQL = "INSERT INTO projeto (nome, foto, site_proj, descricao, alunos, data_inicio, concluido, enable, sem_ini, tipo_proj) VALUES ('".$_POST['nome']."', '".$novoNome."', '".$var_site."', '".$_POST['descricao']."', '".$var_alunos."', '".$_POST['data']."', '".$_POST['andamento']."', '1', '".$_POST['sem_ini']."', '".$_POST['tipo_proj']."');";			
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
					$insertArea = "INSERT INTO area_proj (id_area, id_projeto) VALUE ('".$value."', '".$index."')";
					mysqli_query($conn, $insertArea);
				}
			}
			//Manipulação e inserção dos professores do projeto inserido
			if (isset($_POST['checkprof'])) {
				foreach ($_POST['checkprof'] as $key => $val) {
					$insertProf = "INSERT INTO proj_prof (id_professor, id_projeto) VALUE ('".$val."', '".$index."')";
					mysqli_query($conn, $insertProf);
				}
			}
			//Insere o professor que está cadastrando um projeto
			$insertProf = "INSERT INTO proj_prof (id_professor, id_projeto) VALUE ('".$_SESSION['idSave']."', '".$index."')";
			mysqli_query($conn, $insertProf);

			$_SESSION['msg_proj'] = "Projeto cadastrado com sucesso!";
			header('Location: ./home.php');
		}

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
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<link rel="stylesheet" href="../js/bootstrap.min.js">
		<link rel="stylesheet" href="../css/navbarfooter.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<link rel="stylesheet" href="../css/cadStyle.css">
		
		<!-- Sweet Alert 2 -->
		<script src="../sweetalert2-master/dist/sweetalert2.min.js"></script>
		<link rel="stylesheet" href="../sweetalert2-master/dist/sweetalert2.min.css">		
		<!-- Cropper -->
		<!-- <link  href="../cropperjs-master/dist/cropper.css" rel="stylesheet">
		<script src="../cropperjs-master/dist/cropper.js"></script> -->
    </head>
    <body>

		<!-- Navbar -->
		<?php include '../includes/nav-cad.php'?>

        <br><br>
				<div class="container">
					
					<!-- Breadcrumb -->
					<label><a href="./home.php">Home</a> > Cadastrar Projeto</label>
					<hr><br>
					
					<form name="form" class="form-horizontal" method="post" enctype="multipart/form-data">
						<div class="text-center">
							<h2>Cadastrar projeto</h2>
						</div>
						<br>
						<h6><span class="ast">* Campos obrigatórios</span></h6>
						<hr>
						<div class="row">
							<div class="col-7">
								<div class="form-group">
									<label for="usr">NOME<span class="ast">*</span></label>
									<input type="text" class="form-control" id="nome" name="nome" maxlength="150" value="" required placeholder="Insira o nome do projeto">
								</div>
							</div>
							<div class="col-5">
								<div class="form-group">
									<label for="usr">LINK DO PROJETO</label>
									<input type="text" class="form-control" id="site" name="site" maxlength="150" value="" placeholder="Insira a url (opcional)">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="comment">DESCRIÇÃO<span class="ast">*</span></label>
							<textarea type="text" name="descricao" class="form-control" rows="3" required maxlength="1000" id="description" placeholder="Insira a descrição do projeto"></textarea>
						</div>
						<hr>
						<center>
							<label>ÁREAS<span class="ast">*</span></label>
						</center>
						<br>
						<div class="row">
							<div class="col-4">
								<div class="form-group">
								<?php
										$res_area = $conn->query($scriptArea);
										$rowarea = $res_area->num_rows;
										$count = 0;

										while ($obj_area=$res_area->fetch_object()) {
								?>
											<input type="checkbox" name="checkarea[]" value="<?php echo $obj_area->id_area;?>">
											<span style="font-size: 16px; line-height: 2rem;"><?php echo $obj_area->nome;?></span>
								<?php
											echo '<br>';
											$count++;
											if ($count == 17 || $count == 34) { // Adiciona nova coluna
												echo '</div></div><div class="col-4 vertical-line"><div class="form-group">';
											}
										}
								?>
								</div>
							</div>
						</div>
						<hr>
						<center>
							<label>PROFESSORES</label>
						</center>
						<br>
						<div class="row">
							<div class="col-4">
								<div class="form-group">
								<?php
										$res_prof = $conn->query($scriptProf);
										$rowprof = $res_prof->num_rows;
										$count = 0;

										while ($obj_prof=$res_prof->fetch_object()) {
											if ($obj_prof->enable) {
								?>
											<input type="checkbox" name="checkprof[]" value="<?php echo $obj_prof->id_professor;?>" <?php
											if($_SESSION['idSave']==$obj_prof->id_professor) echo "checked disabled"; ?>>
											<span style="font-size: 16px; line-height: 2rem;"><?php echo $obj_prof->nome;?></span>
								<?php
											echo '<br>';
											$count++;
											if ($count == 5 || $count == 9) { // Adiciona nova coluna
												echo '</div></div><div class="col-4 vertical-line"><div class="form-group">';
											}											
											}
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
								<div class="form-group">
									<label>SEMESTRE DE INICIO<span class="ast">*</span></label><br>
									<input type="radio" id="sem_ini1" name="sem_ini" value="0" checked>
									<label> Primeiro</label><br>
									<input type="radio" id="sem_ini2" name="sem_ini" value="1">
									<label> Segundo</label>
								</div>
							</div>
							<div class="col-2 vertical-line">
								<div class="form-group">
									<label>STATUS DO PROJETO<span class="ast">*</span></label><br>
									<input type="radio" id="andamento" name="andamento" value="0" checked>
									<label> Em andamento</label><br>
									<input type="radio" id="concluido" name="andamento" value="1">
									<label> Concluído</label>
								</div>
							</div>
							<div class="col-2 vertical-line">
								<div class="form-group">
									<label>TIPO DO PROJETO<span class="ast">*</span></label><br>
									<input type="radio" id="tipo_proj1" name="tipo_proj" value="0" checked>
									<label> Projeto pessoal</label><br>
									<input type="radio" id="tipo_proj2" name="tipo_proj" value="1">
									<label> Projeto de disciplina</label><br>
									<input type="radio" id="tipo_proj3" name="tipo_proj" value="2">
									<label> Projeto extensão</label>									
								</div>
							</div>
							<div class="col-5 vertical-line">
								<center>
									<div class="form-group">
										<label for="comment">FOTO DO PROJETO<span class="ast">*</span> </label><br>
										<img id="photo" src="../Imagens/imgindisponivel.jpg" class="img-rounded" width="330" height="210" style="margin-bottom: 10px;">
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
						<div class="d-flex flex-row justify-content-end col-12">
							<div class="row">
								<a class="btn btn-secondary" href="./home.php" name="cancelar_dados">Cancelar</a>
								<div class="" style="border-left: 1px solid #5A6268; margin-left: 15px; margin-right: 15px;"></div>
								<button class="btn btn-success" name="salvar_dados">Salvar</button>
							</div>
						</div>
						<div id="erro"></div>
					</form>
				</div>
        <br><br>

		<!-- Footer -->
		<?php include '../includes/footer-cad.php'?>

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

<?php
if (isset($_SESSION['msg_erro'])) {
?>
<script>
$(document).ready(function() {
	Swal({
		type: 'error',
		title: 'Erro ao cadastrar projeto!',
		text: '<?php echo $_SESSION['msg_erro'];?>'
	})
})
</script>

<?php
unset($_SESSION['msg_erro']);
}
?>