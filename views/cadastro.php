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
        <p class="<?php echo $status ?>"><?php echo $feedback;?></p>
    <?php endif; ?>

    <form action="cadastro" method="POST" enctype="multipart/form-data">
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" required><br><br>
        
        <label for="cpf">CPF:</label><br>
        <input type="text" id="cpf" name="cpf" required><br><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="senha">Senha:</label><br>
        <input type="password" id="senha" name="senha"><br><br>

        <label for="peso">Peso:</label><br>
        <input type="number" id="peso" name="peso"><br><br>
        
        <label for="data_nascimento">Data de Nascimento:</label><br>
        <input type="date" id="data_nascimento" name="data_nascimento"><br><br>

        <label for="genero">Gênero:</label><br>
        <select id="genero" name="genero">
            <option value="Masculino">Masculino</option>
            <option value="Feminino">Feminino</option>
            <option value="Outro">Outro</option>
        </select><br><br>
        
        <label for="telefone">Telefone:</label><br>
        <input type="text" id="telefone" name="telefone"><br><br>

        <label for="foto_perfil">Foto de Perfil:</label><br>
        <input type="file" id="foto_perfil" name="foto_perfil"><br><br>
        
        
        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>
