<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>  <!-- ONDE PEGUEI OS ICON TEMPORARIOS 'phosphor-icons' -->

    <link rel="stylesheet" href="../Css/varLogin.css">
    <link rel="stylesheet" href="../Css/style.css">
    <title>Cadastro</title>
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
                        <li><a href="/sistemackc/kartodromo">Kartódromo</a></li>
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

    <main>
        <section class="container">
            <div id="bt-voltar">
                <a href="/sistemackc/"><i class="ph ph-caret-left"></i>Voltar</a>
            </div>

            <div class="titulo">
                <h1>Cadatro</h1>
            </div>

        <?php if(isset($feedback)) : ?>
            <p class="<?php echo $status ?>"><?php echo $feedback;?></p>
        <?php endif; ?>

            <form action="cadastro" method="POST">
                <div class="nome">
                    <label class="nome" for="nome">Nome:</label>
                    <input type="text" name="nome" value="<?php echo isset($dados) ? $dados[0] : ''; ?>" required>
                </div>
                
                <div class="sobrenome">
                    <label class="sobrenome" for="sobrenome">Sobrenome:</label>
                    <input type="text" name="sobrenome" value="<?php echo isset($dados) ? $dados[1] : ''; ?>" required>
                </div>
                
                <div class="dataNascimento">
                    <label class="dataNascimento" for="dataNascimento">Data de Nascimento:</label>
                    <input type="date" name="dataNascimento" required>
                </div>

                <div class="genero">
                    <input type="radio" value="Masculino" name="genero" <?php echo isset($dados) && $dados[8] == 'Masculino' ? 'checked' : ''; ?>>
                    <label class="homem" for="homem">Homem</label>

                    <input type="radio" value="Feminino" name="genero" <?php echo isset($dados) && $dados[8] == 'Feminino' ? 'checked' : ''; ?>>
                    <label class="mulher" for="mulher">Mulher</label>

                    <input type="radio" value="Outro" name="genero" <?php echo isset($dados) && $dados[8] == 'Outro' ? 'checked' : ''; ?>>
                    <label class="outro" for="outro">Outro</label>
                </div>

                <div class="cpf">
                    <label class="cpf" for="cpf">CPF:</label>
                    <input type="text" name="cpf" value="<?php echo isset($dados) ? $dados[2] : ''; ?>" required>
                </div>

                <div class="telefone">
                    <label class="telefone" for="telefone">Celular:</label>
                    <input type="text" name="telefone" value="<?php echo isset($dados) ? $dados[9] : ''; ?>" required>
                </div>

                <div class="peso">
                    <label class="peso" for="peso">Peso:</label>
                    <input type="number" name="peso" value="<?php echo isset($dados) ? $dados[7] : ''; ?>" required>
                </div>

                <div class="email">
                    <label class="email" for="email">E-mail:</label>
                    <input type="text" name="email" value="<?php echo isset($dados) ? $dados[3] : ''; ?>" required>
                </div>

                <div class="confirmaEmail">
                    <label class="email" for="email">Confirmação de E-mail:</label>
                    <input type="text" name="confirmarEmail" value="<?php echo isset($dados) ? $dados[4] : ''; ?>" required>
                </div>
                
                <div class="senha">
                    <label class="senha" for="senha">Senha:</label>
                    <input type="password" name="senha" value="<?php echo isset($dados) ? $dados[5] : ''; ?>" required>
                </div>

                <div class="confirmaSenha">
                    <label class="senha" for="senha">Confirmação de Senha:</label>
                    <input type="password" name="confirmarSenha" value="<?php echo isset($dados) ? $dados[6] : ''; ?>" required>
                </div>

                <button type="submit" class="bt-cadastrar">Cadastrar</button>
            </form>
        </section>
    </main> 

</body>
</html>