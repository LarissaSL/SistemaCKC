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

    <title>Menu</title>
</head>

<body>
    <header>
        <?php
        session_start();
        if (isset($_SESSION['username']) && $_SESSION['username'] === 'admtm85') {
        ?>
            <!-- Inicio do Conteúdo para o ADM -->
            <nav>
                <i class="ph ph-list"></i><!-- ícone de menu -->
                <ul>
                    <li><a href="/sistemackc/admtm85/menu"><img src="../views/Img/ImgSistema/logoCKC.png" alt="logo do CKC"></a></li>
                    <li><a href="/sistemackc/admtm85/usuario">Usuarios</a></li>
                    <li><a href="#">Corridas</a></li>
                    <li><a href="#">Kartodromos</a></li>
                    <li><a href="#">Resultados</a></li>

                    <li>
                        <?php
                        if (isset($_SESSION['username'])) {
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

            <h1>Menu</h1>
            <div class="Image-Text">
                <img src="#" alt="piloto do ckc em seu kart">
            </div>

    </main>
    <!-- Fim do Conteúdo para o ADM -->

    <!-- Caso um usuário normal tente entrar na rota do ADM -->
        <?php
            } else {
                echo "<h1>Acesso não autorizado</h1>";
            } 
        ?>

    <footer>
        <p>© Manas code</p>
    </footer>
</body>

</html>