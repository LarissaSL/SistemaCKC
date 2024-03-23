<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="/views/Js/nav.js"></script> <!-- O atributo "defer" serve para que o script roda depois do html -->
    <title>Home Page</title>
</head>
<body>
    <header>
        <nav>
            <i class="ph ph-list"></i><!-- ícone de menu -->
            <ul>
                <li><a href="/sistemackc/"><img src="./views/Img/ImgSistema/logoCKC.png" alt="logo do CKC"></a></li>
                
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
                        if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Comum') {
                            echo "<p>Olá, " . $_SESSION['nome'] . "</p>";
                            echo "<ul class='drop-corrida'>";
                            echo "<li><a href='/sistemackc/usuario/{$_SESSION['id']}'>Perfil</a></li>";
                            echo "<li><a href='/sistemackc/logout'>Logout</a></li>";
                            
                        } elseif(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
                            echo "<p>Olá, " . $_SESSION['nome'] . "</p>";
                            echo "<ul class='drop-corrida'>";
                            echo "<li><a href='/sistemackc/usuario/{$_SESSION['id']}'>Perfil</a></li>";
                            echo "<li><a href='/sistemackc/admtm85/menu'>Dashboard</a></li>";
                            echo "<li><a href='/sistemackc/logout'>Logout</a></li>";
                        } else {
                            echo "<a href='/sistemackc/usuario/login'>Entrar</a>";
                        }
                    ?>
                </li>               
            </ul>
        </nav>
    </header>

    <h1>Landing Page</h1>
    
</body>
</html>




