<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- google fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700&display=swap" rel="stylesheet">

    <link rel="icon" href="/sistemackc/views/Img/ImgIcones/crash_icon.ico" type="image/x-icon">

    <link rel="stylesheet" href="/sistemackc/views/Css/variaveis.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/classificacao.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/etapas.css">


    <script src="https://unpkg.com/@phosphor-icons/web"></script> <!-- ONDE PEGUEI OS ICON TEMPORARIOS 'phosphor-icons' -->
    <script defer src="/sistemackc/views/Js/nav.js"></script> <!-- O atributo "defer" serve para que o script roda depois do html -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <title>Classificacao</title>

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
                            <li><a href="/sistemackc/classificacao">Classificação</a></li>
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
        <div class="background-image"></div>
        <section class="container">
            <!-- Inicio do Conteúdo para o ADM -->
            <div class="infoDeComeco">
                <h1>Classificação</h1>
                <p class="chamada">Selecione algum filtro para que o resultado seja exibido:</p>
            </div>

            <form method="get">
                <div class="containerFiltros">
                    <div class="filtro_classificacao">
                        <label for="filtro_Classificacao">Classificação desejada</label>
                        <select class="buscaSelect" id="filtroClassificacao" name="filtroClassificacao">
                            <option value="corrida" <?php echo isset($_GET['filtroClassificacao']) && $_GET['filtroClassificacao'] == 'corrida' ? 'selected' : 'selected'; ?>>Corrida</option>
                            <option value="geral" disabled<?php echo isset($_GET['filtroClassificacao']) && $_GET['filtroClassificacao'] == 'geral' ? 'selected' : ''; ?>>Geral</option>
                        </select>
                    </div>

                    <div class="filtro_campeonato">
                        <label for="filtro_Campeonato">Filtrar por Campeonato</label>
                        <select class="buscaSelect" id="filtroCampeonato" name="filtroCampeonato">
                            <option value="">Selecione um Campeonato</option>
                            <?php
                            foreach ($campeonatos as $campeonato) {
                                $selected = isset($_GET['filtroCampeonato']) && $_GET['filtroCampeonato'] == $campeonato['Id'] ? 'selected' : '';
                                echo "<option value='" . $campeonato['Id'] . "' $selected>" . $campeonato['Nome'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="filtro_dia">
                        <label for="filtroDia">Filtrar por Dia</label>
                        <select class="buscaSelect" id="filtroDia" name="filtroDia">
                            <option value="">Selecione um Dia</option>
                            <?php
                            for ($dia = 1; $dia <= 31; $dia++) {
                                $selected = isset($_GET['filtroDia']) && $_GET['filtroDia'] == $dia ? 'selected' : '';
                                echo "<option value='" . $dia . "' $selected>" . $dia . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="filtro_mes">
                        <label for="filtroMes">Filtrar por Mês</label>
                        <select class="buscaSelect" id="filtroMes" name="filtroMes">
                            <option value="">Selecione um Mês</option>
                            <?php
                            $meses = [
                                1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
                                5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
                                9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
                            ];
                            foreach ($meses as $numeroMes => $nomeMes) {
                                $selected = isset($_GET['filtroMes']) && $_GET['filtroMes'] == $numeroMes ? 'selected' : '';
                                echo "<option value='" . $numeroMes . "' $selected>" . $nomeMes . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="filtro_ano">
                        <label for="filtroAno">Filtrar por Ano</label>
                        <input type="text" class="filtroAno" id="filtroAno" name="filtroAno" placeholder="Digite o ano" value="<?php echo isset($_GET['filtroAno']) ? htmlspecialchars($_GET['filtroAno']) : ''; ?>">
                    </div>
                    <div class="form-group col-md-3 d-flex align-items-end">
                        <button type="submit" class="bt_filtrar">Filtrar</button><!-- Botão de filtar -->
                    </div>
                </div>
            </form>

            <?php 
            if (isset($feedback) && $feedback != '') {
                echo "<div class='container-feedback'>";
                echo "<span class='$classe'><i class='ph ph-warning-circle'></i><strong>$feedback</strong></span>";
                echo "</div>";
               
            } else { ?>

            <section class='containerCards'>
            <?php
            foreach ($corridas as $corrida) {
                    echo "<article class='card'>";
                    echo "<div class='titleCard_" . $corrida['nomeAbreviado'] . "'>";
                    echo "<h2><strong class='title_" . strtolower($corrida['nomeAbreviado']) . $corrida['categoria'] . "'>" . $corrida['nomeAbreviado'] . "</strong> " . $corrida['nome'] . "</h2>";
                    echo "<span>" . $corrida['nomeDoCampeonato'] . "</span>";
                    echo "</div>";
                    echo "<div class='categoria_" . $corrida['nomeAbreviado'] . $corrida['categoria'] . "'>";
                    if ($corrida['categoria'] == "Livre") {
                        echo "<span>" . $corrida['categoria'] .  "</span>";
                    } else {
                        echo "<span>" . $corrida['categoria'] . " kg</span>";
                    }
                    echo "</div>";
                    echo "<div class='date'>";
                    echo "<span>" . $corrida['data'] . "</span>"; 
                    echo "<div class='time'>";
                    echo "<i class='ph ph-steering-wheel'></i>";
                    echo "<p>" . $corrida['qtdPilotos'] . "/15</p>";
                    echo "</div>";
                    $link = '/sistemackc/classificacao/' . $tipoDeExibicao . '/' . $corrida['id'];
                    echo "<a class='btn-verResultado' href='$link'>Ver resultado</a>";
                    echo "</article>";
            }
            ?>
            </section>
        </section>
        <?php } ?>
    </main>


    <footer>
        <!-- ondas -->
        <div class="water">
            <svg class="waves" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                <defs>
                    <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"/>
                </defs>
                <g class="parallax">
                    <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(47, 44, 44, 0.7)"/>
                    <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(47, 44, 44, 0.5)"/>
                    <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(49, 46, 46, 0.3)"/>
                    <use xlink:href="#gentle-wave" x="48" y="7" fill="var(--background-campos)"/>
                
                </g>
            </svg>
        </div>
        <!-- conteudo na nav -->
        <div class="content">
            <span class="copyright">2024 Manas Code | Todos os direitos reservados</span>
            <div class="navegation">
                <div class="contact">
                    <a href="https://www.instagram.com/crashkartchampionship?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank">
                        <i class="ph-fill ph-instagram-logo"></i><!-- logo instagram-->
                    </a>
                    <a href="#" target="_blank">
                        <i class="ph-fill ph-whatsapp-logo"></i><!-- logo whatsapp-->
                    </a>
                </div>
                <div class="navigationLink">
                    <a href="/sistemackc/etapas">Etapas</a>
                    <a href="#">Classificação</a>
                    <a href="/sistemackc/kartodromo">Kartódromos</a>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>