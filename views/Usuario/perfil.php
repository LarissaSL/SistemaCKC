<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
</head>
<body>
    <header>
        <nav>
            <i class="ph ph-list"></i><!-- ícone de menu -->
            <ul>
                <li><img src="../views/Img/ImgSistema/logoCKC.png" alt="logo do CKC"></li>
                <li><a href="#">História</a></li>
                <li>
                    <a href="#">Corridas</a>
                    <ul class="drop-corrida">
                        <li><a href="#">Etapas</a></li>
                        <li><a href="#">Classificação</a></li>
                        <li><a href="#">Galeria</a></li>
                        <li><a href="#">Inscrição</a></li>
                        <li><a href="#">Regulamento</a></li>
                        <li><a href="#">Kartódromo</a></li>
                    </ul>
                </li> 
                <li>
                    <?php
                    session_start();
                    if(isset($_SESSION['nome'])) {
                        echo "<p>Olá, " . $_SESSION['nome'] . "</p>";
                        echo "<ul class='drop-corrida'>";
                        echo "<li><a href='./usuario/{$_SESSION['id']}'>Perfil</a></li>";
                        echo "<li><a href='/sistemackc/logout'>Logout</a></li>";
                        echo "</ul>";
                    } else {
                        echo "<a href='../usuario/login'>Entrar</a>";
                    }
                    ?>
                </li>               
            </ul>
        </nav>
    </header>
    <h1>Perfil</h1>
    
    <?php if(isset($feedback)): ?>
        <p><?php echo $feedback; ?></p>
    <?php else: ?>

        <h2>Perfil do Usuário ID: <?php echo $id; ?></h2>
        <p>Nome: <?php echo $nome; ?></p> 
        <p>Email: <?php echo $email; ?></p> 
        <p>Foto:</p>
        
        <?php if(isset($fotoPerfil)): ?>
            <img src="<?php echo $fotoPerfil; ?>" alt="Foto de <?php echo $nome; ?>"> 
        <?php endif; ?>

        <?php 
            if(isset($_SESSION['id'])):
        ?>
        <form action="/sistemackc/usuario/<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
            <label for="fotoPerfil">Atualizar sua foto de perfil:</label><br>
            <input type="file" id="fotoPerfil" name="fotoPerfil" required><br><br>
            <input type="submit" value="Enviar Foto">
        </form>
        <?php endif; ?>
    <?php endif; ?>
    <div id="bt-go-back">
        <a href="/sistemackc/"><i class="ph ph-caret-left"></i>Voltar</a> <!--tag 'a' com o icone de seta '<' -->
    </div>
</body>
</html>
