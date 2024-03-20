<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@phosphor-icons/web"></script> <!-- ONDE PEGUEI OS ICON TEMPORARIOS 'phosphor-icons' -->

    <link rel="stylesheet" href="../views/Css/variaveis.css">
    <link rel="stylesheet" href="../views/Css/styleGlobal.css">
    <link rel="stylesheet" href="../views/Css/login.css">

    <title>Login</title>
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
                    if (isset($_SESSION['nome'])) {
                        echo "<p>Olá, " . $_SESSION['nome'] . "</p>";
                        echo "<ul class='drop-corrida'>";
                        echo "<li><a href='./usuario/{$_SESSION['id']}'>Perfil</a></li>";
                        echo "<li><a href='/sistemackc/logout'>Logout</a></li>";
                        echo "</ul>";
                    } else {
                        echo "<a href='#'>Entrar</a>";
                    }
                    ?>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="container">
            <!-- botão de voltar -->
            <div id="bt-go-back">
                <a href="/sistemackc/"><i class="ph ph-caret-left"></i>Voltar</a> <!--tag 'a' com o icone de seta '<' -->
            </div>

            <!-- titulo e imagem principal -->
            <div class="Image-Text">
                <h2>Cadastre-se e faça parte da comunidade CKC Kart</h2>
                <img src="#" alt="piloto do ckc em seu kart">
            </div>

            <?php if (isset($feedback)) : ?>
                <p class="<?php echo $classe ?>"><?php echo $feedback ?></p>
            <?php endif ?>
            <!-- formulario -->
            <form action="login" method="post">
                <!--caixa de Email -->
                <div class="emails">
                    <label class="email" for="email">E-mail:</label>
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

            <a href="./cadastro" class="bt-cadastre">Cadastrar</a>
        </section>
    </main>

    <footer>
        <p>© Manas code</p>
    </footer>
</body>

</html>