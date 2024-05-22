<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">

    <link rel="icon" href="/sistemackc/views/Img/ImgIcones/crash_icon.ico" type="image/x-icon">

    <script src="https://unpkg.com/@phosphor-icons/web"></script> <!-- ONDE PEGUEI OS ICON TEMPORARIOS 'phosphor-icons' -->
    <script defer src="/sistemackc/views/Js/nav.js"></script> <!-- O atributo "defer" serve para que o script roda depois do html -->
    <script src="/sistemackc/views/Js/fotos.js"></script> 


    <!-- Custom CSS -->
    <link rel="stylesheet" href="/sistemackc/views/Css/variaveis.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/CssAdm/crudKartodromo.css">
    
    <title>Atualizar Kartódromo</title>
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
        <div class="background-imageAtualizar"></div>
        <a class="bt-voltar" href="/sistemackc/admtm85/kartodromo/"><i class="ph ph-caret-left"></i>Voltar</a>

        <h1 class="titulo">Atualizar Kartódromo</h1>


        <?php
            if (isset($feedback) && $feedback != '') {
                echo "<div class='container-feedback'>";
                if($classe == 'erro'){
                    echo "<span class='$classe'><i class='ph ph-warning-circle'></i><strong>$feedback</strong></span>";
                } else {
                    echo "<span class='$classe'><i class='ph ph-check-square'></i><strong>$feedback</strong></span>";
                }
                echo "</div>";
            }
        ?>

        <section class="container-form">
            <form action='' method='POST' enctype='multipart/form-data'>
                <div class="campo-foto">
                <?php if (!empty($dados[0])) { ?>
                    <div class="containerFotokartodromo">
                        <div class="imagem">
                            <img class="fotoKartodromo" src="/sistemackc/views/Img/ImgSistema/<?php echo $dados[0]; ?>" alt="Foto de <?php echo $dados[0]; ?>">
                        </div>
                        <input type="file" id="foto" name="foto" class="inputFotoComum">
                    </div>
                    <?php } else { ?> 
                    <div class="container-foto">
                    <input class="input-foto" type="file" id="foto" name="foto" onchange="atualizarTextoComFeedback(this)">
                        <label class="input-label" for="foto">
                            <i class="ph ph-upload-simple"></i>
                            <p class="chamada-foto" id="fotoTexto">Clique aqui para enviar a foto do <strong>Kartódromo</strong></p>
                        </label>
                    </div>
                </div>
                <?php } ?>

                <div class="campos">
                    <div class="divisao">
                        <div class="campo">
                            <label for="nome">Nome:</label>
                            <input type="text" id="nome" name="nome" value="<?php echo isset($dados[1]) ? $dados[1] : ''; ?>" required>
                        </div>

                        <div class="campo">
                            <label for="rua">Rua:</label>
                            <input type="text" id="rua" name="rua" value="<?php echo isset($dados[3]) ? $dados[3] : ''; ?>" required>
                        </div>

                        <div class="campo">
                            <label for="bairro">Bairro:</label>
                            <input type="text" id="bairro" name="bairro" value="<?php echo isset($dados[4]) ? $dados[4] : ''; ?>" required>
                        </div>
                    </div>

                    <div class="divisao">
                        <div class="campo">
                            <label for="cep">CEP:</label>
                            <input type="text" id="cep" name="cep" value="<?php echo isset($dados[2]) ? $dados[2] : ''; ?>" required>
                        </div>

                        <div class="campo">
                            <label for="numero">Número:</label>
                            <input type="text" id="numero" name="numero" value="<?php echo isset($dados[5]) ? $dados[5] : ''; ?>" required>
                        </div>

                        <div class="campo">
                            <label for="site">Site:</label>
                            <input type="text" id="site" name="site" value="<?php echo isset($dados[6]) ? $dados[6] : ''; ?>" required>
                        </div>
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