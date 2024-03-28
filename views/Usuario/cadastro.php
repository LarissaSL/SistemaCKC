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
    <script defer src="/views/Js/nav.js"></script> <!-- O atributo "defer" serve para que o script roda depois do html -->

    <link rel="stylesheet" href="/sistemackc/views/Css/variaveis.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/cadastro.css">

    <title>Cadastro</title>
</head>

<body>
    <header class="header">
        <nav class="nav">
            <a class="logo" href="/sistemackc/"><img src="/sistemackc/views/Img/ImgSistema/logoCKC.png" alt="logo do CKC"></a>

            <button class="hamburger"></button>
            <ul class="nav-list">
                <li><a href="#">História</a></li>

                <li class="drop-down">
                    <a href="#" class="dropdown-toggle">Corridas<i class="ph ph-caret-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Etapas</a></li>
                        <li><a href="#">Classificação</a></li>
                        <li><a href="#">Galeria</a></li>
                        <li><a href="#">Inscrição</a></li>
                        <li><a href="#">Regulamento</a></li>
                        <li><a href="/sistemackc/kartodromo">Kartódromos</a></li>
                    </ul>
                </li>
                <!-- Decidindo tipo de opções do Usuário Logado (COMUM ou ADM) -->
                <li>
                    <?php
                    if (!isset($_SESSION)) {
                        session_start();
                    }
                    if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Comum') {
                        echo "<p>Olá, " . $_SESSION['nome'] . "</p>";
                        echo "<ul class='drop-corrida'>";
                        echo "<li><a href='/sistemackc/usuario/{$_SESSION['id']}'>Perfil</a></li>";
                        echo "<li><a href='/sistemackc/logout'>Logout</a></li>";
                        echo "</ul>";
                    } elseif (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
                        echo "<p>Olá, " . $_SESSION['nome'] . "</p>";
                        echo "<ul class='drop-corrida'>";
                        echo "<li><a href='/sistemackc/usuario/{$_SESSION['id']}'>Perfil</a></li>";
                        echo "<li><a href='/sistemackc/admtm85/menu'>Dashboard</a></li>";
                        echo "<li><a href='/sistemackc/logout'>Logout</a></li>";
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
        <div id="bt-voltar">
            <a href="/sistemackc/"><i class="ph ph-caret-left"></i>Voltar</a>
        </div>
        <section class="container">
            <div class="titulo">
                <h1>Cadastro</h1>
            </div>

            <?php if (isset($feedback)) : ?>
                <p class="<?php echo $status ?>"><?php echo $feedback; ?></p>
            <?php endif; ?>


            <?php if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
                echo "<form action='/sistemackc/admtm85/usuario/cadastrar' class='form' method='POST'>";
            } else {
                echo "<form action='/sistemackc/usuario/cadastro' class='form' method='POST'>";
            } ?>

            <div class="nome">
                <label class="nome" for="nome">Nome:</label>
                <input type="text" name="nome" value="<?php echo isset($dados) ? $dados[0] : ''; ?>" required>
            </div>

            <div class="sobrenome">
                <label class="sobrenome" for="sobrenome">Sobrenome:</label>
                <input type="text" name="sobrenome" value="<?php echo isset($dados) ? $dados[1] : ''; ?>" required>
            </div>

            <div class="dataNascimento">
                <label class="dataNascimento" for="dataNascimento">Data de Nascimento:</label>
                <input type="date" name="dataNascimento" required>
            </div>

            <div class="genero">
                <label class="escolha" for="genero">Gênero:</label>
                <input type="radio" value="Masculino" name="genero" <?php echo isset($dados) && $dados[8] == 'Masculino' ? 'checked' : ''; ?>>
                <label class="homem" for="homem">Masculino</label>

                <input type="radio" value="Feminino" name="genero" <?php echo isset($dados) && $dados[8] == 'Feminino' ? 'checked' : ''; ?>>
                <label class="mulher" for="mulher">Feminino</label>

                <input type="radio" value="Outro" name="genero" <?php echo isset($dados) && $dados[8] == 'Outro' ? 'checked' : ''; ?>>
                <label class="outro" for="outro">Outro</label>
            </div>

            <div class="cpf">
                <label class="cpf" for="cpf">CPF:</label>
                <input type="text" name="cpf" value="<?php echo isset($dados) ? $dados[2] : ''; ?>" required>
            </div>

            <div class="telefone">
                <label class="telefone" for="telefone">Celular:</label>
                <input type="text" name="telefone" value="<?php echo isset($dados) ? $dados[9] : ''; ?>" required>
            </div>

            <div class="peso">
                <label class="peso" for="peso">Peso:</label>
                <input type="number" name="peso" value="<?php echo isset($dados) ? $dados[7] : ''; ?>" required>
            </div>

            <div class="email">
                <label class="email" for="email">E-mail:</label>
                <input type="text" name="email" value="<?php echo isset($dados) ? $dados[3] : ''; ?>" required>
            </div>

            <div class="confirmaEmail">
                <label class="email" for="email">Confirmação de E-mail:</label>
                <input type="text" name="confirmarEmail" value="<?php echo isset($dados) ? $dados[4] : ''; ?>" required>
            </div>

            <div class="senha">
                <label class="senha" for="senha">Senha:</label>
                <input type="password" name="senha" value="<?php echo isset($dados) ? $dados[5] : ''; ?>" required>
            </div>

            <div class="confirmaSenha">
                <label class="senha" for="senha">Confirmação de Senha:</label>
                <input type="password" name="confirmarSenha" value="<?php echo isset($dados) ? $dados[6] : ''; ?>" required>
            </div>

            <button type="submit" class="bt-cadastrar">Cadastrar</button>
            </form>
        </section>
    </main>
    <footer>
        <p>© Manas code</p>
    </footer>
</body>

</html>