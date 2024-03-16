<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
</head>
<body>
    <h2>Cadastrar Novo Usuário</h2>
    <?php if(isset($feedback)) : ?>
        <script>
            alert("<?php echo $feedback; ?>");
        </script>
    <?php endif; ?>
    
    <form action="cadastro" method="POST">
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome"><br><br>
        
        <label for="cpf">CPF:</label><br>
        <input type="text" id="cpf" name="cpf"><br><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"><br><br>
        
        
        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>
