<!DOCTYPE html>
<html lang=pt-br>

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

    <link rel="stylesheet" href="/sistemackc/views/Css/variaveis.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/CssAdm/crudUsuario.css">

    
    <title>Corridas</title>


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
        <section class="contrainer">
            <!-- Inicio do Conteúdo para o ADM -->
            <h1 class="title">Manutenção de Corridas</h1>
            <p class="subTititulo">Aqui você pode fazer cadastro, consulta, alteração e exclusão de usuários no sistema.</p>
            <a class='bt-cadastrar' href='/sistemackc/admtm85/corrida/cadastrar'>Cadastrar nova Corrida</a>

            <!-- Demais erros possiveis (Erro na consulta, nao achar, etc) -->
            <?php
            if (isset($classe) && $classe == 'alert alert-danger') { ?>
                <p class="<?php echo $classe ?>"><?php echo $feedback ?></p>
            <?php } else { ?>

                <form method="get">
                    <div class="filtro">
                        <div class="filtro">
                            <div class="filtro_nome">
                                <label for="filtroNome" style="color: black;">Filtrar por Nome da Corrida</label>
                                <input type="text" class="form-control" id="filtroNome" name="filtroNome" value="<?php echo isset($_GET['filtroNome']) ? htmlspecialchars($_GET['filtroNome']) : ''; ?>">
                            </div>
                        </div>
                        <div class="filtro_user">
                            <label for="filtroCampeonato" style="color: black;">Filtrar por Campeonato</label>
                            <select class="busca_User" id="filtroCampeonato" name="filtroCampeonato">
                                <option value="">Selecione um Campeonato</option>
                                <?php
                                foreach ($campeonatos as $campeonato) {
                                    $selected = isset($_GET['filtroCampeonato']) && $_GET['filtroCampeonato'] == $campeonato['Id'] ? 'selected' : '';
                                    echo "<option value='" . $campeonato['Id'] . "' $selected>" . $campeonato['Nome'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="filtro_user">
                            <label for="filtroData" style="color: black;">Filtrar por Data</label>
                            <input type="date" class="form-control" id="filtroData" name="filtroData" value="<?php echo isset($_GET['filtroData']) ? htmlspecialchars($_GET['filtroData']) : ''; ?>">
                        </div>
                        <div class="bt-filtrar">
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                        </div>
                    </div>
                </form>


                <!-- Erros caso nao tenha as dependencias cadastradas -->
                <?php
                if (isset($classe) && $classe == 'erro') : ?>
                    <p class="<?php echo $classe ?>"><?php echo $feedback ?></p>
                <?php endif ?>

                <div class="tabela">
                    <table class='tabela-conteudo '>
                        <thead class='tb-cabecalho'>
                            <tr class='nome-cabecalhos'>
                                <th>Ações</th>
                                <th>Nome Campeonato</th>
                                <th>Nome Kartodromo</th>
                                <th>Nome</th>
                                <th>Categoria</th>
                                <th>Data da Corrida</th>
                                <th>Horário</th>
                                <th>Tempo da Corrida</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($corridas as $corrida) {
                                echo "<tr>";
                                echo "<td class='acoes'><div class='icos'>
                        <a class='bt-editar' href='/sistemackc/admtm85/corrida/atualizar/{$corrida["Id"]}'><i class='ph-bold ph-note-pencil'></i></a>";
                                echo "<button class='bt-excluir' onclick='confirmarExclusao({$corrida["Id"]},\"{$corrida["Nome"]}\")'><i class='ph-bold ph-trash'></button></td>";
                                
                                echo "<td>" . $corrida['Nome_Campeonato'] . "</td>";
                                echo "<td>" . $corrida['Nome_Kartodromo'] . "</td>";
                                echo "<td>" . $corrida['Nome'] . "</td>";
                                echo "<td>" . $corrida['Categoria'] . "</td>";

                                //Conversoes das Datas e Tempos
                                $dataCorrida = new DateTime($corrida['Data_corrida']);
                                echo "<td>" . $dataCorrida->format('d/m/Y') . "</td>";

                                $horario = new DateTime($corrida['Horario']);
                                echo "<td>" . $horario->format('H\hi\m\i\n') . "</td>";

                                $tempoCorrida = $corrida['Tempo_corrida'];
                                $tempoMinutos = (int)date('i', strtotime($tempoCorrida));
                                echo "<td>" . $tempoMinutos . "min</td>";
                                echo "</tr>";
                            }
                            echo "</table>";
                            ?>

                </div>
                <script>
                    function confirmarExclusao(id, nome) {
                        if (confirm(`Tem certeza que deseja excluir:\nID: ${id}  |  ${nome} \n\nOBS.: Essa ação é irreversível.`)) {
                            window.location.href = '/sistemackc/admtm85/corrida/excluir/' + id;
                        }
                    }
                </script>
            <?php } ?>

        <?php
        } else {
            echo "<h1>Acesso não autorizado</h1>";
        }
        ?>
        </section>
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