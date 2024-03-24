<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>  <!-- ONDE PEGUEI OS ICON TEMPORARIOS 'phosphor-icons' -->
    <script defer src="/views/Js/nav.js"></script> <!-- O atributo "defer" serve para que o script roda depois do html -->

    <link rel="stylesheet" href="/sistemackc/views/Css/variaveis.css">  

    <title>Kartodromo</title>
</head>
<body>
    <header>
        <nav>
            <i class="ph ph-list"></i>
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
                            echo "</ul>";
                            
                        } elseif(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
                            echo "<p>Olá, " . $_SESSION['nome'] . "</p>";
                            echo "<ul class='drop-corrida'>";
                            echo "<li><a href='/sistemackc/usuario/{$_SESSION['id']}'>Perfil</a></li>";
                            echo "<li><a href='/sistemackc/admtm85/menu'>Dashboard</a></li>";
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

    <main>
        <section class="container">
            <h1>Kartódromos</h1>
            <?php
                foreach ($kartodromos as $kartodromo) 
                {
                    echo "<article class='card-one'>";
                        echo "<h2>{$kartodromo['Nome']}</h2>";
                        echo "<img src='/sistemackc/views/Img/ImgSistema/{$kartodromo['Foto']}' alt='pista do Kartódromo {$kartodromo['Nome']}'>";
                        echo "<div class='address'>";
                            echo "<i class='ph ph-map-pin'></i>";
                            echo "<strong> LOCALIZAÇÃO</strong>";
                            echo "<p>{$kartodromo['Rua']}, {$kartodromo['Numero']} - {$kartodromo['Bairro']} , {$kartodromo['CEP']} </p>";
                            echo "<strong>SITE</strong>";
                            echo "<a class='btn btn-primary' href='{$kartodromo['Site']}' target='_blank'>Visitar site</a>";
                        echo "</div>";
                        echo "<a href='#' class='bt-to-locate'>Como chegar</a>";
                    echo "</article>";
                }
            ?>
        </section>
    </main>
    
    <footer>
        <p>© Manas code</p>
    </footer>
    
</body>
</html>