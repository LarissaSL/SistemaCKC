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

    <link rel="icon" href="/sistemackc/views/Img/ImgIcones/crash_icon.ico" type="image/x-icon">

    <script src="https://unpkg.com/@phosphor-icons/web"></script> <!-- ONDE PEGUEI OS ICON TEMPORARIOS 'phosphor-icons' -->
    <script defer src="/sistemackc/views/Js/nav.js"></script> <!-- O atributo "defer" serve para que o script roda depois do html -->
    <script defer src="/sistemackc/views/Js/notificacao.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/sistemackc/views/Css/CssUsuario/notificacoes.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/variaveis.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/CssAdm/cadastrarCorridas.css">

    <title>Cadastro de Corridas</title>
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


    <h1 class="title">Cadastro de Corridas</h1>
    <?php
            if (isset($feedback) && !empty($feedback) && $classe == "semCadastro") {
                echo "<div class='container-feedback'>";
                if ($classe == 'semCadastro') {
                    echo '
                        <div class="nofifications">
                            <div class="toast success">
                                <div class="column">
                                    <i class="ph-fill ph-warning"></i><!--icone de exclamação-->
                                    <span class="' . $classe . '">' . $feedback . '</span>
                                </div>
                                <i class="ph ph-x" onclick="(this.parentElement).remove()"></i><!--iconde de X -->
                            </div>
                        </div>';
                }
                if (isset($mostrarBotaoCampeonato) && $mostrarBotaoCampeonato) {
                    echo '
                        <div class="nofifications">
                            <div class="toast success">
                                <div class="column">
                                    <i class="ph-fill ph-warning"></i><!--icone de exclamação-->
                                    <span class="' . $classe . '">' . $feedback . '</span>
                                </div>
                                <i class="ph ph-x" onclick="(this.parentElement).remove()"></i><!--iconde de X -->
                            </div>
                        </div>';
                }
                if (isset($mostrarBotaoKartodromo) && $mostrarBotaoKartodromo) {
                    echo '
                        <div class="nofifications">
                            <div class="toast success">
                                <div class="column">
                                    <i class="ph-fill ph-warning"></i><!--icone de exclamação-->
                                    <span class="' . $classe . '">' . $feedback . '</span>
                                </div>
                                <i class="ph ph-x" onclick="(this.parentElement).remove()"></i><!--iconde de X -->
                            </div>
                        </div>';
                }
                echo "</div>";
            } else {
    ?>

        <?php
                if (isset($feedback) && !empty($feedback)) {
                    echo "<div class='container-feedback'>";
                    if ($classe == 'erro') {
                        echo '
                            <div class="nofifications">
                                <div class="toast success">
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
        <div class="background-image"></div>
        <section class="container">
            <form action='/sistemackc/admtm85/corrida/cadastrar' method='POST'>
                <div class="campos">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" value="<?php echo isset($dados[0]) ? $dados[0] : ''; ?>" required>
                </div>

                <div class="campos">
                    <label for="data">Data da corrida:</label>
                    <input type="date" id="data" name="dataCorrida" value="<?php echo isset($dados[6]) ? $dados[6] : ''; ?>" required>
                </div>

                <div class="campos">
                    <label for="campeonato">Campeonato:</label>
                    <select id="campeonato" name="campeonato_id">
                        <?php if (!empty($dados[1])) { ?>
                            <option value="<?php echo $dados[1]; ?>" selected><?php echo $dados[2]; ?></option>
                        <?php } else { ?>
                            <option value="" selected>Selecione um Campeonato</option>
                        <?php }
                        foreach ($dadosCampeonatos as $campeonato) {
                            if ($dados[1] != $campeonato['Id']) {
                                echo "<option value=" . $campeonato['Id'] . ">" . $campeonato['Nome'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="campos">
                    <label for="horario">Horário:</label>
                    <input type="time" id="horario" name="horario" value="<?php echo isset($dados[7]) ? $dados[7] : ''; ?>" required>
                </div>

                <div class="campos">
                    <label for="kartodromo">Kartódromo:</label>
                    <select id="kartodromo" name="kartodromo_id">
                        <?php if (!empty($dados[3])) { ?>
                            <option value="<?php echo $dados[3]; ?>" selected><?php echo $dados[4]; ?></option>
                        <?php } else { ?>
                            <option value="" selected>Selecione um Kartodromo</option>
                        <?php }
                        foreach ($dadosKartodromos as $kartodromo) {
                            if ($dados[3] != $kartodromo['Id']) {
                                echo "<option value=" . $kartodromo['Id'] . ">" . $kartodromo['Nome'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="campos">
                    <label for="tempo_corrida">Tempo da corrida:</label>
                    <input type="time" id="tempo_corrida" name="tempoCorrida" value="<?php echo isset($dados[8]) ? $dados[8] : '00:25'; ?>" required>
                </div>

                <div class="categorias">
                    <label for="categoria">Categoria:</label><br>
                    <div class="categoria-opcoes">

                        <input type="radio" id="categoria95" name="categoria" value="95" <?php echo (isset($dados[5]) && $dados[5] == '95') ? 'checked' : ''; ?> required>
                        <label for="categoria95">95kg</label>
                        <input type="radio" id="categoria110" name="categoria" value="110" <?php echo (isset($dados[5]) && $dados[5] == '110') ? 'checked' : ''; ?> required>
                        <label for="categoria110">110kg</label>
                        <input type="radio" id="categoriaLivre" name="categoria" value="Livre" <?php echo (isset($dados[5]) && $dados[5] == 'Livre') ? 'checked' : ''; ?> required>
                        <label for="categoria110">Livre</label>
                    </div>
                </div>

                <div>
                    <button type="submit">Cadastrar</button>
                </div>
            </form>
        </section>
    <?php } ?>
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
<?php
        } else {
            echo "<h1>Acesso não autorizado</h1>";
        }
?>
</body>

</html>