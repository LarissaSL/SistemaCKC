<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>  <!-- ONDE PEGUEI OS ICON TEMPORARIOS 'phosphor-icons' -->

    <link rel="stylesheet" href="varLogin.css">
    <link rel="stylesheet" href="style.css">
    <title>Cadastro</title>
</head>
<body>
    <header>
        <nav>
            <i class="ph ph-list"></i>
            <ul>
                <li><img src="/logoCKC.png" alt="logo do CKC"></li>
                <li><a href="#">História</a></li>
                <li>
                    <a href="#">Corridas</a>
                    <ul class="drop-corrida">
                        <li><a href="#"></a>Etapas</li>
                        <li><a href="#"></a>Classificação</li>
                        <li><a href="#"></a>Galeria</li>
                        <li><a href="#"></a>Inscrição</li>
                        <li><a href="#"></a>Regularmento</li>
                        <li><a href="#"></a>Kartódromo</li>                       
                    </ul>
                </li>                
            </ul>
        </nav>
    </header>



    <main>
        <section class="container">
            <div id="bt-voltar">
                <a href="#"><i class="ph ph-caret-left"></i>Voltar</a>
            </div>

            <div class="titulo">
                <h1>Cadatro</h1>
            </div>

        <?php if(isset($feedback)) : ?>
            <p class="<?php echo $status ?>"><?php echo $feedback;?></p>
        <?php endif; ?>

            <form action="cadastro" method="POST" enctype="multipart/form-data">
                <div class="nome">
                    <label class="nome" for="nome">Nome:</label>
                    <input type="text" name="nome" required>
                </div>
                
                <div class="sobrenome">
                    <label class="sobrenome" for="sobrenome">Sobrenome:</label>
                    <input type="text" name="sobrenome" required>
                </div>
                
                <div class="dataNascimento">
                    <label class="dataNascimento" for="dataNascimento">Data de Nascimento:</label>
                    <input type="date" name="dataNascimento" required>
                </div>

                <div class="genero">
                    <input type="radio" value="Masculino" name="genero">
                    <label class="homem" for="homem">Homem</label>

                    <input type="radio" value="Feminino" name="genero">
                    <label class="mulher" for="mulher">Mulher</label>

                    <input type="radio" value="Outro" name="genero">
                    <label class="outro" for="outro">Outro</label>
                </div>

                <div class="cpf">
                    <label class="cpf" for="cpf">CPF:</label>
                    <input type="text" name="cpf" required>
                </div>

                <div class="telefone">
                    <label class="telefone" for="telefone">Celular:</label>
                    <input type="text" name="telefone" required>
                </div>

                <div class="peso">
                    <label class="peso" for="peso">Peso:</label>
                    <input type="number" name="peso" required>
                </div>

                <div class="email">
                    <label class="email" for="email">E-mail:</label>
                    <input type="text" name="email" required>
                </div>

                <div class="confirmaEmail">
                    <label class="email" for="email">Confirmação de E-mail:</label>
                    <input type="text" name="confirmarEmail" required>
                </div>
                
                <div class="senha">
                    <label class="senha" for="senha">Senha:</label>
                    <input type="password" name="senha" required>
                </div>

                <div class="confirmaSenha">
                    <label class="senha" for="senha">Confirmação de Senha:</label>
                    <input type="password" name="confirmarSenha" required>
                </div>

                <button type="submit" class="bt-cadastrar">Cadastrar</button>
            </form>
        </section>
    </main> 

</body>
</html>
