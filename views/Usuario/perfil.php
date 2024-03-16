<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
</head>
<body>
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
        
        <form action="/sistemackc/usuario/<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
            <label for="fotoPerfil">Atualizar sua foto de perfil:</label><br>
            <input type="file" id="fotoPerfil" name="fotoPerfil" required><br><br>
            <input type="submit" value="Enviar Foto">
        </form>
    <?php endif; ?>
</body>
</html>
