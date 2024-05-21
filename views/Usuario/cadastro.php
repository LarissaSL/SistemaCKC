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
    <link rel="stylesheet" href="/sistemackc/views/Css/cadastro.css">

    <link rel="icon" href="/sistemackc/views/Img/ImgIcones/crash_icon.ico" type="image/x-icon">

    <script src="https://unpkg.com/@phosphor-icons/web"></script> <!-- ONDE PEGUEI OS ICON TEMPORARIOS 'phosphor-icons' -->
    <script defer src="/sistemackc/views/Js/nav.js"></script> <!-- O atributo "defer" serve para que o script roda depois do html -->
    <script src="/sistemackc/views/Js/validarcpf.js"></script>
    <title>Cadastro</title>
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
        <div class="background-image"></div>
        <div id="bt-voltar">
            <a href="/sistemackc/"><i class="ph ph-caret-left"></i></a>
        </div>
        <section class="container">
            <div class="titulo">
                <h1>Cadastro</h1>
            </div>

            <?php
                if (isset($feedback) && $feedback != '') {
                    echo "<div class='container-feedback'>";
                    if($classe == 'erro'){
                        echo "<span class='$classe'><i class='ph ph-warning-circle'></i><strong>$feedback</strong></span>";
                    } else {
                        echo "<span class='$classe'><i class='ph ph-check-square'></i><strong>$feedback</strong></span>";
                    }
                    echo "</div>";
                }
            ?>


            <?php if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
                echo "<form action='/sistemackc/admtm85/usuario/cadastrar' class='form' method='POST'>";
            } else {
                echo "<form action='/sistemackc/usuario/cadastro' class='form' method='POST'>";
            } ?>

            <div class="nome">
                <label class="nome" for="nome">Nome:</label>
                <input type="text" name="nome" value="<?php echo isset($dados[0]) ? $dados[0] : ''; ?>" required>
            </div>

            <div class="sobrenome">
                <label class="sobrenome" for="sobrenome">Sobrenome:</label>
                <input type="text" name="sobrenome" value="<?php echo isset($dados[1]) ? $dados[1] : ''; ?>" required>
            </div>

            <div class="dataNascimento">
                <label class="dataNascimento" for="dataNascimento">Data de Nascimento:</label>
                <input type="date" name="dataNascimento" value="<?php echo isset($dados[2]) ? $dados[2] : ''; ?>" required>
            </div>


            <!-- FALTA ESTILO NESSE AQUI, Parte que o ADM escolhe o tipo de Usuário  -->
            <?php if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') : ?>
            <div class="dataNascimento">
                <select name="tipo" id="tipo">
                    <option value="Comum" selected>Comum</option>
                    <option value="Administrador">Administrador</option>
                </select>
            </div>
            <?php endif ?>

            <div class="genero">
                <label class="escolha" for="genero">Gênero:</label>
                <input type="radio" value="Masculino" name="genero" <?php echo isset($dados[9]) && $dados[9] == 'Masculino' ? 'checked' : ''; ?>>
                <label class="homem" for="homem">Masculino</label>

                <input type="radio" value="Feminino" name="genero" <?php echo isset($dados[9]) && $dados[9] == 'Feminino' ? 'checked' : ''; ?>>
                <label class="mulher" for="mulher">Feminino</label>

                <input type="radio" value="Outro" name="genero" <?php echo isset($dados[9]) && $dados[9] == 'Outro' ? 'checked' : ''; ?>>
                <label class="outro" for="outro">Outro</label>
            </div>

            <div class="cpf">
                <label class="cpf" for="cpf">CPF:</label>
                <input type="text" name="cpf" id="cpf" value="<?php echo isset($dados[3]) ? $dados[3] : ''; ?>" required>
                <span id="cpfError" style="color: red;"></span>
            </div>

            <div class="telefone">
                <label class="telefone" for="telefone">Celular:</label>
                <input type="text" name="telefone" value="<?php echo isset($dados[10]) ? $dados[10] : ''; ?>" required>
            </div>

            <div class="peso">
                <label class="peso" for="peso">Peso:</label>
                <input type="number" name="peso" value="<?php echo isset($dados[8]) ? $dados[8] : ''; ?>" required>
            </div>

            <div class="email">
                <label class="email" for="email">E-mail:</label>
                <input type="text" name="email" value="<?php echo isset($dados[4]) ? $dados[4] : ''; ?>" required>
            </div>

            <div class="confirmaEmail">
                <label class="email" for="email">Confirmação de E-mail:</label>
                <input type="text" name="confirmarEmail" value="<?php echo isset($dados[5]) ? $dados[5] : ''; ?>" required>
            </div>

            <div class="senha">
                <label class="senha" for="senha">Senha:</label>
                <input type="password" name="senha" value="<?php echo isset($dados[6]) ? $dados[6] : ''; ?>" required>
            </div>

            <div class="confirmaSenha">
                <label class="senha" for="senha">Confirmação de Senha:</label>
                <input type="password" name="confirmarSenha" value="<?php echo isset($dados[7]) ? $dados[7] : ''; ?>" required>
            </div>

            <button type="submit" class="bt-cadastrar">Cadastrar</button>
            </form>
        </section>
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

