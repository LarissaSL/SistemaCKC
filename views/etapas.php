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
    <link rel="stylesheet" href="/sistemackc/views/Css/etapas.css">

    <script src="https://unpkg.com/@phosphor-icons/web"></script> <!-- ONDE PEGUEI OS ICON TEMPORARIOS 'phosphor-icons' -->
    <script defer src="/sistemackc/views/Js/nav.js"></script> <!-- O atributo "defer" serve para que o script roda depois do html -->

    <title>Etapas</title>
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
        <?php 
        /* Usar pra ver quais variaveis estou mandando pra View
        if(isset($corridas) && $classe != 'erro') {
            $corrida = $corridas[0];
            echo "Nome da Corrida: " . $corrida['nome'] . "<br>";
            echo "Categoria: " . $corrida['categoria'] . "<br>";
            echo "Nome do Campeonato: " . $corrida['nomeDoCampeonato'] . "<br>";
            echo "Nome do Kartódromo: " . $corrida['nomeDoKartodromo'] . "<br>";
            echo "Nome abreviado: " . $corrida['nomeAbreviado'] . "<br>";
            echo "Endereço do Kartódromo: " . $corrida['enderecoDoKartodromo'] . "<br>";
            echo "Data: " . $corrida['data'] . "<br>";
            echo "Horario: " . $corrida['hora'] . "h " . $corrida['minuto'] . "min " . "<br><br>";
        }
        */
        ?>
        
        <section class="container">
            <!--TITULO DA PAG  -->
            <h1 class="title">Etapas</h1>

            <!--LINK PARA DOWNLOAD  -->
            <div class="downloads">
                <div class="iconDownload">
                    <i class="ph ph-file-pdf"></i>
                    <a class="download" href="sistemackc/views/Docs/Regulamento CKC 2024.pdf" download="RegulamentoCKC">Baixe o regulamento</a>
                </div>
                <span class="lineDownload"></span>
            </div>

            <section class="cards">
                <!-- CARD CKC 95  -->
                <?php 

                if (empty($corridas)) {
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
                    foreach ($corridas as $corrida){ 
                        echo "<article class='card_" . $corrida['nomeAbreviado'] . $corrida['categoria'] . "'>";
                        echo "<div class='titleCad" . $corrida['nomeAbreviado'] . "'>";
                        echo "<h2><strong class='" . strtolower($corrida['nomeAbreviado']) . "Title'>" . $corrida['nomeAbreviado'] . "</strong> " . $corrida['nome'] . "</h2>";
                        echo "<span>" . $corrida['nomeDoCampeonato'] . "</span>";
                        echo "</div>";
                        echo "<div class='categoria" . $corrida['nomeAbreviado'] . $corrida['categoria'] . "'>";
                        echo "<span>" . $corrida['categoria'] . " kg</span>";
                        echo "</div>";
                        echo "<div class='date" . $corrida['nomeAbreviado'] . "'>";
                        echo "<span>" . $corrida['data'] . "</span>";
                        echo "<div class='time" . $corrida['nomeAbreviado'] . "'>";
                        echo "<i class='ph ph-timer'></i>";
                        echo "<p>" . $corrida['hora'] . "h " . $corrida['minuto'] . "min</p>";
                        echo "</div>";
                        echo "</div>";
                        echo "<div class='address" . $corrida['nomeAbreviado'] . "'>";
                        echo "<div class='kart'>";
                        echo "<i class='ph ph-map-pin'></i>";
                        echo "<span class='kartodromo'>" . $corrida['nomeDoKartodromo'] . "</span>";
                        echo "</div>";
                        echo "<p class='locale" . $corrida['nomeAbreviado'] . "'>";
                        echo "<strong>Endereço:</strong> " . $corrida['enderecoDoKartodromo'];
                        echo "</p>";
                        echo "</div>";
                        echo "<button class='inscrevase" . $corrida['nomeAbreviado'] . "'>Inscreva-se</button>";
                        echo "</article>";
                    } 
                }
                ?>
                

                <!--
                <article class="card_ckc95">
                    <div class="titleCadCkc">
                        <h2><strong class="ckcTitle">CKC</strong> Etapa 1</h2>
                        <span>Crash kart championship</span>
                    </div>
                    <div class="categoriaCkc95">
                        <span>95 Kg</span>
                    </div>
                    <div class="dateCkc">
                        <span>26/07/24</span>
                        <div class="timeCkc">
                            <i class="ph ph-timer"></i>
                            <p>16h 30min</p>
                        </div>
                    </div>
                    <div class="addressCkc">
                        <div class="kart">
                            <i class="ph ph-map-pin"></i>
                            <span class="kartodromo"> Kartódroma Granja viana</span>
                        </div>
                        <p class="localeCkc">
                            <strong>Endereço:</strong> R. Tomás Sepé, 443 - Jardim da Gloria, Cotia - SP, 06711-270
                        </p>
                    </div>

                    <button class="inscrevaseCkc">Inscreva-se</button>
                </article>

                <article class="card_ckc110">
                    <div class="titleCadCkc">
                        <h2><strong class="ckcTitle110">CKC</strong> Etapa 1</h2>
                        <span>Crash kart championship</span>
                    </div>
                    <div class="categoriaCkc110">
                        <span>110 Kg</span>
                    </div>
                    <div class="dateCkc">
                        <span>26/07/24</span>
                        <div class="timeCkc">
                            <i class="ph ph-timer"></i>
                            <p>16h 30min</p>
                        </div>
                    </div>
                    <div class="addressCkc">
                        <div class="kart">
                            <i class="ph ph-map-pin"></i>
                            <span class="kartodromo"> Kartódroma Granja viana</span>
                        </div>
                        <p class="localeCkc">
                            <strong>Endereço:</strong> R. Tomás Sepé, 443 - Jardim da Gloria, Cotia - SP, 06711-270
                        </p>
                    </div>

                    <button class="inscrevaseCkc">Inscreva-se</button>
                </article>

                
                <article class="card_dll">
                    <div class="titleCard_dll">
                        <h2><strong class="ddlTitle">DLL</strong> Etapa 1</h2>
                        <span>Desafio dos loucos</span>
                    </div>
                    <div class="categoriaDllLivre">
                        <span>Livre</span>
                    </div>
                    <div class="dateDll">
                        <span>26/07/24</span>
                        <div class="timeDll">
                            <i class="ph ph-timer"></i>
                            <p>16h 30min</p>
                        </div>
                    </div>
                    <div class="address">
                        <div class="kart">
                            <i class="ph ph-map-pin"></i>
                            <span class="kartodromo"> Kartódroma Granja viana</span>
                        </div>
                        <p class="locale">
                            <strong>Endereço:</strong> R. Tomás Sepé, 443 - Jardim da Gloria, Cotia - SP, 06711-270
                        </p>
                    </div>

                    <button class="inscrevase">Inscreva-se</button>
                </article>
                -->
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