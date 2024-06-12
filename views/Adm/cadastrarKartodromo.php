<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">

    <link rel="icon" href="/sistemackc/views/Img/ImgIcones/crash_icon.ico" type="image/x-icon">

    <script src="https://unpkg.com/@phosphor-icons/web"></script> <!-- ONDE PEGUEI OS ICON TEMPORARIOS 'phosphor-icons' -->
    <script defer src="/sistemackc/views/Js/nav.js"></script> <!-- O atributo "defer" serve para que o script roda depois do html -->
    <script src="/sistemackc/views/Js/fotos.js"></script>


    <script defer src="/sistemackc/views/Js/notificacao.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/sistemackc/views/Css/CssUsuario/notificacoes.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/variaveis.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/CssAdm/crudKartodromo.css">

    <title>Cadastrar Kartódromo</title>
</head>

<body>

    <?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
    ?>
        <header class="header">
            <nav class="nav">
                <a class="logo" href="/sistemackc/"><img src="/sistemackc/views/Img/ImgSistema/logoCKC.png" alt="logo do CKC"></a>

                <button class="hamburger"></button>
                <ul class="nav-list">
                    <li><a href="/sistemackc/admtm85/usuario">Usuarios</a></li>
                    <li><a href="/sistemackc/admtm85/campeonato">Campeonatos</a></li>
                    <li><a href="/sistemackc/admtm85/corrida">Corridas</a></li>
                    <li><a href="/sistemackc/admtm85/resultado">Resultados</a></li>
                    <li><a href="/sistemackc/admtm85/kartodromo">Kartodromos</a></li>

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

        <main class="container-conteudo">
            <div class="background-image"></div>
            <div id="bt-go-back">
                <a class="bt-voltar" href="/sistemackc/admtm85/kartodromo/"><i class="ph ph-caret-left"></i>Voltar</a>
            </div>
            <h1 class="titulo">Cadastrar Novo Kartódromo</h1>


            <?php
            if (isset($feedback) && $feedback != '') {
                echo "<div class='container-feedback'>";
                if ($classe == 'erro') {
                    echo '
                        <div class="nofifications">
                            <div class="toast alerta">
                                <div class="column">
                                    <i class="ph-fill ph-warning"></i><!--icone de exclamação-->
                                    <span class="' . $classe . '">' . $feedback . '</span>
                                </div>
                                <i class="ph ph-x" onclick="(this.parentElement).remove()"></i><!--iconde de X -->
                            </div>
                        </div>';
                } else {
                    echo '
                        <div class="nofifications">
                            <div class="toast alerta">
                                <div class="column">
                                    <i class="ph-fill ph-warning"></i><!--icone de exclamação-->
                                    <span class="' . $classe . '">' . $feedback . '</span>
                                </div>
                                <i class="ph ph-x" onclick="(this.parentElement).remove()"></i><!--iconde de X -->
                            </div>
                        </div>';
                }
                echo "</div>";
            }
            ?>

            <section class="container-form">
                <form action='/sistemackc/admtm85/kartodromo/cadastrar' method='POST' enctype='multipart/form-data'>
                    <div class="campo-foto">
                        <div class="container-foto">
                            <input class="input-foto" type="file" id="foto" name="foto" onchange="atualizarTextoComFeedback(this)">
                            <label class="input-label" for="foto">
                                <i class="ph ph-upload-simple"></i>
                                <p class="chamada-foto" id="fotoTexto">Clique aqui para enviar a foto do <strong>Kartódromo</strong></p>
                            </label>
                        </div>
                    </div>

                    <div class="campos">
                        <div class="divisao">
                            <div class="campo">
                                <label for="nome">Nome:</label>
                                <input type="text" id="nome" name="nome" value="<?php echo isset($dados[0]) ? $dados[0] : ''; ?>" required>
                            </div>

                            <div class="campo">
                                <label for="cep">CEP:</label>
                                <input type="text" id="cep" name="cep" value="<?php echo isset($dados[1]) ? $dados[1] : ''; ?>" required>
                            </div>

                            <div class="campo">
                                <label for="rua">Rua:</label>
                                <input type="text" id="rua" name="rua" value="<?php echo isset($dados[2]) ? $dados[2] : ''; ?>" required>
                            </div>


                        </div>

                        <div class="divisao">
                            <div class="campo">
                                <label for="bairro">Bairro:</label>
                                <input type="text" id="bairro" name="bairro" value="<?php echo isset($dados[3]) ? $dados[3] : ''; ?>" required>
                            </div>

                            <div class="campo">
                                <label for="numero">Número:</label>
                                <input type="text" id="numero" name="numero" value="<?php echo isset($dados[4]) ? $dados[4] : ''; ?>" required>
                            </div>

                            <div class="campo">
                                <label for="redes">Redes:</label>
                                <input type="text" id="redes" name="redes" value="<?php echo isset($dados[5]) ? $dados[5] : ''; ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="botao">
                        <button class="bt-cadastrar" type="submit" class="bt-cadastrar">Cadastrar</button>
                    </div>
                </form>
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
        <script src="/sistemackc/views/Js/apiViaCep.js"></script>

    <?php } else { ?>
        <div class="containerAcesso">
            <h1>Acesso não autorizado<i class="ph-fill ph-warning"></i></h1>
            <p>Apenas administradores do Sistema tem acesso</p>
        </div>
    <?php } ?>
</body>

</html>