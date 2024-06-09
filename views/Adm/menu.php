<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
     <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap"rel="stylesheet">

    <link rel="icon" href="/sistemackc/views/Img/ImgIcones/crash_icon.ico" type="image/x-icon">

    <script src="https://unpkg.com/@phosphor-icons/web"></script> <!-- ONDE PEGUEI OS ICON TEMPORARIOS 'phosphor-icons' -->
    <script defer src="/sistemackc/views/Js/nav.js"></script> <!-- O atributo "defer" serve para que o script roda depois do html -->


    <!-- Custom CSS -->
    <link rel="stylesheet" href="/sistemackc/views/Css/variaveis.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/CssAdm/menu.css">

    <title>Menu</title>
</head>

<body>
    <header class="header">
        <?php
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
        ?>
            <nav class="nav">
                <a class="logo" href="/sistemackc/"><img src="/sistemackc/views/Img/ImgSistema/logoCKC.png" alt="logo do CKC"></a>

                <button class="hamburger"></button> 
                <ul class="nav-list">                    
                    <li class="drop-down">
                        <?php
                        if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
                            echo "<a href='#' class='dropdown-toggle'>Olá, " . $_SESSION['nome'] . "<i class='ph ph-caret-down'></i></a>";
                            echo "<ul class='dropdown-menu'>";
                            echo "<li><a href='/sistemackc/usuario/{$_SESSION['id']}'>Perfil</a></li>";
                            echo "<li><a href='/sistemackc/logout'>Sair</a></li>";
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
        <section class="container">
            <div class="titulo">
                <h1>Bem vindo ao Sistema CKC!</h1>
            </div>

            <div class="cards-container">
                <div class="card-item">
                    <div class="card">
                        <div class="icon">
                            <a href="/sistemackc/admtm85/usuario">
                                <i class="ph ph-users"></i>
                            </a>
                        </div>
                    </div>
                    <a href="/sistemackc/admtm85/usuario" class="card-link">Usuários</a>
                </div>

                <div class="card-item">
                    <div class="card">
                        <div class="icon">
                            <a href="/sistemackc/admtm85/corrida">
                                <i class="ph ph-flag"></i>
                            </a>
                        </div>
                    </div>
                    <a href="/sistemackc/admtm85/corrida" class="card-link">Corridas</a>
                </div>

                <div class="card-item">
                    <div class="card">
                        <div class="icon">
                            <a href="/sistemackc/admtm85/campeonato">
                                <i class="ph ph-trophy"></i>
                            </a>
                        </div>
                    </div>
                    <a href="/sistemackc/admtm85/campeonato" class="card-link">Campeonatos</a>
                </div>

                <div class="card-item">
                    <div class="card">
                        <div class="icon">
                            <a href="/sistemackc/admtm85/resultado">
                                <i class="ph ph-list-numbers"></i>
                            </a>
                        </div>
                    </div>
                    <a href="/sistemackc/admtm85/resultado" class="card-link">Resultados</a>
                </div>

                <div class="card-item">
                    <div class="card">
                        <div class="icon">
                            <a href="/sistemackc/admtm85/kartodromo">
                                <i class="ph ph-map-pin"></i>
                            </a>
                        </div>
                    </div>
                    <a href="/sistemackc/admtm85/kartodromo" class="card-link">Kartódromos</a>
                </div>
            </div>

            <p class="texto">Escolha uma das opções acima e clique para continuar.</p>
        </section>
    </main>
    <?php 
        } else {
            echo "<h1>Acesso não autorizado</h1>";
        }
    ?>
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
                        <span class="copyDevs">desenvolvedor</span>
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
</body>

</html>
