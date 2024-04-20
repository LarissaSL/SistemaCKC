<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">

    <script src="https://unpkg.com/@phosphor-icons/web"></script> <!-- ONDE PEGUEI OS ICON TEMPORARIOS 'phosphor-icons' -->
    <script defer src="/sistemackc/views/Js/nav.js"></script> <!-- O atributo "defer" serve para que o script roda depois do html -->
    <script src="/sistemackc/views/Js/fotos.js"></script>


    <!-- Custom CSS -->
    <link rel="stylesheet" href="/sistemackc/views/Css/variaveis.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/crudKartodromo.css">

    <title>Alterar Campeonato</title>
</head>

<body>
    <header class="header">
        <?php
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
        ?>
            <nav class="nav">
                <a class="logo" href="/sistemackc/"><img src="/sistemackc/views/Img/ImgSistema/logoCKC.png" alt="logo do CKC"></a>

                <button class="hamburger"></button>
                <ul class="nav-list">
                    <li><a href="/sistemackc/admtm85/usuario">Usuarios</a></li>
                    <li><a href="/sistemackc/admtm85/campeonato">Campeonatos</a></li>
                    <li><a href="/sistemackc/admtm85/corrida">Corridas</a></li>
                    <li><a href="/sistemackc/admtm85/kartodromo">Kartodromos</a></li>
                    <li><a href="#">Resultados</a></li>

                    <li class="drop-down">
                        <?php
                        if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
                            echo "<a href='#' class='dropdown-toggle'>Olá, " . $_SESSION['nome'] . "<i class='ph ph-caret-down'></i></a>";
                            echo "<ul class='dropdown-menu'>";
                            echo "<li><a href='/sistemackc/usuario/{$_SESSION['id']}'>Perfil</a></li>";
                            echo "<li><a href='/sistemackc/admtm85/menu'>Menu</a></li>";
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

    <main class="container-conteudo">
        <div class="background-image"></div>
        <a class="bt-voltar" href="/sistemackc/admtm85/campeonato/"><i class="ph ph-caret-left"></i>Voltar</a>

        <h1 class="titulo">Alterar Campeonato</h1>


        <?php
            if (isset($feedback) && $feedback != "") {
                echo "<div class='container-feedback'>";
                if ($classe == 'erro') {
                    echo "<span class='$classe'><i class='ph ph-warning-circle'></i><strong>$feedback</strong></span>";
                }
                echo "</div>";
            }
        ?>

        <section class="container-form">
            <form action='' method='POST'>
                <div class="campo">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" value="<?php echo isset($dados[0]) ? $dados[0] : ''; ?>" required>
                </div>

                <div class="campo">
                    <label for="dataInicio">Data de Inicio:</label>
                    <input type="date" id="dataInicio" name="dataInicio" value="<?php echo isset($dados[1]) ? $dados[1] : ''; ?>" required>
                </div>

                <div class="campo">
                    <label for="dataTermino">Data de Término:</label>
                    <input type="date" id="dataTermino" name="dataTermino" value="<?php echo isset($dados[2]) ? $dados[2] : ''; ?>" required>
                </div>
                </div>
                <div class="botao">
                    <button class="bt-atualizar" type="submit">Atualizar</button>
                </div>
            </form>
        </section>
    </main>
    <footer>
        <div>
            <span class="copyright">© 2024 Copyright: ManasCode</span>
            <div>
                <img src="/sistemackc/views/Img/ImgIcones/github.png">
                <a target="_blank" href="https://github.com/LarissaSL/SistemaCKC_MVC">Repositório do Projeto</a>
            </div>
        </div>
    </footer>
<?php
        } else {
            echo "<h1>Acesso não autorizado</h1>";
        }
?>
</body>

</html>