<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/sistemackc/views/Css/variaveis.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/cadastro.css">
    <title>Cadastrar Kartódromo</title>
</head>

<body>
<header>
        <nav>
            <i class="ph ph-list"></i><!-- ícone de menu -->
            <ul>
                    <li><a href="/sistemackc/admtm85/menu"><img src="/sistemackc/views/Img/ImgSistema/logoCKC.png" alt="logo do CKC"></a></li>
                    <li><a href="/sistemackc/admtm85/usuario">Usuarios</a></li>
                    <li><a href="#">Corridas</a></li>
                    <li><a href="/sistemackc/admtm85/kartodromo">Kartodromos</a></li>
                    <li><a href="#">Resultados</a></li>
                </li>
                <li>
                    <?php
                        if (!isset($_SESSION)) {
                            session_start();
                        }
                        if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
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
    <?php
    if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
    ?>
        <h1>Cadastrar Novo Kartódromo</h1>

        <?php
        if (isset($feedback)) {
            echo "<span class='$classe'>$feedback</span>";
        }
        ?>

        <form action='/sistemackc/admtm85/kartodromo/cadastrar' method='POST'>
            <label for="nome">Nome:</label><br>
            <input type="text" id="nome" name="nome" required><br><br>

            <label for="cep">CEP:</label><br>
            <input type="text" id="cep" name="cep" required><br><br>

            <label for="rua">Rua:</label><br>
            <input type="text" id="rua" name="rua" required><br><br>

            <label for="bairro">Bairro:</label><br>
            <input type="text" id="bairro" name="bairro" required><br><br>

            <label for="numero">Número:</label><br>
            <input type="text" id="numero" name="numero" required><br><br>

            <label for="site">Site:</label><br>
            <input type="text" id="site" name="site"><br><br>

            <button type="submit" class="bt-cadastrar">Cadastrar</button>
        </form>
        <a href='/sistemackc/admtm85/kartodromo/'><i class='ph ph-caret-left'></i>Voltar</a>

    <?php
    } else {
        echo "<h1>Acesso não autorizado</h1>";
    }
    ?>
</body>
</html>