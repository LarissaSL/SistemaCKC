<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">

    <link rel="icon" href="/sistemackc/views/Img/ImgIcones/crash_icon.ico" type="image/x-icon">

    <script src="https://unpkg.com/@phosphor-icons/web"></script> <!-- ONDE PEGUEI OS ICON TEMPORARIOS 'phosphor-icons' -->
    <script defer src="/sistemackc/views/Js/nav.js"></script> <!-- O atributo "defer" serve para que o script roda depois do html -->
    <script defer src="/sistemackc/views/Js/modal.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/sistemackc/views/Css/variaveis.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/CssAdm/crudUsuario.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/CssAdm/crudKartodromo.css">
    <title>Kartódromos</title>

</head>

<body>
    <header>
        <?php
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
        ?>
            <!-- Inicio do Conteúdo para o ADM -->
            <nav class="nav">
                <a class="logo" href="/sistemackc/"><img src="/sistemackc/views/Img/ImgSistema/logoCKC.png" alt="logo do CKC"></a>

                <button class="hamburger"></button>
                <ul class="nav-list">
                    <li class="drop-down">
                        <a href="#" class="dropdown-toggle">Menu<i class="ph ph-caret-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="/sistemackc/admtm85/usuario">Usuarios</a></li>
                            <li><a href="/sistemackc/admtm85/corrida">Corridas</a></li>
                            <li><a href="/sistemackc/admtm85/campeonato">Campeonatos</a></li>
                            <li><a href="/sistemackc/admtm85/resultado">Resultados</a></li>
                            <li><a href="/sistemackc/admtm85/kartodromo">Kartodromos</a></li>
                        </ul>
                    </li>

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
    <main>
        <!-- Inicio do Conteúdo para o ADM -->
        <h1 class="title">Manutenção de Kartódromos</h1>
        <p class="subTititulo">Aqui você pode fazer cadastro, consulta, alteração e exclusão de usuários no sistema.</p>
        <a class='bt-cadastrar-kart' href='/sistemackc/admtm85/kartodromo/cadastrar'>Cadastrar novo kartódromo</a>

        <form method="get">
            <div class="filtro">
                <div class="filtro_nome">
                    <label>Filtrar por Nome</label>
                    <input type="text" name="busca" class="form-control" value="<?php echo htmlspecialchars($busca); ?>">
                </div>
                <div class="bt-filtrar">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </div>
        </form>

        <!-- Só mostra feedback se a classe for a de erro -->
        <?php
            if (isset($classe) && $classe == 'alert alert-danger') : ?>
            <p class="<?php echo $classe ?>"><?php echo $feedback ?></p>
        <?php endif ?>

        <div class="tabela">
            <table class='tabela-conteudo'>
                <thead class='tb-cabecalho'> <!--cabecalho da tabela -->
                    <tr class='nome-cabecalhos'>
                        <th>Ações</th>
                        <th>Foto</th>
                        <th>Nome</th>
                        <th>CEP</th>
                        <th>Rua</th>
                        <th>Bairro</th>
                        <th>Número</th>
                        <th>Redes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($kartodromos as $kartodromo) {
                        echo "<tr>";
                        echo "<td class='acoes'><div class='icos'>
                        <a class='bt-editar' href='/sistemackc/admtm85/kartodromo/atualizar/{$kartodromo["Id"]}'><i class='ph-bold ph-note-pencil'></i></a>
                        <button class='bt-excluir' onclick='confirmarExclusao({$kartodromo["Id"]}, \"{$kartodromo["Nome"]}\")'><i class='ph-bold ph-trash'></i></button></div></td>";
                        echo "<td><img style='width: 120px;' src='/sistemackc/views/Img/ImgSistema/" . $kartodromo['Foto'] . "' alt='Imagem do Kartódromo'></td>";
                        echo "<td>" . $kartodromo['Nome'] . "</td>";
                        echo "<td>" . $kartodromo['CEP'] . "</td>";
                        echo "<td>" . $kartodromo['Rua'] . "</td>";
                        echo "<td>" . $kartodromo['Bairro'] . "</td>";
                        echo "<td>" . $kartodromo['Numero'] . "</td>";
                        echo "<td><a class='links' href='{$kartodromo['Redes']}' target='_blank'>acesse aqui</a></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>

        </div>
        <script>
            function confirmarExclusao(id, nome) {
                if (confirm(`Tem certeza que deseja excluir:\nID: ${id}  |  ${nome}\n\nOBS.: Essa ação é irreversivel.`)) {
                    window.location.href = '/sistemackc/admtm85/kartodromo/excluir/' + id;
                }
            }
        </script>

    <?php
        } else {
            echo "<h1>Acesso não autorizado</h1>";
        }
    ?>
    </main>
    <footer>
        <!-- ondas -->
        <div class="water">
            <svg class="waves" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                <defs>
                    <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                </defs>
                <g class="parallax">
                    <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(47, 44, 44, 0.7)" />
                    <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(47, 44, 44, 0.5)" />
                    <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(49, 46, 46, 0.3)" />
                    <use xlink:href="#gentle-wave" x="48" y="7" fill="var(--background-campos)" />

                </g>
            </svg>
        </div>
        <!-- conteudo na nav -->
        <div class="content">
            <span class="copyright">2024 Manas Code | Todos os direitos reservados</span>
            <div class="navegation">
                <div class="contact">
                    <a href="https://www.instagram.com/crashkartchampionship?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank">
                        <i class="ph-fill ph-instagram-logo"></i><!-- logo instagram-->
                    </a>
                    <a href="#" target="_blank">
                        <i class="ph-fill ph-whatsapp-logo"></i><!-- logo whatsapp-->
                    </a>
                </div>
                <div class="navigationLink">
                    <a href="/sistemackc/etapas">Etapas</a>
                    <a href="#">Classificação</a>
                    <a href="/sistemackc/kartodromo">Kartódromos</a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>