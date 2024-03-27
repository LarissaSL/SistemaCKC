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
    <script defer src="/views/Js/nav.js"></script> <!-- O atributo "defer" serve para que o script roda depois do html -->

    <link rel="stylesheet" href="/sistemackc/views/Css/variaveis.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/kartodromo.css">

    <title>Kartodromo</title>
</head>

<body>

    <header class="header">
        <nav class="nav">
            <a class="logo" href="/sistemackc/"><img src="/sistemackc/views/Img/ImgSistema/logoCKC.png" alt="logo do CKC"></a>

            <button class="hamburger"></button>
            <ul class="nav-list">
                <li><a href="#">História</a></li>

                <li class="drop-down">
                    <a href="#" class="dropdown-toggle">Corridas<i class="ph ph-caret-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Etapas</a></li>
                        <li><a href="#">Classificação</a></li>
                        <li><a href="#">Galeria</a></li>
                        <li><a href="#">Inscrição</a></li>
                        <li><a href="#">Regulamento</a></li>
                        <li><a href="/sistemackc/kartodromo">Kartódromos</a></li>
                    </ul>
                </li>
                <li>
                    <?php
                    if (!isset($_SESSION)) {
                        session_start();
                    }
                    if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Comum') {
                        echo "<p>Olá, " . $_SESSION['nome'] . "</p>";
                        echo "<ul class='drop-corrida'>";
                        echo "<li><a href='/sistemackc/usuario/{$_SESSION['id']}'>Perfil</a></li>";
                        echo "<li><a href='/sistemackc/logout'>Logout</a></li>";
                        echo "</ul>";
                    } elseif (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
                        echo "<p>Olá, " . $_SESSION['nome'] . "</p>";
                        echo "<ul class='drop-corrida'>";
                        echo "<li><a href='/sistemackc/usuario/{$_SESSION['id']}'>Perfil</a></li>";
                        echo "<li><a href='/sistemackc/admtm85/menu'>Dashboard</a></li>";
                        echo "<li><a href='/sistemackc/logout'>Logout</a></li>";
                        echo "</ul>";
                    } else {
                        echo "<a href='/sistemackc/usuario/login'>Entrar</a>";
                    }
                    ?>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <!-- botão de voltar -->
        <div id="bt-go-back">
            <a href="/sistemackc/"><i class="ph ph-caret-left"></i>Voltar</a> <!--tag 'a' com o icone de seta '<' -->
        </div>
        <h1 class="titulo">Kartódromos</h1>
        <section class="container">
            
            <?php
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
                        echo "<a href='#' class='bt-comoChegar'>Como chegar</a>";
                    echo "</div>";
                    echo "</div>";
                echo "</article>";
            }
            ?>
        </section>
    </main>
    <footer>
        <p>© Manas code</p>
    </footer>
</body>

</html>