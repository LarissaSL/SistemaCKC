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
    <link rel="stylesheet" href="/sistemackc/views/Css/index.css">

    <script src="https://unpkg.com/@phosphor-icons/web"></script> <!-- ONDE PEGUEI OS ICON TEMPORARIOS 'phosphor-icons' -->
    <script defer src="/sistemackc/views/Js/nav.js"></script> <!-- O atributo "defer" serve para que o script roda depois do html -->

    <title>Home page</title>
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
        <section class="containerPrincipal">
            <div class="containerConteudo">
                <div class="conteudo">
                    <h1 class="titulo">Bem-vindo ao CKC</h1>
                    <h2 class="subtitulo">o melhor Campeonato de Kart de São-Paulo!</h2>
                    <p class="textoChamada">
                        Se você é daqueles que sonham com <strong>curvas perfeitas em alta velocidade e sentem a emoção pulsar a cada acelerada</strong>, você está no lugar certo! Seja você um piloto experiente ou um novato ansioso para arrancar, temos uma corrida para todos os gostos.
                    </p>
                    <p class="textoChamada">
                        Então, venha fazer parte dessa família onde a única regra é: <strong>Velocidade, emoção e, é claro, uma pitada de loucura!</strong>
                    </p>
                    <?php 
                    if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 'Comum') : ?>
                        <div class="botoes">
                            <a class="bt-redirecionar" href="/sistemackc/usuario/login">Entrar</a>
                            <a class="bt-redirecionar" href="/sistemackc/usuario/cadastro">Cadastrar</a>
                        </div>
                    <?php endif ?>

                </div>

                <div class="containerImagem">
                    <img class="fundoImg" src="/sistemackc/Views/Img/ImgTelas/fundo.png" alt=" fundo da foto do Crash">
                    <img class="imagem" src="/sistemackc/Views/Img/ImgTelas/crash.png" alt="foto do Crash">
                </div>
            </div>
        </section>


        <section class="containerSecundario">
            <div class="onda">
                <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
                </svg>
            </div>

            <div class="containerTextos">
                <h2 class="subtitulo">Queremos que você conheça todas as emoções que o CKC tem a oferecer!</h2>
                <p class="textoChamada">
                    Aqui, você não apenas participa das corridas, mas também <strong>acelera em uma experiência única de kartismo</strong>. Vamos dar uma olhada em nossas incríveis funcionalidades:
                </p>
            </div>
            <div class="containerFuncionalidades">
                <div class="funcionalidade">
                    <div class="textoDestaque">
                        <i class="ph ph-flag-checkered"></i>
                        <h3 class="tituloFuncionalidade">Corridas Inesquecíveis</h3>
                    </div>

                    <div class="chamadaFuncionalidade">
                        <p class="texto">
                            Para os experientes, temos o prestigiado <strong>Campeonato de Kart CKC</strong>, onde os pilotos mais habilidosos competem pela glória nas pistas mais desafiadoras.
                        </p>
                        <p class="texto">
                            E para os iniciantes, apresentamos o <strong> DDL (Desafio dos Loucos)</strong>, uma oportunidade perfeita para começar sua jornada no mundo das corridas e sentir a emoção de acelerar pela primeira vez!
                        </p>
                    </div>
                    <div class="botao">
                        <a class="bt-redirecionar" href="/sistemackc/etapas">Vamos nessa!</a>
                    </div>
                </div>

                <div class="funcionalidade">
                    <div class="textoDestaque">
                        <i class="ph ph-map-pin"></i>
                        <h3 class="tituloFuncionalidade">Kartódromos de Primeira Classe</h3>
                    </div>
                    <div class="chamadaFuncionalidade">
                        <p class="texto">
                            Os kartódromos não são apenas locais de competição, mas também <strong>espaços de treinamento e diversão.</strong> Disponíveis para treinos regulares, você pode aprimorar suas habilidades e preparar-se para os desafios das corridas.
                        </p>
                        <p class="texto">
                            <strong>E lembre-se, é nos kartódromos que a magia das corridas acontece!</strong>
                        </p>
                    </div>
                    <div class="botao">
                        <a class="bt-redirecionar" href="/sistemackc/kartodromo">Vamos nessa!</a>
                    </div>
                </div>

                <div class="funcionalidade">
                    <div class="textoDestaque">
                        <i class="ph ph-broadcast"></i>
                        <h3 class="tituloFuncionalidade">Transmissões</h3>
                    </div>
                    <div class="chamadaFuncionalidade">
                        <p class="texto">
                            Reviva os momentos mais emocionantes do CKC através das <strong>transmissões.</strong>
                        </p>
                        <p class="texto">
                            Capturamos cada curva, ultrapassagem e vitória para que você possa sentir a adrenalina como se estivesse lá. Não perca a <strong>transmissão ao vivo das corridas,</strong> trazendo toda a ação direto para a tela do seu dispositivo!
                        </p>
                    </div>
                    <div class="botao">
                        <a class="bt-redirecionar" href="#">Vamos nessa!</a>
                    </div>
                </div>
            </div>
        </section>


        <section class="containerPatrocinadores">
            <div class="ondaFinal">
                <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
                </svg>
            </div>

            <div class="containerTexto">
                <h2 class="subtitulo">Conheça nossos patrocinadores</h2>
            </div>
            <div class="containerLogos">
                <div class="patrocinador">
                    <a href="#">
                        <img src="/sistemackc/Views/Img/ImgTelas/logoVertical1.png" alt="patrocinador">
                    </a>
                </div>
                <div class="patrocinador">
                    <a href="#">
                        <img src="/sistemackc/Views/Img/ImgTelas/logoVertical2.png" alt="patrocinador">
                    </a>
                </div>
                <div class="patrocinador">
                    <a href="#">
                        <img src="/sistemackc/Views/Img/ImgTelas/logoVertical1.png" alt="patrocinador">
                    </a>
                </div>
                <div class="patrocinador">
                    <a href="#">
                        <img src="/sistemackc/Views/Img/ImgTelas/logoVertical2.png" alt="patrocinador">
                    </a>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <div>
            <span class="copyright">© 2024 Copyright: ManasCode</span>
            <div>
                <img src="/sistemackc/views/Img/ImgIcones/github.png" alt="logo github">
                <a target="_blank" href="https://github.com/LarissaSL/SistemaCKC_MVC">Repositório do Projeto</a>
            </div>
        </div>
    </footer>
</body>

</html>