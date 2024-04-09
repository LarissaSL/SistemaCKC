<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- google fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <script src="https://unpkg.com/@phosphor-icons/web"></script> <!-- ONDE PEGUEI OS ICON TEMPORARIOS 'phosphor-icons' -->
    <script defer src="/sistemackc/views/Js/nav.js"></script> <!-- O atributo "defer" serve para que o script roda depois do html -->

    <link rel="stylesheet" href="/sistemackc/views/Css/variaveis.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/kartodromo.css">

    <title>Kartodromo</title>
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
                    echo "<li><a href='#'>História</a></li>";
                ?>
                    <li class="drop-down">
                        <a href="#" class="dropdown-toggle">Corridas<i class="ph ph-caret-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Etapas</a></li>
                            <li><a href="#">Classificação</a></li>
                            <li><a href="/sistemackc/kartodromo">Kartódromos</a></li>
                        </ul>
                    </li>
                <?php } elseif (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
                    echo "<li><a href='/sistemackc/admtm85/usuario'>Usuarios</a></li>";
                    echo "<li><a href='#'>Corridas</a></li>";
                    echo "<li><a href='/sistemackc/admtm85/kartodromo'>Kartodromos</a></li>";
                    echo "<li><a href='#'>Resultados</a></li>";
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
                            <li><a href='/sistemackc/admtm85/menu'>Dashboard</a></li>
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
        <!-- botão de voltar -->
        <div id="bt-go-back">
            <a href="/sistemackc/"><i class="ph ph-caret-left"></i></a> <!--tag 'a' com o icone de seta '<' -->
        </div>
        <h1 class="titulo">Kartódromos</h1>
        <section class="container">

            <?php
            if (empty($kartodromos)) {
                if (isset($feedback) && $feedback != '') {
                    echo "<div class='container-feedback'>";
                    if ($classe == 'erro') {
                        echo "<span class='$classe'><i class='ph ph-warning-circle'></i><strong>$feedback</strong></span>";
                    } else {
                        echo "<span class='$classe'><i class='ph ph-check-square'></i><strong>$feedback</strong></span>";
                    }
                    echo "</div>";
                }
            } else {
                foreach ($kartodromos as $kartodromo) {
                    echo "<article class='card'>";
                    echo "<h2 class='nomeKartodromo'>{$kartodromo['Nome']}</h2>";
                    echo "<div class='fundoImg'>";
                    echo "<img class='imgKartodromo' src='/sistemackc/views/Img/ImgSistema/{$kartodromo['Foto']}' alt='pista do Kartódromo {$kartodromo['Nome']}'>";
                    echo "</div>";
                    echo "<div class='infoKartodromo'>";
                    echo "<div class='infoLocalizacao'>";
                    echo "<i class='ph ph-map-pin'></i>";
                    echo "<span class='subTitulo'><strong>Localização</strong></span>";
                    echo "<p class='enderecoKartodromo'>{$kartodromo['Rua']}, {$kartodromo['Numero']} - {$kartodromo['Bairro']} , CEP: {$kartodromo['CEP']} </p>";
                    echo "</div>";
                    echo "<div class='botoes'>";
                    echo "<a class='bt-siteKartodromo' href='{$kartodromo['Site']}' target='_blank'>Visitar site</a>";
                    echo "</div>";
                    echo "</div>";
                    echo "</article>";
                }
            }
            ?>
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