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

    <link rel="icon" href="/sistemackc/views/Img/ImgIcones/crash_icon.ico" type="image/x-icon">

    <script defer src="/sistemackc/views/Js/notificacao.js"></script> 
      <!-- Custom CSS -->
    <link rel="stylesheet" href="/sistemackc/views/Css/CssUsuario/notificacoes.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/variaveis.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/CssUsuario/kartodromo.css">

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
                    echo "<li><a href='#'>Resultados</a></li>";
                } ?>

                <?php
                if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Comum') { ?>
                    <li class="drop-down">
                        <?php echo "<a href='#' class='dropdown-toggle'>Olá, " . $_SESSION['nome'] . "<i class='ph ph-caret-down'></i></a>"; ?>
                        <ul class="dropdown-menu">
                            <?php echo "<li><a href='/sistemackc/usuario/{$_SESSION['id']}'>Perfil</a></li>"; ?>
                            <?php echo "<li><a href='/sistemackc/logout'>Sair</a></li>"; ?>
                        </ul>
                    </li>
                <?php } elseif (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') { ?>
                    <li class='drop-down'>
                        <?php echo "<a href='#' class='dropdown-toggle'>Olá, " . $_SESSION['nome'] . "<i class='ph ph-caret-down'></i></a>"; ?>
                        <ul class='dropdown-menu'>
                            <?php echo "<li><a href='/sistemackc/usuario/{$_SESSION['id']}'>Perfil</a></li>"; ?>
                            <li><a href='/sistemackc/admtm85/menu'>Menu</a></li>
                            <li><a href='/sistemackc/logout'>Sair</a></li>
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
                        echo '
                        <div class="nofifications">
                            <div class="toast success">
                                <div class="column">
                                    <i class="ph-fill ph-warning"></i><!--icone de exclamação-->
                                    <span class="'. $classe .'">'. $feedback .'</span>
                                </div>
                                <i class="ph ph-x" onclick="(this.parentElement).remove()"></i><!--iconde de X -->
                            </div>
                        </div>';
                    } else {
                        echo '
                        <div class="nofifications">
                            <div class="toast success">
                                <div class="column">
                                    <i class="ph-fill ph-warning"></i><!--icone de exclamação-->
                                    <span class="'. $classe .'">'. $feedback .'</span>
                                </div>
                                <i class="ph ph-x" onclick="(this.parentElement).remove()"></i><!--iconde de X -->
                            </div>
                        </div>';
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
                    echo "<a class='bt-siteKartodromo' href='{$kartodromo['Redes']}' target='_blank'>Visitar rede</a>";
                    echo "</div>";
                    echo "</div>";
                    echo "</article>";
                }
            }
            ?>
        </section>
    </main>
    <footer>
        <!-- ondas -->
        <div class="water">
            <svg class="waves" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                <defs>
                    <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                </defs>
                <g class="parallax">
                    <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(47, 44, 44, 0.7)" />
                    <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(47, 44, 44, 0.5)" />
                    <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(49, 46, 46, 0.3)" />
                    <use xlink:href="#gentle-wave" x="48" y="7" fill="var(--background-campos)" />
                </g>
            </svg>
        </div>
        <!-- conteudo na nav -->
        <div class="content">
            <div class="copyrights">
                <span class="copyright">© Sistema Gerenciador de corridas de kart. Todos os Direitos Reservados à Manas Code</span>
                <div class="logos">
                    <div class="logSistema">
                        <span class="copySistema">Plataforma</span>
                        <img class="logo logoSistema" src="/sistemackc/Views/Img/ImgSistema/logoSis_Gerenciador_kart.png" alt="logo do Sistema Gerenciador de Corridas de Kart ">
                    </div>
                    <div class="logManas">
                        <span class="copyDevs">Desenvolvedora</span>
                        <img class="logo logoManasC" src="/sistemackc/Views/Img/ImgSistema/logoManasC.png" alt="logo da desenvolvedora do sistema - Manas Code">
                    </div>
                </div>
            </div>

            <div class="navegation">
                <div class="contact">
                    <a href="https://www.instagram.com/crashkartchampionship?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank">
                        <i class="ph-fill ph-instagram-logo"></i><!-- logo instagram-->
                    </a>
                    <a href="https://wa.me/5511984372045" target="_blank">
                        <i class="ph-fill ph-whatsapp-logo"></i><!-- logo whatsapp-->
                    </a>
                </div>
                <div class="navigationLink">
                    <a href="/sistemackc/etapas">Etapas</a>
                    <a href="/sistemackc/classificacao">Classificação</a>
                    <a href="/sistemackc/kartodromo">Kartódromos</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.botpress.cloud/webchat/v1/inject.js"></script>
    <script defer src="https://mediafiles.botpress.cloud/5a7f406f-c78a-46b6-a7e5-bf4a1daed5fb/webchat/config.js"></script>
</body>

</html>