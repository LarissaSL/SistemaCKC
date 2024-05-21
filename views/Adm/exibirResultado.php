<!DOCTYPE html>
<html lang="pt-BR">

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

    <link rel="icon" href="/sistemackc/views/Img/ImgIcones/crash_icon.ico" type="image/x-icon">

    <link rel="stylesheet" href="/sistemackc/views/Css/variaveis.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/resultadoExibir.css">

    <title>Resultado</title>
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
                <button class="hamburger"></button>
                <ul class="nav-list">
                    <li><a href="/sistemackc/admtm85/usuario">Usuarios</a></li>
                    <li><a href="/sistemackc/admtm85/campeonato">Campeonatos</a></li>
                    <li><a href="/sistemackc/admtm85/corrida">Corridas</a></li>
                    <li><a href="/sistemackc/admtm85/kartodromo">Kartodromos</a></li>
                    <li><a href="/sistemackc/admtm85/resultado">Resultados</a></li>
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

    <h1>Classificação da Corrida</h1>

    <?php
            if (isset($feedback) && !empty($feedback)) {
                echo "<div class='container-feedback'>";
                if ($classe == 'erro') {
                    echo "<span class='$classe'><i class='ph ph-warning-circle'></i><strong>$feedback</strong></span>";
                }
                echo "</div>";
            } else {
    ?>

    <div class=informacoesCorrida>
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
    </div>

    

    <p>Confira abaixo a classificação da corrida:</p>
    <div class="ranking-container">
        <?php
            foreach ($dadosResultado as $resultado) :
                // Processando os dados de cada usuario
                $usuario = $usuarioModel->consultarUsuarioPorId($resultado['Usuario_id']);
                $nome = $usuario['Nome'];
                $sobrenome = $usuario['Sobrenome'];
                $foto = $usuario['Foto'] != NULL ? $usuario['Foto'] : 'perfil_branco.png';
        ?>
            <div class="pilot">
                <img class="pilot-img" src="/sistemackc/views/Img/ImgUsuario/<?php echo $foto; ?>" alt="<?php echo $nome . ' ' . $sobrenome; ?>">
                <div class="pilot-info <?php echo "posicao" .$resultado['Posicao']; ?>">
                    <span><?php echo $resultado['Posicao']; ?>º Lugar</span>
                    <span><?php echo $nome . ' ' . $sobrenome; ?></span>
                    <span><?php echo $resultado['Melhor_tempo']; ?></span>
                    <span><?php echo $resultado['Pontuacao_total']; ?> pts</span>
                </div>
            </div>
    <?php endforeach; ?>

    <?php 
        echo "<a class='btn btn-primary' href='/sistemackc/admtm85/resultado/atualizar/{$dadosCorrida["Id"]}'>Editar</a>";
        echo "<button class='btn btn-danger' onclick='confirmarExclusao({$dadosCorrida["Id"]}, \"{$dadosCorrida["Nome"]}\", \"{$dadosCorrida["Nome_Campeonato"]}\")'>Excluir</button>";
    ?>

    
    <?php 
        }} else {
            echo "<h1>Acesso não autorizado</h1>";
        }
    ?>
    </div>

    <script>
        function confirmarExclusao(id, nome, campeonato) {
            if (confirm(`Tem certeza que deseja excluir TODOS os registros:\n${campeonato} - ${nome} \n\nOBS.: Essa ação é irreversível.`)) {
                window.location.href = '/sistemackc/admtm85/resultado/excluir/corrida/' + id;
            }
        }
    </script>
</body>

</html>