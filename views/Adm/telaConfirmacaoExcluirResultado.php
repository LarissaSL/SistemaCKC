<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado da Corrida</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="/sistemackc/views/Css/variaveis.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/CssAdm/resultadoExibir.css">
    <link rel="icon" href="/sistemackc/views/Img/ImgIcones/crash_icon.ico" type="image/x-icon">

    <script defer src="/sistemackc/views/Js/nav.js"></script>
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
                        <a href="#" class="dropdown-toggle">Menu<i class="ph ph-caret-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="/sistemackc/admtm85/usuario">Usuários</a></li>
                            <li><a href="/sistemackc/admtm85/corrida">Corridas</a></li>
                            <li><a href="/sistemackc/admtm85/campeonato">Campeonatos</a></li>
                            <li><a href="/sistemackc/admtm85/resultado">Resultados</a></li>
                            <li><a href="/sistemackc/admtm85/kartodromo">Kartódromos</a></li>
                        </ul>
                    </li>
                    
                    <li class="drop-down">
                        <?php
                        if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
                            echo "<a href='#' class='dropdown-toggle'>Olá, " . $_SESSION['nome'] . "<i class='ph ph-caret-down'></i></a>";
                            echo "<ul class='dropdown-menu'>";
                            echo "<li><a href='/sistemackc/usuario/{$_SESSION['id']}'>Perfil</a></li>";
                            echo "<li><a href='/sistemackc/admtm85/menu'>Menu</a></li>";
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
        <?php
        if (isset($feedback) && !empty($feedback)) {
            echo "<div class='container-feedback'>";
            if ($classe == 'erro') {
                echo "<span class='$classe'><i class='ph ph-warning-circle'></i><strong>$feedback</strong></span>";
            }
            echo "</div>";
        } else {
        ?>

        <div class="background-image"></div>
        <h1 class="titulo">Confirmar Exclusão</h1>
        <div class="containerInformacoes">
            <div class="containerImagem">
                <img class="fundoImg" src="/sistemackc/Views/Img/ImgTelas/fundo.png" alt="fundo da foto do Crash">
                <img class="imagem" src="/sistemackc/Views/Img/ImgTelas/crash.png" alt="foto do Crash">
            </div>
            <div class="informacoesCorrida">
                <div class="title">
                    <span><?php echo $dadosCorrida['Nome_Campeonato']; ?></span>
                </div>
                <?php $classeH2 = strtolower($nomeAbreviado) . $dadosCorrida['Categoria']; ?>
                <h2>
                    <strong class="<?php echo $classeH2; ?>"><?php echo strtoupper($nomeAbreviado) ?></strong>
                    <?php echo $dadosCorrida['Nome']; ?>
                </h2>
                <div class="date">
                    <span><?php echo date('d/m/Y', strtotime($dadosCorrida['Data_corrida'])); ?></span>
                </div>
                <div class="categoria">
                    <span class="categoria <?php echo 'cat' . $dadosCorrida['Categoria']; ?>">
                        <?php 
                        if ($dadosCorrida['Categoria'] == "Livre") {
                            echo $dadosCorrida['Categoria'];
                        } else {
                            echo $dadosCorrida['Categoria'] . " kg";
                        }
                        ?>
                    </span>
                </div>
            </div>
        </div>
    
        <form action="" method="post">
            <div class="ranking-container">
                <p><i class='ph ph-warning-circle'></i>Você tem certeza que deseja excluir todos os resultados do <strong><?php echo $dadosCorrida['Nome_Campeonato'] . " - " . $dadosCorrida['Nome'] ?></strong>?</p>
                <?php
                foreach ($dadosResultado as $resultado) :
                    $usuario = $usuarioModel->consultarUsuarioPorId($resultado['Usuario_id']);
                    $nome = $usuario['Nome'];
                    $sobrenome = $usuario['Sobrenome'];
                    $foto = $usuario['Foto'] != NULL ? $usuario['Foto'] : 'perfil_branco.png';
                ?>
                    <div class="pilot">
                        <div class="pilot-img-container">
                            <img class="pilot-img" src="/sistemackc/views/Img/ImgUsuario/<?php echo $foto; ?>" alt="<?php echo $nome . ' ' . $sobrenome; ?>">
                        </div>
                        <div class="pilot-info posicao<?php echo $resultado['Posicao']; ?>">
                            <span class="posicaoPiloto"><?php echo $resultado['Posicao']; ?>º</span>
                            <span class="nomePiloto"><?php echo $nome . ' ' . $sobrenome; ?></span>
                            <span><?php echo $resultado['Melhor_tempo']; ?></span>
                            <span><?php echo $resultado['Pontuacao_total']; ?> pts</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="botoes">
                <a class='btn-editar' href='/sistemackc/admtm85/resultado/'>Cancelar</a>
                <button type='submit' class='btn-danger'>Excluir</button>
            </div>
        </form>
        <?php 
        }} else {
            echo "<h1>Acesso não autorizado</h1>";
        }
        ?>
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
            <span class="copyright">2024 Manas Code | Todos os direitos reservados</span>
        </div>
    </footer>
</body>
</html>
