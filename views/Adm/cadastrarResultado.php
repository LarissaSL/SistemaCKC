<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- google fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700&display=swap" rel="stylesheet">

    <link rel="icon" href="/sistemackc/views/Img/ImgIcones/crash_icon.ico" type="image/x-icon">

    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script defer src="/sistemackc/views/Js/nav.js"></script>
    <script defer src="/sistemackc/views/Js/scriptResultados.js"></script>

    <link rel="stylesheet" href="/sistemackc/views/Css/variaveis.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/CssAdm/resultadoExibir.css">

    <title>Cadastrar Resultados</title>
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
                    <li><a href="/sistemackc/admtm85/resultado">Resultados</a></li>
                    <li><a href="/sistemackc/admtm85/kartodromo">Kartodromos</a></li>
                    
                    <li class="drop-down">
                        <?php
                        if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
                            echo "<a href='#' class='dropdown-toggle'>Olá, " . $_SESSION['nome'] . "<i class='ph ph-caret-down'></i></a>";
                            echo "<ul class='dropdown-menu'>";
                            echo "<li><a href='/sistemackc/usuario/{$_SESSION['id']}'>Perfil</a></li>";
                            echo "<li><a href='/sistemackc/admtm85/menu'>Menu</a></li>";
                            echo "<li><a href='/sistemackc/logout'>Sair</a></li>";
                            echo "</ul>"; 
                        } else {
                            echo "<a href='/sistemackc/usuario/login'>Entrar</a>";
                        }
                        ?>
                    </li>
                </ul>
            </nav>
    </header>

    <h1 class="title">Cadastro de Resultado</h1>

    <div class="title_">
        <?php echo "<span>" . $dadosCorrida['Nome_Campeonato'] . "</span>" ?>
    </div>
    <div class="date">
        <?php
            $dataCorrida = new DateTime($dadosCorrida['Data_corrida']);
            echo "<span>" . $dataCorrida->format('d/m/Y') . "</span>";
        ?>
    </div>
    <?php
            $nomeCompleto = strtoupper($nomeAbreviado) . " " . $dadosCorrida['Nome'];
            echo "<h2><strong class='title_'>" . $nomeCompleto . "</strong></h2>";
    ?>

    <div class="categoria_">
        <?php
            $categoriaFormatada = $dadosCorrida['Categoria'] == "Livre" ? $dadosCorrida['Categoria'] : $dadosCorrida['Categoria'] . " kg";
            echo "<span>" . $categoriaFormatada . "</span>";
        ?>
    </div>

    <?php
            if (isset($feedback) && !empty($feedback)) {
                echo "<div class='container-feedback'>";
                if ($classe == 'erro') {
                    echo "<span class='$classe'><i class='ph ph-warning-circle'></i><strong>$feedback</strong></span>";
                }
                echo "</div>";
            }

            if (isset($usuarios) && $usuarios == []) {
                echo "<p>É necessário ter ao menos 1 usuário cadastrado no sistema, para registrar um resultado</p>";
                echo "<a class='bt-redirecionar' href='/sistemackc/admtm85/usuario/cadastrar'>Cadastrar usuario</a><br>";
            } else {
    ?>

        <section class="container">
            <form action='' method="POST" id="formResultados">
                <div id="pilotosContainer">
                    <?php
                    if (isset($dados) && $dados != NULL) {
                        foreach ($dados as $dadosItem) { ?>
                            <div class="piloto">
                                <label>Posição:</label>
                                <select name="posicoes[]" required>
                                    <?php
                                    $posicoes = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15");
                                    foreach ($posicoes as $posicao) {
                                        echo "<option value='$posicao' " . (stripos($dadosItem[0], $posicao) !== false ? 'selected' : '') . ">$posicao º</option>";
                                    }
                                    ?>
                                </select>
                                <label>Piloto:</label>
                                <select name="pilotos[]" required>
                                    <?php foreach ($usuarios as $usuario) { ?>
                                        <option value="<?php echo $usuario['id']; ?>" <?php echo $usuario['id'] == $dadosItem[1] ? 'selected' : ''; ?>>
                                            <?php echo $usuario['nome'] . ' ' . $usuario['sobrenome']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <label>Melhor tempo:</label>
                                <input type="time" name="melhor_tempo[]" value="<?php echo $dadosItem[2]; ?>" placeholder="Melhor Tempo" required>
                                <label>Pontuação:</label>
                                <input readonly type="number" name="pontuacao[]" value="<?php echo isset($dadosItem[3]) ? $dadosItem[3] : ''; ?>">
                                <button type="button" class="btn_excluirRegistro">Excluir registro</button>
                            </div>
                    <?php
                        }
                    } ?>
                </div>
                <button type="button" id="addPiloto">Adicionar piloto</button>
                <button type="submit" id="bt-Cadastrar">Cadastrar</button>
            </form>
        </section>

        <script>
            //Passando os dados do array de $usuarios pro JS conseguir popular
            var usuarios = <?php echo json_encode($usuarios); ?>;
        </script>

    <?php } ?>
    <?php
            } else {
                echo "<h1>Acesso não autorizado</h1>";
            }
    ?>

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