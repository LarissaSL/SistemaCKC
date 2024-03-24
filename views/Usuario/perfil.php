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
    <script defer src="/views/Js/nav.js"></script> <!-- O atributo "defer" serve para que o script roda depois do html -->
    

    <title>Perfil</title>
</head>

<body>
    <?php
    if (!isset($_SESSION)) {
        session_start();
    }

    if (strpos($_SERVER['REQUEST_URI'], 'admtm85') !== false && (!isset($_SESSION['email']) || $_SESSION['email'] !== 'ckckart23@gmail.com')) {
        echo "<h1>Acesso não autorizado22</h1>";
        var_dump($_SESSION['email']);
        var_dump($_SESSION['tipo']);
    } else {
    ?>
        <header>
            <nav>
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
                        if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Comum') {
                            echo "<p>Olá, " . $_SESSION['nome'] . "</p>";
                            echo "<ul class='drop-corrida'>";
                            echo "<li><a href='/sistemackc/usuario/{$_SESSION['id']}'>Perfil</a></li>";
                            echo "<li><a href='/sistemackc/logout'>Logout</a></li>";
                            
                        } elseif(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
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
        <main>
            <h1>Perfil</h1>

            <?php if (isset($feedback)) : ?>
                <p><?php echo $feedback; ?></p>
            <?php else : ?>
                <h2>Perfil do Usuário ID: <?php echo $usuario['Id']; ?></h2>
                <?php $dataFormatada = date('d-m-Y', strtotime($usuario['Data_nascimento'])); ?>

                <p>Foto:</p>

                <!-- Se o Usuário tiver foto ela irá aparecer -->
                <?php if (isset($usuario['Foto'])) : ?>
                    <img src="/sistemackc/views/Img/ImgUsuario/<?php echo $usuario['Foto'] ?>" alt="Foto de <?php echo $usuario['Nome']; ?>">
                <?php endif; ?>

                <!-- Se o Usuário Logado for o mesmo do ID ele pode trocar sua foto de perfil -->
                <?php if (isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email'] || isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {

                if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
                    echo "<form action='/sistemackc/admtm85/usuario/{$usuario['Id']}' method='POST' enctype='multipart/form-data'>";
                } else {
                    echo "<form action='/sistemackc/usuario/{$usuario['Id']}' method='POST' enctype='multipart/form-data'>";
                }
                ?>
                <label for="fotoPerfil">
                    <?php
                        if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
                            echo "Atualizar foto de Perfil do Usuário";
                        } else {
                            echo "Atualizar sua foto de perfil:";
                        }
                    ?>
                </label><br>
                <input type="file" id="fotoPerfil" name="fotoPerfil" required><br><br>
                <input type="submit" value="Enviar Foto">
                </form>

                <!-- Aqui exibe o feedback da imagem CASO seja inválida -->
                <?php if (isset($feedbackDaImagem)) {
                echo "<span class='$classe'>$feedbackDaImagem</span>";
                } ?>
                <?php } ?>


                <?php
                    if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
                        echo "<form action='/sistemackc/admtm85/usuario/atualizar/{$usuario['Id']}' method='POST'>";
                    } else {
                        echo "<form action='/sistemackc/usuario/atualizar/{$usuario['Id']}' method='POST'>";
                    }
                ?>

                <div class="nome">
                    <label class="nome" for="nome">Nome:</label>
                    <input type="text" name="nome" value="<?php echo $usuario['Nome'] ?>" <?php echo (isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') ? '' : 'readonly'; ?>>
                </div>

                <div class="sobrenome">
                    <label class="sobrenome" for="sobrenome">Sobrenome:</label>
                    <input type="text" name="sobrenome" value="<?php echo $usuario['Sobrenome'] ?>" <?php echo (isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') ? '' : 'readonly'; ?>>
                </div>

                <div class="dataNascimento">
                    <label class="dataNascimento" for="dataNascimento">Data de Nascimento:</label>
                    <input type="text" name="dataNascimento" value="<?php echo $dataFormatada ?>" <?php echo (isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') ? '' : 'readonly'; ?>>
                </div>

                <div class="genero">
                    <?php if ((isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador')) : ?>
                        <input type="radio" value="Masculino" name="genero" <?php echo $usuario['Genero'] == 'Masculino' ? 'checked' : ''; ?>>
                        <label class="homem" for="homem">Masculino</label>

                        <input type="radio" value="Feminino" name="genero" <?php echo $usuario['Genero'] == 'Feminino' ? 'checked' : ''; ?>>
                        <label class="mulher" for="mulher">Feminino</label>

                        <input type="radio" value="Outro" name="genero" <?php echo $usuario['Genero'] == 'Outro' ? 'checked' : ''; ?>>
                        <label class="outro" for="outro">Outro</label>
                    <?php else : ?>
                        <label>Genero</label>
                        <input type="text" value="<?php echo $usuario['Genero']; ?> " name="genero" <?php echo (isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') ? '' : 'readonly'; ?>>
                    <?php endif; ?>
                </div>

                <div class="cpf">
                    <label class="cpf" for="cpf">CPF:</label>
                    <input type="text" name="cpf" value="<?php echo $usuario['Cpf'] ?>" <?php echo (isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') ? '' : 'readonly'; ?>>
                </div>

                <div class="telefone">
                    <label class="telefone" for="telefone">Celular:</label>
                    <input type="text" name="telefone" value="<?php echo $usuario['Telefone'] ?>" <?php echo (isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') ? '' : 'readonly'; ?>>
                </div>

                <div class="peso">
                    <label class="peso" for="peso">Peso:</label>
                    <input type="number" name="peso" value="<?php echo $usuario['Peso'] ?>" <?php echo (isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') ? '' : 'readonly'; ?>>
                </div>

                <div class="email">
                    <label class="email" for="email">E-mail:</label>
                    <input type="text" name="email" value="<?php echo $usuario['Email'] ?>" <?php echo (isset($_SESSION['email']) && $_SESSION['email'] == $usuario['Email']) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') ? '' : 'readonly'; ?>>
                </div>
                <?php if (isset($_SESSION['email']) && ($_SESSION['email'] == $usuario['Email'] || $_SESSION['tipo'] == 'Administrador')) : ?>
                    <?php $url = ($_SESSION['tipo'] == 'Administrador') ? '/sistemackc/admtm85/atualizar/senha/'.$usuario['Id'] : '/sistemackc/usuario/atualizar/senha/'.$usuario['Id']; ?>
                    
                    <!-- Gerando o link para alterar a senha -->
                    <a href="<?php echo $url; ?>">Alterar senha</a>
                    <button type="submit" class="bt-cadastrar">Atualizar</button>
                <?php endif; ?>
                </form>
            <?php endif; ?>

            <div id="bt-go-back">
                <?php
                    if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
                        echo "<a href='/sistemackc/admtm85/usuario'><i class='ph ph-caret-left'></i>Voltar</a>";
                    } else {
                        echo "<a href='/sistemackc/'><i class='ph ph-caret-left'></i>Voltar</a>";
                    }
                ?>
            </div>
        <?php } ?>
    </main>
    <footer>
        <p>© Manas code</p>
    </footer>    
</body>
</html>