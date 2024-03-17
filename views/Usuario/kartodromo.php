<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>  <!-- ONDE PEGUEI OS ICON TEMPORARIOS 'phosphor-icons' -->

    <link rel="stylesheet" href="../Css/varLogin.css">
    <link rel="stylesheet" href="../Css/style.css">
    <title>Kartodromo</title>
</head>
<body>
    <header>
        <nav>
            <i class="ph ph-list"></i>
            <ul>
                <li><img src="./views/Img/ImgSistema/logoCKC.png" alt="logo do CKC"></li>
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
                    session_start();
                    if(isset($_SESSION['nome'])) {
                        echo "<p>Olá, " . $_SESSION['nome'] . "</p>";
                        echo "<ul class='drop-corrida'>";
                        echo "<li><a href='./usuario/{$_SESSION['id']}'>Perfil</a></li>";
                        echo "<li><a href='/sistemackc/logout'>Logout</a></li>";
                        echo "</ul>";
                    } else {
                        echo "<a href='./usuario/login'>Entrar</a>";
                    }
                    ?>
                </li>                 
            </ul>
        </nav>
    </header>

    <main>
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