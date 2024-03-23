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

    <script src="https://unpkg.com/@phosphor-icons/web"></script>  <!-- ONDE PEGUEI OS ICON TEMPORARIOS 'phosphor-icons' -->
    <script defer src="/views/Js/nav.js"></script> <!-- O atributo "defer" serve para que o script roda depois do html -->

    <link rel="stylesheet" href="/sistemackc/views/Css/variaveis.css">  

    <title>Kartodromo</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="/sistemackc/"><img src="/sistemackc/views/Img/ImgSistema/logoCKC.png" alt="logo do CKC"></a></li>
                <li><a href="#">História</a></li>
                <li>
                    <a href="#">Corridas</a>
                    <ul class="drop-corrida">
                        <li><a href="#"></a>Etapas</li>
                        <li><a href="#"></a>Classificação</li>
                        <li><a href="#"></a>Galeria</li>
                        <li><a href="#"></a>Inscrição</li>
                        <li><a href="#"></a>Regularmento</li>
                        <li><a href="/sistemackc/kartodromo">Kartódromo</a></li>                       
                    </ul>
                </li>
                <li>
                    <?php
                        if (!isset($_SESSION)) {
                            session_start();
                        }
                        if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Comum') {
                            echo "<p>Olá, " . $_SESSION['nome'] . "</p>";
                            echo "<ul class='drop-corrida'>";
                            echo "<li><a href='/sistemackc/usuario/{$_SESSION['id']}'>Perfil</a></li>";
                            echo "<li><a href='/sistemackc/logout'>Logout</a></li>";
                            
                        } elseif(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
                            echo "<p>Olá, " . $_SESSION['nome'] . "</p>";
                            echo "<ul class='drop-corrida'>";
                            echo "<li><a href='/sistemackc/usuario/{$_SESSION['id']}'>Perfil</a></li>";
                            echo "<li><a href='/sistemackc/admtm85/menu'>Dashboard</a></li>";
                            echo "<li><a href='/sistemackc/logout'>Logout</a></li>";
                        } else {
                            echo "<a href='sistemackc/usuario/login'>Entrar</a>";
                        }
                    ?>
                </li>                 
            </ul>
        </nav>
    </header>
    <main>
        <!-- botão de voltar -->
        <div id="bt-go-back">
            <a href="/sistemackc/"><i class="ph ph-caret-left"></i>Voltar</a> <!--tag 'a' com o icone de seta '<' -->
        </div>
        <section class="container">
            <h1>Kartódromos</h1>
            <!-- Primeiro cartão -->
            <article class="card-one">
                <h2>Grande viana</h2>
                <img src="#" alt="pista do Kartódromo de Grande viana">

                <div class="address">
                    <i class="ph ph-map-pin"></i> <!--icone de localização -->
                    <strong> LOCALIZAÇÃO</strong>
                </div>

                <a href="#" class="bt-to-locate">Como chegar</a>
            </article>
            
            <!-- Segundo cartão -->
            <article class="card-two">
                <h2>Nova Odessa</h2>
                <img src="#" alt="pista do Kartódromo de Nova Odessas">

                <div class="address">
                    <i class="ph ph-map-pin"></i> <!--icone de localização -->
                    <strong> LOCALIZAÇÃO</strong>
                </div>

                <a href="#" class="bt-to-locate">Como chegar</a>
            </article>
        </section>
    </main>    
    <footer>
        <p>© Manas code</p>
    </footer>    
</body>
</html>