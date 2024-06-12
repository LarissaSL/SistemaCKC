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
    <script defer src="/sistemackc/views/Js/modal.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/sistemackc/views/Css/variaveis.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/CssAdm/crudUsuario.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/CssAdm/modal.css">


    <title>Usuários</title>
</head>

<body>
    <header class="header">
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
    <!-- Inicio do Conteúdo para o ADM -->
    <main>
        <section class="contrainer">
            <h1 class="title">Manutenção de Usuários</h1>
            <p class="subTititulo">Aqui você pode fazer cadastro, consulta, alteração e exclusão de usuários no sistema.</p>
            <a class='bt-cadastrar' href='/sistemackc/admtm85/usuario/cadastrar'>Cadastrar novo usuário</a><!-- Botão de cadastrar novo usuário -->

            <form method="get">
                <div class="filtro">
                    <!-- Busca/filtro -->
                    <div class="filtro_nome">
                        <label>Filtrar por Nome</label>
                        <input type="text" name="busca" class="form-control" value="<?php echo htmlspecialchars($busca); ?>">
                    </div>

                    <div class="filtro_user">
                        <!-- Busca/filtro -->
                        <label>Tipo de usuário</label>
                        <select name="tipo" class="busca_User">
                            <option value="">Comum/Administrador</option>
                            <option value="comum" <?php echo $tipo == 'comum' ? 'selected' : ''; ?>>Comum</option>
                            <option value="administrador" <?php echo $tipo == 'administrador' ? 'selected' : ''; ?>>Administrador</option>
                        </select>
                    </div>

                    <div class="bt-filtrar">
                        <button type="submit" class="bt_filtrar">Filtrar</button><!-- Botão de filtar -->
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
                            <th>Foto de Perfil</th>
                            <th>Tipo</th>
                            <th>Nome</th>
                            <th>Sobrenome</th>
                            <th>CPF</th>
                            <th>Email</th>
                            <th class="modal">Senha</th>
                            <th class="modal">Peso</th>
                            <th class="modal">Data de nascimento</th>
                            <th class="modal">Genero</th>
                            <th>Telefone</th>
                            <th class="modal">Data de Registro</th>
                            <th>Mais informações</th>
                        </tr>
                    </thead>
                    <tbody><!--corpo da tabela/linhas -->

                        <?php
                        foreach ($usuarios as $usuario) {

                            echo "<tr>";

                            echo "<td class='acoes'><div class='icos'>
                                <a class='bt-editar' href='/sistemackc/admtm85/usuario/{$usuario["Id"]}'><i class='ph-bold ph-note-pencil'></i></a>"; //<!--Botão de editar -->
                            if ($usuario['Id'] != 1) {
                                echo "<button class='bt-excluir' onclick='confirmarExclusao({$usuario["Id"]}, \"{$usuario["Nome"]}\", \"{$usuario["Sobrenome"]}\")'><i class='ph-bold ph-trash'></i></button></div></td>"; //<!--Botão de excluir -->
                            }

                            $foto = $usuario['Foto'] != NULL ? $usuario['Foto'] : 'perfil_escuro.png';
                            echo "<td><img style='width: 100px;' src='/sistemackc/views/Img/ImgUsuario/" . $foto . "' alt='Imagem de " . $usuario['Nome'] . "'></td>";
                            echo "<td>" . $usuario['Tipo'] . "</td>";
                            echo "<td>" . $usuario['Nome'] . "</td>";
                            echo "<td>" . $usuario['Sobrenome'] . "</td>";
                            echo "<td>" . $usuario['Cpf'] . "</td>";
                            echo "<td>" . $usuario['Email'] . "</td>";
                            echo "<td class='modal'>" . substr($usuario['Senha'], 0, 5) . " ...</td>";
                            echo "<td class='modal'>" . $usuario['Peso'] . "</td>";
                            $dataNascimento = new DateTime($usuario['Data_nascimento']);
                            echo "<td class='modal'>" . $dataNascimento->format('d/m/Y') . "</td>";
                            echo "<td class='modal'>" . $usuario['Genero'] . "</td>";
                            echo "<td>" . $usuario['Telefone'] . "</td>";
                            echo "<td class='modal'> " . $usuario['Data_registro'] . "</td>";
                            echo "<td class='bt-modal'>
                                    <div class='icon-plus'>
                                        <button class='btModal' 
                                                foto='<img style=\"width: 90px;\" src=\"/sistemackc/views/Img/ImgUsuario/" . $foto . "\" alt=\"Imagem de " . $usuario['Nome'] . "\">'
                                                cpf='" . $usuario['Cpf'] . "' 
                                                data-nascimento='" . $usuario['Data_nascimento'] . "' 
                                                tipo='" . $usuario['Tipo'] . "' 
                                                nome='" . $usuario['Nome'] . "' 
                                                sobrenone='" . $usuario['Sobrenome'] . "' 
                                                email='" . $usuario['Email'] . "' 
                                                senha='" . substr($usuario['Senha'], 0, 5) . "' 
                                                peso='" . $usuario['Peso'] . "' 
                                                genero='" . $usuario['Genero'] . "' 
                                                telefone='" . $usuario['Telefone'] . "' 
                                                data-registro='" . $usuario['Data_registro'] . "'>
                                                <i class='ph-bold ph-plus'></i>
                                        </button>
                                    </div></td>";
                            echo "</tr>";
                        }
                        echo "</table>";

                        ?>

            </div>
            <script>
                function confirmarExclusao(id, nome, sobrenome) {
                    if (confirm(`Tem certeza que deseja excluir:\nID: ${id}  |  ${nome} ${sobrenome}\n\nOBS.: Essa ação é irreversivel.`)) {
                        window.location.href = './usuario/excluir/' + id;
                    }
                }
            </script>

        <?php
        } else {
            echo "<h1>Acesso não autorizado</h1>";
        }
        ?>
        </section>
        <div class='modal-container'></div>
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
            <div class="copyrights">
                <span class="copyright">© Sistema Gerenciador de corridas de kart. Todos os Direitos Reservados à Manas Code</span>
                <div class="logos">
                    <div class="logSistema">
                        <span class="copySistema">Plataforma</span>
                        <img class="logo logoSistema" src="/sistemackc/Views/Img/ImgSistema/logoSis_Gerenciador_kart.png" alt="logo do Sistema Gerenciador de Corridas de Kart ">
                    </div>
                    <div class="logManas">
                        <span class="copyDevs">desenvolvedor</span>
                        <img class="logo logoManasC" src="/sistemackc/Views/Img/ImgSistema/logoManasC.png" alt="logo da desenvolvedora do sistema - Manas Code">
                    </div>
                </div>
            </div>

            <div class="navegation">
                <div class="contact">
                    <a href="https://www.instagram.com/crashkartchampionship?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank">
                        <i class="ph-fill ph-instagram-logo"></i><!-- logo instagram-->
                    </a>
                    <a href="https://wa.me/5511984372045" target="_blank">
                        <i class="ph-fill ph-whatsapp-logo"></i><!-- logo whatsapp-->
                    </a>
                </div>
                <div class="navigationLink">
                    <a href="/sistemackc/etapas">Etapas</a>
                    <a href="/sistemackc/classificacao">Classificação</a>
                    <a href="/sistemackc/kartodromo">Kartódromos</a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>