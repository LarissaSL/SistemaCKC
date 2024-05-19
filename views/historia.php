<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- google fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <!-- ícone de menu  -->
    <link rel="stylesheet" href="/sistemackc/views/Css/variaveis.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/historia.css">

    <link rel="icon" href="/sistemackc/views/Img/ImgIcones/crash_icon.ico" type="image/x-icon">

    <script src="https://unpkg.com/@phosphor-icons/web"></script> <!-- ONDE PEGUEI OS ICON TEMPORARIOS 'phosphor-icons' -->
    <script defer src="/sistemackc/views/Js/nav.js"></script> <!-- O atributo "defer" serve para que o script roda depois do html -->

    <title>Historia</title>
</head>

<body>
    <?php
    if (!isset($_SESSION)) {
        session_start();
    }
    ?>
    <header class="header">
        <nav class="nav">
            <a class="logo" href="/sistemackc/"><img src="/sistemackc/views/Img/ImgSistema/logoCKC.png" alt="logo do CKC"></a>

            <button class="hamburger"></button>
            <ul class="nav-list">
                <?php
                if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Comum' || !isset($_SESSION['tipo'])) {
                    echo "<li><a href='/sistemackc/historia'>História</a></li>";
                ?>
                    <li class="drop-down">
                        <a href="#" class="dropdown-toggle">Corridas<i class="ph ph-caret-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="/sistemackc/etapas">Etapas</a></li>
                            <li><a href="#">Classificação</a></li>
                            <li><a href="/sistemackc/kartodromo">Kartódromos</a></li>
                        </ul>
                    </li>
                <?php } elseif (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
                    echo "<li><a href='/sistemackc/admtm85/usuario'>Usuarios</a></li>";
                    echo "<li><a href='/sistemackc/admtm85/campeonato'>Campeonatos</a></li>";
                    echo "<li><a href='/sistemackc/admtm85/corrida'>Corridas</a></li>";
                    echo "<li><a href='/sistemackc/admtm85/kartodromo'>Kartodromos</a></li>";
                    echo "<li><a href='/sistemackc/admtm85/resultado'>Resultados</a></li>";
                } ?>

                <?php
                if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Comum') { ?>
                    <li class="drop-down">
                        <?php echo "<a href='#' class='dropdown-toggle'>Olá, " . $_SESSION['nome'] . "<i class='ph ph-caret-down'></i></a>"; ?>
                        <ul class="dropdown-menu">
                            <?php echo "<li><a href='/sistemackc/usuario/{$_SESSION['id']}'>Perfil</a></li>"; ?>
                            <?php echo "<li><a href='/sistemackc/logout'>Logout</a></li>"; ?>
                        </ul>
                    </li>
                <?php } elseif (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') { ?>
                    <li class='drop-down'>
                        <?php echo "<a href='#' class='dropdown-toggle'>Olá, " . $_SESSION['nome'] . "<i class='ph ph-caret-down'></i></a>"; ?>
                        <ul class='dropdown-menu'>
                            <?php echo "<li><a href='/sistemackc/usuario/{$_SESSION['id']}'>Perfil</a></li>"; ?>
                            <li><a href='/sistemackc/admtm85/menu'>Menu</a></li>
                            <li><a href='/sistemackc/logout'>Logout</a></li>
                        </ul>
                    </li>
                <?php } else {
                    echo "<a href='/sistemackc/usuario/login'>Entrar</a>";
                }
                ?>
            </ul>
        </nav>
    </header>
    <main>
        <section class="container">
            <h1 class="title">História do CKC</h1>
            <section class="text">
                <div class="history">
                    <p>
                        <strong>Fundado em 2022</strong> pelos pilotos Thiago Menezes e Diego Rico, o <strong>CKC - Crash Kart Championship</strong> surgiu da necessidade de evolução do grupo de amigos que se reuniam para correr de kart, na época chamado Desafio dos Loucos.
                    </p>
                    <p>
                        Eles queriam um <strong>campeonato onde pudessem competir e ganhar troféus, sem perder a resenha e a diversão entre amigos</strong>, por isso, decidiram transformar o <strong>DDL - Desafio dos Loucos em uma categoria de base</strong> e criaram o CKC, promovendo um maior alcance de  pessoas e deixando o campeonato ainda mais competitivo.
                    </p>
                    <p>
                        Acesse nosso Regulamento, saiba mais e Junte-se a nós!
                    </p>

                    <div class="buttonRegulaion">
                        <button class="regulation">Baixe o regulamento</button>
                    </div>
                </div>

                <div class="img">
                    <img src="/sistemackc/Views/Img/ImgTelas/historia.png" alt="fundadores do campeonato ckc">
                </div>

            </section>
        </section>

    </main>
    <footer>
        <div>
            <span class="copyright">© 2024 Copyright: ManasCode</span>
            <div>
                <img src="/sistemackc/views/Img/ImgIcones/github.png">
                <a target="_blank" href="https://github.com/LarissaSL/SistemaCKC_MVC">Repositório do Projeto</a>
            </div>
        </div>
    </footer>
</body>

</html>