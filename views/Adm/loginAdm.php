<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@phosphor-icons/web"></script> <!-- ONDE PEGUEI OS ICON TEMPORARIOS 'phosphor-icons' -->

    <link rel="stylesheet" href="/sistemackc/views/Css/variaveis.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/styleGlobal.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/login.css">

    <title>Login</title>
</head>

<body>
    <header>
        <nav>
            <i class="ph ph-list"></i><!-- ícone de menu -->
            <ul>
                <li><a href="/sistemackc/"><img src="../views/Img/ImgSistema/logoCKC.png" alt="logo do CKC"></a></li>
                <li><a href="#">Usuarios</a></li>
                <li><a href="#">Corridas</a></li>
                <li><a href="/sistemackc/admtm85/kartodromo">Kartodromos</a></li>
                <li><a href="#">Resultados</a></li>

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
                        echo "<a href='sistemackc/usuario/login'>Entrar</a>";
                    }
                    ?>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="container">

            <!-- titulo e imagem principal -->
            <div class="Image-Text">
                <h2>Acesso administrativo</h2>
                <img src="#" alt="piloto do ckc em seu kart">
            </div>

            <?php if (isset($feedback)) : ?>
                <p class="<?php echo $classe ?>"><?php echo $feedback ?></p>
            <?php endif ?>

            <!-- formulario -->
            <form action="login" method="post">
                <!--caixa de Email -->
                <div class="emails">
                    <label class="email" for="email">Email:</label>
                    <input type="text" name="email">
                </div>

                <!--caixa de Senha -->
                <div class="passwords">
                    <label class="password" for="senha">Senha:</label>
                    <input type="password" name="senha">

                    <a href="#">Esqueci minha senha</a>
                </div>

                <button class="bt-go-in">Entrar</button>
            </form>
        </section>
    </main>

    <footer>
        <p>© Manas code</p>
    </footer>
</body>

</html>