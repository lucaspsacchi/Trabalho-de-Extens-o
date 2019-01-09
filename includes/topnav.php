<div class="topnav">
    <a class="nav-link <?php if ($page == 1) echo 'active';?>" href="./home.php">Home</a>
    <a class="nav-link <?php if ($page == 2) echo 'active';?>" href="./professor.php" >Professor</a>
    <a class="nav-link <?php if ($page == 3) echo 'active';?>" href="./area.php">Área</a>
    <a class="nav-link <?php if ($page == 4) echo 'active';?>" href="./ano.php">Ano</a>


    <div class="search-container">
        <form action="./busca.php" method="POST">
            <input type="hidden" name="busca" value="true">
            <input type="text" placeholder="Buscar" name="search">
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
</div>