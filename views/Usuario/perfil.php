<!DOCTYPE html>
<html lang="pt-br">

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

    <title>Perfil</title>
</head>

<body>
    <?php
    if (!isset($_SESSION)) {
        session_start();
    }

    if (strpos($_SERVER['REQUEST_URI'], 'admtm85') !== false && ($_SESSION['tipo'] !== 'Administrador')) {
        echo "<h1>Acesso não autorizado</h1>";
    } else {
    ?>
        <header class="header">
            <nav class="nav">
                <a class="logo" href="/sistemackc/"><img src="/sistemackc/views/Img/ImgSistema/logoCKC.png" alt="logo do CKC"></a>

                <button class="hamburger"></button>
                <ul class="nav-list">
                    <?php
                    if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Comum' || !isset($_SESSION['tipo'])) {
                        echo "<li><a href='/sistemackc/historia'>História</a></li>";
                    ?>
                        <li class="drop-down">
                            <a href="#" class="dropdown-toggle">Corridas<i class="ph ph-caret-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Etapas</a></li>
                                <li><a href="#">Classificação</a></li>
                                <li><a href="/sistemackc/kartodromo">Kartódromos</a></li>
                            </ul>
                        </li>
                    <?php } elseif (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
                        echo "<li><a href='/sistemackc/admtm85/usuario'>Usuarios</a></li>";
                        echo "<li><a href='#'>Corridas</a></li>";
                        echo "<li><a href='/sistemackc/admtm85/kartodromo'>Kartodromos</a></li>";
                        echo "<li><a href='#'>Resultados</a></li>";
                    } ?>

                    <?php
                    if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Comum') { ?>
                        <li class="drop-down">
                            <?php echo "<a href='#' class='dropdown-toggle'>Olá, " . $_SESSION['nome'] . "<i class='ph ph-caret-down'></i></a>"; ?>
                            <ul class="dropdown-menu">
                                <?php echo "<li><a href='/sistemackc/usuario/{$_SESSION['id']}'>Perfil</a></li>"; ?>
                                <?php echo "<li><a href='/sistemackc/logout'>Logout</a></li>"; ?>
                            </ul>
                        </li>
                    <?php } elseif (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') { ?>
                        <li class='drop-down'>
                            <?php echo "<a href='#' class='dropdown-toggle'>Olá, " . $_SESSION['nome'] . "<i class='ph ph-caret-down'></i></a>"; ?>
                            <ul class='dropdown-menu'>
                                <?php echo "<li><a href='/sistemackc/usuario/{$_SESSION['id']}'>Perfil</a></li>"; ?>
                                <li><a href='/sistemackc/admtm85/menu'>Menu</a></li>
                                <li><a href='/sistemackc/logout'>Logout</a></li>
                            </ul>
                        </li>
                    <?php } else {
                        echo "<a href='/sistemackc/usuario/login'>Entrar</a>";
                    }
                    ?>
                </ul>
            </nav>
        </header>
        <main class="container-conteudo">
            <div class="background-imagePerfilUser"></div>
            <div id="bt-go-back">
                <?php
                if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
                    echo "<a href='/sistemackc/admtm85/usuario'><i class='ph ph-caret-left'></i>Voltar</a>";
                } else {
                    echo "<a href='/sistemackc/'><i class='ph ph-caret-left'></i></a>";
                }
                ?>
            </div>

            <h1 class="titulo">Perfil</h1>

            <?php if (isset($feedbackSobrePerfil)) : ?>
                <p><?php echo $feedbackSobrePerfil; ?></p>
            <?php else : ?>
                <h2 class="subtitulo">Perfil do Usuário ID: <?php echo $usuario['Id']; ?></h2>
                <?php $dataFormatada = date('d-m-Y', strtotime($usuario['Data_nascimento'])); ?>

                <section class="container-form">
                    <!-- Se o Usuário tiver foto ela irá aparecer -->
                    <?php if (isset($usuario['Foto'])) : ?>
                        <div class="containerFotoPerfil">
                            <div class="imagem">
                                <img src="/sistemackc/views/Img/ImgUsuario/<?php echo $usuario['Foto'] ?>" alt="Foto de <?php echo $usuario['Nome']; ?>">
                            </div>
                        <?php endif ?>

                        <!-- Se o Usuário Logado for o mesmo do ID ele pode trocar sua foto de perfil -->
                        <?php
                        if (isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email'] || isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
                            if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
                                echo "<form action='/sistemackc/admtm85/usuario/atualizar/{$usuario['Id']}' method='POST' enctype='multipart/form-data'>";
                            } else {
                                echo "<form action='/sistemackc/usuario/atualizar/{$usuario['Id']}' method='POST' enctype='multipart/form-data'>";
                            }
                        ?>
                            <div class="container">
                                <label for="fotoPerfil">
                                    <?php
                                    if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
                                        echo "Atualizar foto de Perfil do Usuário";
                                    } else {
                                        echo "Atualizar sua foto de perfil:";
                                    }
                                    echo "</label>";
                                    if ((isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador')) {
                                        echo "<input type='file' id='foto' name='foto' class='inputFotoComum'>";
                                    }
                                    ?>
                            </div>
                </section>



                <!-- Aqui exibe os feedbacks -->
                <?php
                    if (isset($feedback) && $feedback != '') {
                        echo "<div class='container-feedback'>";
                        if ($classe == 'erro') {
                            echo "<span class='$classe'><i class='ph ph-warning-circle'></i><strong>$feedback</strong></span>";
                        } else {
                            echo "<span class='$classe'><i class='ph ph-check-square'></i><strong>$feedback</strong></span>";
                        }
                            echo "</div>";
                    }
                ?>
            <?php } ?>

            <div class="campos">
                <div class="divisao">
                    <div class="campo">
                        <label class="nome" for="nome">Nome:</label>
                        <input type="text" name="nome" value="<?php echo $usuario['Nome'] ?>" <?php echo (isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') ? '' : 'readonly'; ?>>
                    </div>

                    <div class="campo">
                        <label class="sobrenome" for="sobrenome">Sobrenome:</label>
                        <input type="text" name="sobrenome" value="<?php echo $usuario['Sobrenome'] ?>" <?php echo (isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') ? '' : 'readonly'; ?>>
                    </div>

                    <div class="campo">
                        <label class="dataNascimento" for="dataNascimento">Data de Nascimento:</label>
                        <input type="text" name="dataNascimento" value="<?php echo $dataFormatada ?>" <?php echo (isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') ? '' : 'readonly'; ?>>
                    </div>


                    <?php if ((isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador')) : ?>
                        <div class="genero">
                            <input type="radio" value="Masculino" name="genero" <?php echo $usuario['Genero'] == 'Masculino' ? 'checked' : ''; ?>>
                            <label class="homem" for="homem">Masculino</label>

                            <input type="radio" value="Feminino" name="genero" <?php echo $usuario['Genero'] == 'Feminino' ? 'checked' : ''; ?>>
                            <label class="mulher" for="mulher">Feminino</label>

                            <input type="radio" value="Outro" name="genero" <?php echo $usuario['Genero'] == 'Outro' ? 'checked' : ''; ?>>
                            <label class="outro" for="outro">Outro</label>
                        <?php else : ?>
                            <div class="campo">
                                <label>Gênero</label>
                                <input type="text" value="<?php echo $usuario['Genero']; ?> " name="genero" <?php echo (isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') ? '' : 'readonly'; ?>>
                            <?php endif; ?>
                            </div>
                            
                            <!-- FALTA ESTILO NESSE AQUI, Parte que o ADM escolhe o tipo de Usuário  -->
                            <?php if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') : ?>
                                <div class="dataNascimento">
                                    <select name="tipo" id="tipo">
                                        <option value="Comum" <?php echo $usuario['Tipo'] == 'Comum' ? 'selected' : ''; ?>>Comum</option>
                                        <option value="Administrador" <?php echo $usuario['Tipo'] == 'Administrador' ? 'selected' : ''; ?>>Administrador</option>
                                    </select>
                                </div>
                            <?php endif ?>
                        </div>

                        <div class="divisao">
                            <?php if ((isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador')) : ?>
                                <div class="campo">
                                    <label class="cpf" for="cpf">CPF:</label>
                                    <input type="text" name="cpf" value="<?php echo $usuario['Cpf'] ?>" <?php echo (isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') ? '' : 'readonly'; ?>>
                                </div>
                            <?php endif ?>

                            <div class="campo">
                                <label class="telefone" for="telefone">Celular:</label>
                                <input type="text" name="telefone" value="<?php echo $usuario['Telefone'] ?>" <?php echo (isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') ? '' : 'readonly'; ?>>
                            </div>

                            <div class="campo">
                                <label class="peso" for="peso">Peso:</label>
                                <input type="number" name="peso" value="<?php echo $usuario['Peso'] ?>" <?php echo (isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') ? '' : 'readonly'; ?>>
                            </div>

                            <div class="campo">
                                <label class="email" for="email">E-mail:</label>
                                <input type="text" name="email" value="<?php echo $usuario['Email'] ?>" <?php echo (isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') ? '' : 'readonly'; ?>>
                            </div>
                        </div>
                </div>
                <?php if (isset($_SESSION['email']) && ($_SESSION['email'] == $usuario['Email'] || $_SESSION['tipo'] == 'Administrador')) : ?>
                    <?php $url = ($_SESSION['tipo'] === 'Administrador') ? '/sistemackc/admtm85/usuario/atualizar/senha/' . $usuario['Id'] : '/sistemackc/usuario/atualizar/senha/' . $usuario['Id']; ?>

                    <div class="botao">
                        <button type="submit" class="bt-atualizar">Atualizar</button>
                        <a class="bt-alterar" href="<?php echo $url; ?>">Alterar senha</a>
                    </div>
                <?php endif; ?>
            </div>
            </form>
        <?php endif; ?>

    <?php } ?>
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
</body>

</html>