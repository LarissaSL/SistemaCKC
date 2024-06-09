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
    <link rel="stylesheet" href="/sistemackc/views/Css/CssUsuario/perfil.css">

    <script src="https://unpkg.com/@phosphor-icons/web"></script> <!-- ONDE PEGUEI OS ICON TEMPORARIOS 'phosphor-icons' -->
    <script defer src="/sistemackc/views/Js/nav.js"></script> <!-- O atributo "defer" serve para que o script roda depois do html -->

    <link rel="icon" href="/sistemackc/views/Img/ImgIcones/crash_icon.ico" type="image/x-icon">

    <title>Perfil</title>
</head>

<body>
    <?php
    if (!isset($_SESSION)) {
        session_start();
    }

    if (strpos($_SERVER['REQUEST_URI'], 'admtm85') !== false && ($_SESSION['tipo'] !== 'Administrador')) {
        echo "<h1>Acesso não autorizado</h1>";
    } else {
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
        <main class="container-conteudo">
            <div class="background-imagePerfilUser"></div>
            <div id="bt-go-back">
                <?php
                if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
                    echo "<a href='/sistemackc/admtm85/usuario'><i class='ph ph-caret-left'></i>Voltar</a>";
                } else {
                    echo "<a href='/sistemackc/'><i class='ph ph-caret-left'></i></a>";
                }
                ?>
            </div>

            <h1 class="titulo">Perfil</h1>

            <?php if (isset($feedbackSobrePerfil)) : ?>
                <p><?php echo $feedbackSobrePerfil; ?></p>
            <?php else : ?>
                <h2 class="subtitulo">Perfil do Usuário ID: <?php echo $usuario['Id']; ?></h2>
                <?php $dataFormatada = date('d-m-Y', strtotime($usuario['Data_nascimento'])); ?>

                <section class="container-form">
                    <!-- Se o Usuário tiver foto ela irá aparecer -->
                    <?php
                    $foto = $usuario['Foto'] != NULL ? $usuario['Foto'] : 'perfil_escuro.png'; ?>
                    <div class="containerFotoPerfil">
                        <div class="imagem">
                            <img src="/sistemackc/views/Img/ImgUsuario/<?php echo $foto ?>" alt="Foto de <?php echo $usuario['Nome']; ?>">
                        </div>


                        <!-- Se o Usuário Logado for o mesmo do ID ele pode trocar sua foto de perfil -->
                        <?php
                        if (isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email'] || isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
                            if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
                                echo "<form action='/sistemackc/admtm85/usuario/atualizar/{$usuario['Id']}' method='POST' enctype='multipart/form-data'>";
                            } else {
                                echo "<form action='/sistemackc/usuario/atualizar/{$usuario['Id']}' method='POST' enctype='multipart/form-data'>";
                            }
                        ?>
                            <div class="container">
                                <label for="fotoPerfil">
                                    <?php
                                    if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
                                        echo "Atualizar foto de Perfil do Usuário";
                                    } else {
                                        echo "Atualizar sua foto de perfil:";
                                    }
                                    echo "</label>";
                                    if ((isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador')) {
                                        echo "<input type='file' id='foto' name='foto' class='inputFotoComum'>";
                                    }
                                    ?>
                            </div>
                </section>



                <!-- Aqui exibe os feedbacks -->
                <?php
                            if (isset($feedback) && $feedback != '') {
                                echo "<div class='container-feedback'>";
                                if ($classe == 'erro') {
                                    echo "<span class='$classe'><i class='ph ph-warning-circle'></i><strong>$feedback</strong></span>";
                                } else {
                                    echo "<span class='$classe'><i class='ph ph-check-square'></i><strong>$feedback</strong></span>";
                                }
                                echo "</div>";
                            }
                ?>
            <?php } ?>

            <div class="campos">
                <div class="divisao">
                    <div class="campo">
                        <label class="nome" for="nome">Nome:</label>
                        <input type="text" name="nome" value="<?php echo $usuario['Nome'] ?>" <?php echo (isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') ? '' : 'readonly'; ?>>
                    </div>

                    <div class="campo">
                        <label class="sobrenome" for="sobrenome">Sobrenome:</label>
                        <input type="text" name="sobrenome" value="<?php echo $usuario['Sobrenome'] ?>" <?php echo (isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') ? '' : 'readonly'; ?>>
                    </div>

                    <?php
                    // Se o usuário é o dono do perfil ou um adm, exibe o campo de data de nascimento
                    if ((isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador')) { ?>
                        <div class="campo">
                            <label class="dataNascimento" for="dataNascimento">Data de Nascimento:</label>
                            <input type="text" name="dataNascimento" value="<?php echo $dataFormatada ?>">
                        </div>
                    <?php
                        // Se nao , mostra a idade do piloto
                    } else {
                        $dataNascimento = new DateTime($dataFormatada);
                        $hoje = new DateTime();
                        $idade = $hoje->diff($dataNascimento)->y;
                    ?>
                        <div class="campo">
                            <label class="dataNascimento" for="dataNascimento">Idade:</label>
                            <input type="text" name="idade" value="<?php echo $idade . ' anos' ?>" readonly>
                        </div>
                    <?php } ?>


                    <?php if ((isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador')) : ?>
                        <div class="genero">
                            <input type="radio" value="Masculino" name="genero" <?php echo $usuario['Genero'] == 'Masculino' ? 'checked' : ''; ?>>
                            <label class="homem" for="homem">Masculino</label>

                            <input type="radio" value="Feminino" name="genero" <?php echo $usuario['Genero'] == 'Feminino' ? 'checked' : ''; ?>>
                            <label class="mulher" for="mulher">Feminino</label>

                            <input type="radio" value="Outro" name="genero" <?php echo $usuario['Genero'] == 'Outro' ? 'checked' : ''; ?>>
                            <label class="outro" for="outro">Outro</label>
                        <?php else : ?>
                            <div class="campo">
                                <label>Gênero</label>
                                <input type="text" value="<?php echo $usuario['Genero']; ?> " name="genero" <?php echo (isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') ? '' : 'readonly'; ?>>
                            <?php endif; ?>
                            </div>

                            <!-- FALTA ESTILO NESSE AQUI, Parte que o ADM escolhe o tipo de Usuário  -->
                            <?php if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') : ?>
                                <div class="dataNascimento">
                                    <select name="tipo" id="tipo">
                                        <option value="Comum" <?php echo $usuario['Tipo'] == 'Comum' ? 'selected' : ''; ?>>Comum</option>
                                        <option value="Administrador" <?php echo $usuario['Tipo'] == 'Administrador' ? 'selected' : ''; ?>>Administrador</option>
                                    </select>
                                </div>
                            <?php endif ?>
                        </div>

                        <div class="divisao">
                            <?php if ((isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador')) : ?>
                                <div class="campo">
                                    <label class="cpf" for="cpf">CPF:</label>
                                    <input type="text" name="cpf" value="<?php echo $usuario['Cpf'] ?>" readonly>
                                </div>
                            <?php endif ?>

                            <div class="campo">
                                <label class="telefone" for="telefone">Celular:</label>
                                <input type="text" name="telefone" value="<?php echo $usuario['Telefone'] ?>" <?php echo (isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') ? '' : 'readonly'; ?>>
                            </div>

                            <div class="campo">
                                <label class="peso" for="peso">Peso:</label>
                                <input type="number" name="peso" value="<?php echo $usuario['Peso'] ?>" <?php echo (isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') ? '' : 'readonly'; ?>>
                            </div>

                            <div class="campo">
                                <label class="email" for="email">E-mail:</label>
                                <input type="text" name="email" value="<?php echo $usuario['Email'] ?>" <?php echo (isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') ? '' : 'readonly'; ?>>
                            </div>
                        </div>
                </div>
                <?php if (isset($_SESSION['email']) && ($_SESSION['email'] == $usuario['Email'] || $_SESSION['tipo'] == 'Administrador')) : ?>
                    <?php $url = ($_SESSION['tipo'] === 'Administrador') ? '/sistemackc/admtm85/usuario/atualizar/senha/' . $usuario['Id'] : '/sistemackc/usuario/atualizar/senha/' . $usuario['Id']; ?>

                    <div class="botao">
                        <button type="submit" class="bt-atualizar">Atualizar</button>
                        <a class="bt-alterar" href="<?php echo $url; ?>">Alterar senha</a>
                    </div>
                <?php endif; ?>
            </div>
            </form>
        <?php endif; ?>

    <?php } ?>
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
</body>

</html>