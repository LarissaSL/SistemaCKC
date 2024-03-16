<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
</head>
<body>
    <h1>Teste Perfil</h1>
    <?php if(isset($feedback)): ?>
        <p><?php echo $feedback; ?></p>
    <?php else: ?>
        <h2>Perfil do Usuário ID: <?php echo $id; ?></h2>
        <p>Nome: <?php echo $nome; ?></p> 
        <p>Email: <?php echo $email; ?></p> 
        <p>Foto:</p>
        <img src="<?php echo $foto_perfil; ?>" alt="Foto de <?php echo $nome; ?>"> 
    <?php endif; ?>
</body>
</html>