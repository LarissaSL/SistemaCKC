<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="/views/Js/nav.js"></script> <!-- O atributo "defer" serve para que o script rode depois do HTML -->

    <link rel="stylesheet" href="/sistemackc/views/Css/variaveis.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/cadastro.css">

    <title>Senha</title>
</head>

<body>
    <header>
        <nav>
            <i class="ph ph-list"></i><!-- ícone de menu -->
            <ul>
                <li><a href="/sistemackc/"><img src="/sistemackc/views/Img/ImgSistema/logoCKC.png" alt="logo do CKC"></a></li>

                <li><a href="#">História</a></li>
                <li>
                    <a href="#">Corridas</a>
                    <ul class="drop-corrida">
                        <li><a href="#">Etapas</a></li>
                        <li><a href="#">Classificação</a></li>
                        <li><a href="#">Galeria</a></li>
                        <li><a href="#">Inscrição</a></li>
                        <li><a href="#">Regulamento</a></li>
                        <li><a href="/sistemackc/kartodromo">Kartódromo</a></li>
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
                    } elseif (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
                        echo "<p>Olá, " . $_SESSION['nome'] . "</p>";
                        echo "<ul class='drop-corrida'>";
                        echo "<li><a href='/sistemackc/usuario/{$_SESSION['id']}'>Perfil</a></li>";
                        echo "<li><a href='/sistemackc/admtm85/menu'>Dashboard</a></li>";
                        echo "<li><a href='/sistemackc/logout'>Logout</a></li>";
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
