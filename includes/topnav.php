<nav class="navbar navbar-expand-md navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse topnav" id="navbarNav">
        <div class="col-12 col-lg-12 col-md-12">
            <div class="row">
                <div class=" col-12 col-md-6 col-sm-12 col-lg-6 col-xl-6">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link <?php if ($page == 1) echo 'active';?>" href="./home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($page == 2) echo 'active';?>" href="./professor.php" >Professor</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($page == 3) echo 'active';?>" href="./area.php">Área</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($page == 4) echo 'active';?>" href="./ano.php">Ano</a>
                        </li>
                    </ul>
                </div>
                <div class="col-12 col-md-6 col-sm-12 col-lg-6 col-xl-6">
                    <div class="search-container" style="float:right;">
                        <form action="./busca.php" method="get">
                            <input type="hidden" name="busca" value="true">
                            <input type="text" placeholder="Buscar" name="search">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>   
    </div>
</nav>