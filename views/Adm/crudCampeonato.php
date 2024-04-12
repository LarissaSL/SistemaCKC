<!DOCTYPE html>
<html lang=pt-br>

<head>
    <meta charset=UTF-8>
    <meta name=viewport content="width=device-width" , initial-scale="1.0">
    <title>Campeonatos</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
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
            <nav>
                <i class="ph ph-list"></i><!-- ícone de menu -->
                <ul>
                    <!--<li><a href="/sistemackc/admtm85/menu"><img src="../views/Img/ImgSistema/logoCKC.png" alt="logo do CKC"></a></li> -->
                    <li><a href="/sistemackc/admtm85/usuario">Usuarios</a></li>
                    <li><a href="/sistemackc/admtm85/campeonato">Campeonatos</a></li>
                    <li><a href="#">Corridas</a></li>
                    <li><a href="/sistemackc/admtm85/kartodromo">Kartodromos</a></li>
                    <li><a href="#">Resultados</a></li>

                    <li>
                        <?php
                        if (isset($_SESSION['nome'])) {
                            echo "<p>Olá, " . $_SESSION['nome'] . "</p>";
                            echo "<ul class='drop-corrida'>";
                            echo "<li><a href='/sistemackc/usuario/{$_SESSION['id']}'>Perfil</a></li>";
                            echo "<li><a href='/sistemackc/admtm85/menu'>Dashboard</a></li>";
                            echo "<li><a href='/sistemackc/logout'>Logout</a></li>";
                            echo "</ul>";
                        } else {
                            echo "<a href='#'>Entrar</a>";
                        }
                        ?>
                    </li>
                </ul>
            </nav>
    </header>
    <!-- Inicio do Conteúdo para o ADM -->
    <h1>CRUD dos Campeonatos</h1>
    <a class='btn btn-primary' href='/sistemackc/admtm85/campeonato/cadastrar'>Cadastrar novo Campeonato</a>

    <!-- Só mostra feedback se a classe for a de erro -->
    <?php
        if (isset($classe) && $classe == 'alert alert-danger') { ?>
        <p class="<?php echo $classe ?>"><?php echo $feedback ?></p>
    <?php } else { ?>

        <form method="get">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="filtroNome">Filtrar por Nome</label>
                    <input type="text" class="form-control" id="filtroNome" name="filtroNome" value="<?php echo isset($_GET['filtroNome']) ? htmlspecialchars($_GET['filtroNome']) : ''; ?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="filtroDataInicio">Filtrar por Data de Início</label>
                    <input type="date" class="form-control" id="filtroDataInicio" name="filtroDataInicio" value="<?php echo isset($_GET['filtroDataInicio']) ? htmlspecialchars($_GET['filtroDataInicio']) : ''; ?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="filtroDataTermino">Filtrar por Data de Término</label>
                    <input type="date" class="form-control" id="filtroDataTermino" name="filtroDataTermino" value="<?php echo isset($_GET['filtroDataTermino']) ? htmlspecialchars($_GET['filtroDataTermino']) : ''; ?>">
                </div>
                <div class="form-group col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </div>
        </form>

        <?php
            if (isset($classe) && $classe == 'erro') : ?>
                <p class="<?php echo $classe ?>"><?php echo $feedback ?></p>
        <?php endif ?>

        <table class='table table-striped table-bordered '>
            <thead class='thead-dark'>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Data de Inicio</th>
                    <th>Data de Termino</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($campeonatos as $campeonato) {
                    echo "<tr>";
                    echo "<td>" . $campeonato['Id'] . "</td>";
                    echo "<td>" . $campeonato['Nome'] . "</td>";
                    $dataInicio = new DateTime($campeonato['Data_inicio']);
                    $dataTermino = new DateTime($campeonato['Data_termino']);
                    echo "<td>" . $dataInicio->format('d/m/Y') . "</td>";
                    echo "<td>" . $dataTermino->format('d/m/Y') . "</td>";
                    echo "<td>
                <a class='btn btn-primary' href='/sistemackc/admtm85/campeonato/atualizar/{$campeonato["Id"]}'>Editar</a>";
                    echo "<button class='btn btn-danger' onclick='confirmarExclusao({$campeonato["Id"]},\"{$campeonato["Nome"]}\")'>Excluir</button>";
                    echo "</tr>";
                }
                echo "</table>";
                ?>


                <script>
                    function confirmarExclusao(id, nome) {
                        if (confirm(`Tem certeza que deseja excluir:\nID: ${id}  |  ${nome} \n\nOBS.: Essa ação é irreversivel.`)) {
                            window.location.href = '/sistemackc/admtm85/campeonato/excluir/' + id;
                        }
                    }
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