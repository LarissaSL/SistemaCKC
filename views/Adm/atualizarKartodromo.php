<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/sistemackc/views/Css/variaveis.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/cadastro.css">
    <title>Atualizar Kartódromo</title>
</head>

<body>
    <header>
        <?php
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
        ?>
            <nav>
                <i class="ph ph-list"></i><!-- ícone de menu -->
                <ul>
                    <li><a href="/sistemackc/admtm85/menu"><img src="/sistemackc/views/Img/ImgSistema/logoCKC.png" alt="logo do CKC"></a></li>
                    <li><a href="/sistemackc/admtm85/usuario">Usuarios</a></li>
                    <li><a href="#">Corridas</a></li>
                    <li><a href="/sistemackc/admtm85/kartodromo">Kartodromos</a></li>
                    <li><a href="#">Resultados</a></li>
                    <li>
                        <?php
                        if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
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

    <h1>Atualizar Kartódromo</h1>

    <?php
    if (isset($feedback)) {
        echo "<span class='$classe'>$feedback</span>";
    }
    ?>

    <form action='' method='POST' enctype='multipart/form-data'>
        <label for="foto">Foto:</label><br>
        <!-- Se o kartódromo tiver uma foto -->
        <?php if (!empty($dados[0])) : ?>
            <img src="/sistemackc/views/Img/ImgSistema/<?php echo $dados[0]; ?>" alt="Foto de <?php echo $dados[0]; ?>">
        <?php endif; ?>

        <input type="file" id="foto" name="foto"><br><br>

        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" value="<?php echo isset($dados[1]) ? $dados[1] : ''; ?>" required><br><br>

        <label for="cep">CEP:</label><br>
        <input type="text" id="cep" name="cep" value="<?php echo isset($dados[2]) ? $dados[2] : ''; ?>" required><br><br>

        <label for="rua">Rua:</label><br>
        <input type="text" id="rua" name="rua" value="<?php echo isset($dados[3]) ? $dados[3] : ''; ?>" required><br><br>

        <label for="bairro">Bairro:</label><br>
        <input type="text" id="bairro" name="bairro" value="<?php echo isset($dados[4]) ? $dados[4] : ''; ?>" required><br><br>

        <label for="numero">Número:</label><br>
        <input type="text" id="numero" name="numero" value="<?php echo isset($dados[5]) ? $dados[5] : ''; ?>" required><br><br>

        <label for="site">Site:</label><br>
        <input type="text" id="site" name="site" value="<?php echo isset($dados[6]) ? $dados[6] : ''; ?>" required><br><br>

        <button type="submit" class="bt-cadastrar">Atualizar</button>
    </form>
    <a href='/sistemackc/admtm85/kartodromo/'><i class='ph ph-caret-left'></i>Voltar</a>

    <?php
    } else {
        echo "<h1>Acesso não autorizado</h1>";
    }
    ?>
</body>

</html>
