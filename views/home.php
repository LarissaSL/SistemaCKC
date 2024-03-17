<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
</head>
<body>
    <header>
        <nav>
            <i class="ph ph-list"></i><!-- ícone de menu -->
            <ul>
                <li><img src="./views/Img/ImgSistema/logoCKC.png" alt="logo do CKC"></li>
                <li><a href="#">História</a></li>
                <li>
                    <a href="#">Corridas</a>
                    <ul class="drop-corrida">
                        <li><a href="#">Etapas</a></li>
                        <li><a href="#">Classificação</a></li>
                        <li><a href="#">Galeria</a></li>
                        <li><a href="#">Inscrição</a></li>
                        <li><a href="#">Regulamento</a></li>
                        <li><a href="/sistemackc/kartodromo">Kartódromo</a></li>
                    </ul>
                </li> 
                <li>
                    <?php
                    session_start();
                    if(isset($_SESSION['nome'])) {
                        echo "<p>Olá, " . $_SESSION['nome'] . "</p>";
                        echo "<ul class='drop-corrida'>";
                        echo "<li><a href='./usuario/{$_SESSION['id']}'>Perfil</a></li>";
                        echo "<li><a href='./logout'>Logout</a></li>";
                        echo "</ul>";
                    } else {
                        echo "<a href='./usuario/login'>Entrar</a>";
                    }
                    ?>
                </li>               
            </ul>
        </nav>
    </header>

    <h1>Landing Page</h1>
    
</body>
</html>




