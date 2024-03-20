<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>  <!-- ONDE PEGUEI OS ICON TEMPORARIOS 'phosphor-icons' -->

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
                <li><a href="/sistemackc/"><img src="../views/Img/ImgSistema/logoCKC.png" alt="logo do CKC"></a></li>
                <li><a href="#">Usuarios</a></li>
                <li><a href="#">Corridas</a></li>
                <li><a href="#">Kartodromos</a></li>
                <li><a href="#">Resultados</a></li>
            
                <li>
                    <?php
                    session_start();
                    if(isset($_SESSION['username'])) {
                        echo "<p>Olá, " . $_SESSION['username'] . "</p>";
                        echo "<ul><li><a href='/sistemackc/logout'>Logout</a></li>";
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

        <!-- titulo e imagem principal -->
        <div class="Image-Text">
            <h2>Acesso administrativo</h2>
            <img src="#" alt="piloto do ckc em seu kart">
        </div>

            <?php if(isset($feedback)) : ?>
                <p class="<?php echo $classe ?>"><?php echo $feedback ?></p>
            <?php endif ?>

            <!-- formulario -->
            <form action="login" method="post">
                <!--caixa de Email -->
                <div class="emails">
                    <label class="username" for="username">Username:</label>
                    <input type="text" name="username">
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