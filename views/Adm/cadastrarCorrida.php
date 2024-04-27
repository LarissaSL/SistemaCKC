<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- google fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <script src="https://unpkg.com/@phosphor-icons/web"></script> <!-- ONDE PEGUEI OS ICON TEMPORARIOS 'phosphor-icons' -->
    <script defer src="/sistemackc/views/Js/nav.js"></script> <!-- O atributo "defer" serve para que o script roda depois do html -->

    <link rel="stylesheet" href="/sistemackc/views/Css/variaveis.css">

    <title>Cadastro de Corridas</title>
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


    <h1>Cadastro de Corridas</h1>
    <?php
        if (isset($feedback)) {
            echo "<div class='container-feedback'>";
            if($classe == 'erro'){
                echo "<span class='$classe'><i class='ph ph-warning-circle'></i><strong>$feedback</strong></span>";
            }
            echo "</div>";
        }
    ?>

    <section class="container">
        <form action='/sistemackc/admtm85/corrida/cadastrar' method='POST'>
            <div>
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo isset($dados[0]) ? $dados[0] : ''; ?>" required>
            </div>

            <div>
                <label for="campeonato">Campeonato:</label>
                <select id="campeonato" name="campeonato_id">
                    <?php
                        if(isset($dados[1]) && $dados[1] != "") {
                            echo "<option value=" . $dados[1] . " selected>" . $dados[2] . "</option>";
                            foreach ($dadosCampeonatos as $campeonato) {
                                if ($dados[1] != $campeonato['Id']) {
                                    echo "<option value=" . $campeonato['Id'] . ">" . $campeonato['Nome'] . "</option>";
                                }
                            }
                        } else {
                            foreach ($dadosCampeonatos as $campeonato) {
                                echo "<option value=" . $campeonato['Id'] . ">" . $campeonato['Nome'] . "</option>";
                            }
                        }
                    ?>
                </select>
            </div>

            <div>
                <label for="kartodromo">Kartódromo:</label>
                <select id="kartodromo" name="kartodromo_id">
                    <?php
                        if(isset($dados[3]) && $dados[3] != "") {
                            echo "<option value=" . $dados[3] . " selected>" . $dados[4] . "</option>";
                            foreach ($dadosKartodromos as $kartodromo) {
                                if ($dados[3] != $kartodromo['Id']) {
                                    echo "<option value=" . $kartodromo['Id'] . ">" . $kartodromo['Nome'] . "</option>";
                                }
                            }
                        } else {
                            foreach ($dadosKartodromos as $kartodromo) {
                                echo "<option value=" . $kartodromo['Id'] . ">" . $kartodromo['Nome'] . "</option>";
                            }
                        }
                    ?>
                </select>
            </div>

            <div>
                <label for="categoria">Categoria:</label><br>
                <input type="radio" id="categoria95" name="categoria" value="95" <?php echo (isset($dados[5]) && $dados[5] == '95') ? 'checked' : ''; ?>>
                <label for="categoria95">95kg</label><br>
                <input type="radio" id="categoria110" name="categoria" value="110" <?php echo (isset($dados[5]) && $dados[5] == '110') ? 'checked' : ''; ?>>
                <label for="categoria110">110kg</label><br>
                <input type="radio" id="categoriaLivre" name="categoria" value="Livre" <?php echo (isset($dados[5]) && $dados[5] == 'Livre') ? 'checked' : ''; ?>>
                <label for="categoria110">Livre</label><br>
            </div>

            <div>
                <label for="data">Data da corrida:</label>
                <input type="date" id="data" name="dataCorrida" value="<?php echo isset($dados[6]) ? $dados[6] : ''; ?>" required>
            </div>

            <div>
                <label for="horario">Horário:</label>
                <input type="time" id="horario" name="horario" value="<?php echo isset($dados[7]) ? $dados[7] : ''; ?>" required>
            </div>

            <div>
                <label for="tempo_corrida">Tempo da corrida:</label>
                <input type="time" id="tempo_corrida" name="tempoCorrida" value="<?php echo isset($dados[8]) ? $dados[8] : '00:25'; ?>" required>
            </div>

            <div>
                <button type="submit">Enviar</button>
            </div>
        </form>
    </section>
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