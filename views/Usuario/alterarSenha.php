<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- google fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <!-- ícone de menu  -->
    <link rel="stylesheet" href="/sistemackc/views/Css/variaveis.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/crudUsuario.css">

    <script src="https://unpkg.com/@phosphor-icons/web"></script> <!-- ONDE PEGUEI OS ICON TEMPORARIOS 'phosphor-icons' -->
    <script defer src="/sistemackc/views/Js/nav.js"></script> <!-- O atributo "defer" serve para que o script roda depois do html -->

    <title>Senha</title>
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
                <li>
                    <?php
                    session_start();
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

    <!-- Conteúdo da página -->
    <?php
    if (isset($_SESSION['tipo'])) {
        $tipoUsuario = $_SESSION['tipo'];
    } else {
        $tipoUsuario = null;
    }


    if (!isset($usuario)) {
        echo "<h1>Usuário não encontrado</h1>";
        exit;
    }


    if ((isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || $tipoUsuario == 'Administrador') {
    ?>
        <h1>Alterar senha</h1>
        <p>Por motivos de segurança, não exibimos a senha do usuário. Se deseja alterá-la, preencha o campo abaixo:</p>

        <?php if (isset($_SESSION['tipo']) && $tipoUsuario == 'Administrador') {
            echo "<form action='/sistemackc/admtm85/usuario/atualizar/senha/{$usuario['Id']}' method='POST'>";
        } else {
            echo "<form action='/sistemackc/usuario/atualizar/senha/{$usuario['Id']}' method='POST'>";
        } ?>

        <?php if (isset($feedback)) {
            echo "<span class=$status>$feedback</span>";
        } ?>

        <div class="senha">
            <label class="senha" for="senha">Senha:</label>
            <input type="password" name="senha" required>
        </div>

        <div class="confirmaSenha">
            <label class="senha" for="senha">Confirmação de Senha:</label>
            <input type="password" name="confirmarSenha" required>
        </div>

        <button type="submit" class="bt-cadastrar">Alterar</button>
        </form>
    <?php } else {
        echo "<h1>Acesso não autorizado</h1>";
    } ?>

    <div id="bt-go-back">
        <?php
        if ($tipoUsuario == 'Administrador') {
            echo "<a href='/sistemackc/admtm85/usuario/{$usuario['Id']}'><i class='ph ph-caret-left'></i>Voltar</a>";
        } else {
            echo "<a href='/sistemackc/usuario/{$usuario['Id']}'><i class='ph ph-caret-left'></i>Voltar</a>";
        }
        ?>
    </div>

</body>

</html>