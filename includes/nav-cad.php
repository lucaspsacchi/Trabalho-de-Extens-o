<nav class="navbar my-nav">
    <div class="col-12 col-md-12">
        <div class="row">
            <!-- Logo e nome do site posicionado no começo -->
            <div class="col-5 col-md-5">
                <div id="nav-space" class="row">
                    <a class="nav-anc" href="home.php">
                        <img src="../Imagens/Inter%20BCCS%20Logo%20Fundo%20Branco.png" width="35px" height="35px" style="margin-top: 7px;" alt="logo">
                    </a>
                    <form action="./busca.php" method="GET"> <!-- FAZER ESSA TELA -->
                        <div class="row" style="margin-top: 5px; margin-left: 0px;">
                            <input name="nome" class="form-control form-custom" placeholder="Pesquisar no INTERBCCS" type="text" aria-label="Search">
                            <button type="submit" class="btn btn-light">Buscar</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Campo buscar posicionado no centro -->
            <div class="col-2 col-md-2">
                <div class="d-flex justify-content-center">
                    <a class="nav-anc" href="home.php">
                        <h4 class="nav-h4">INTERBCCS</h4>
                    </a>
                </div>
            </div>

            <!-- Perfil e sair posicionado para a direita -->
            <div class="col-5 col-md-5">
                <div class="row d-flex justify-content-end">
                    <a class="nav-link" href="./perfil.php">PERFIL</a>
                    <a class="nav-link nav-link-custom" href="./sair.php">SAIR</a>
                </div>
            </div>
        </div>
    </div>
</nav>