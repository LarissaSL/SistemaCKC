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
    <script defer src="/sistemackc/views/Js/scriptResultados.js"></script>

    <link rel="stylesheet" href="/sistemackc/views/Css/variaveis.css">

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

    <h1 class="title">Cadastrar Resultados</h1>
    <div class=" title_">
        <span>Crash Kart Championship</span>
    </div>
    <div class="date">
        <span>26/07/24</span>
    </div>
    <h2><strong class="title_">CKC Etapa 1</strong></h2>
    <div class="categoria_">110kg</div> 


    <?php
        if (isset($feedback) && !empty($feedback)) {
            echo "<div class='container-feedback'>";
            if($classe == 'erro'){
                echo "<span class='$classe'><i class='ph ph-warning-circle'></i><strong>$feedback</strong></span>";
            }
            echo "</div>";
        }
    ?>  

    <section class="container">
        <form action='/sistemackc/admtm85/resultado/cadastrar' method="POST">
        <div class="posicao">
                <label for="posicao">Posição:</label>
                <select name="posicoes[]" id="posicao"></select>
            </div>
            <div class="piloto">
                <label for="piloto">Piloto:</label>
                <select name="pilotos[]" id="piloto"></select>
            </div>
            <div class="qtd_voltas">
                <label for="qtd_voltas">Qtd. de voltas:</label>
                <input type="number" name="qtd_voltas[]" id="qtd_voltas">
            </div>
            <div class="melhor_tempo">
                <label for="melhor_tempo">Melhor tempo:</label>
                <input type="text" name="melhor_tempo[]" id="melhor_tempo">
            </div>
            <div class="adv">
                <label for="adv">ADV:</label>
                <input type="checkbox" name="adv[]" id="adv" value="cortar caminho">
                <label for="adv">cortar caminho</label>
                <input type="checkbox" name="adv[]" id="adv" value="bandeira de advertência">
                <label for="adv">bandeira de advertência</label>
                <input type="checkbox" name="adv[]" id="adv" value="queimar largada">
                <label for="adv">queimar largada</label>
            </div>
            <div class="pontuacao">
                <label for="score1">Pontuação:</label>
                <input type="number" name="pontuacao[]" id="pontuacao">
            </div>
            <div class="botoes">        
                <button type="button" class="btn_gerarPontuacao">Gerar pontuacão</button>
            </div>
            <div class="botoes">        
                <button type="button" class="btn_excluirRegistro">Excluir registro</button>
            </div>
            <button type="button" id="addPiloto">Adicionar piloto</button>
            <button type="submit">Cadastrar</button>
        </form>
    </section>
    <?php } ?>
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
