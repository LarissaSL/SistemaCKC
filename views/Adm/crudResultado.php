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
    <title>Resultados</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="/sistemackc/views/css/crudResultado.css">

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
                    <li><a href="/sistemackc/admtm85/corrida">Corridas</a></li>
                    <li><a href="/sistemackc/admtm85/kartodromo">Kartodromos</a></li>
                    <li><a href="/sistemackc/admtm85/resultado">Resultados</a></li>

                    <li>
                        <?php
                        if (isset($_SESSION['nome'])) {
                            echo "<p>Olá, " . $_SESSION['nome'] . "</p>";
                            echo "<ul class='drop-corrida'>";
                            echo "<li><a href='/sistemackc/usuario/{$_SESSION['id']}'>Perfil</a></li>";
                            echo "<li><a href='/sistemackc/admtm85/menu'>Menu</a></li>";
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
    <h1>CRUD de Resultados</h1>

    <form method="get">
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="filtroCampeonato">Filtrar por Campeonato</label>
                <select class="form-control" id="filtroCampeonato" name="filtroCampeonato">
                    <option value="">Selecione um Campeonato</option>
                    <?php
                    foreach ($campeonatos as $campeonato) {
                        $selected = isset($_GET['filtroCampeonato']) && $_GET['filtroCampeonato'] == $campeonato['Id'] ? 'selected' : '';
                        echo "<option value='" . $campeonato['Id'] . "' $selected>" . $campeonato['Nome'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group col-md-3">
                <label for="filtroDia">Filtrar por Dia</label>
                <select class="form-control" id="filtroDia" name="filtroDia">
                    <option value="">Selecione um Dia</option>
                    <?php
                    for ($dia = 1; $dia <= 31; $dia++) {
                        $selected = isset($_GET['filtroDia']) && $_GET['filtroDia'] == $dia ? 'selected' : '';
                        echo "<option value='" . $dia . "' $selected>" . $dia . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="filtroMes">Filtrar por Mês</label>
                <select class="form-control" id="filtroMes" name="filtroMes">
                    <option value="">Selecione um Mês</option>
                    <?php
                    $meses = [
                        1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
                        5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
                        9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
                    ];
                    foreach ($meses as $numeroMes => $nomeMes) {
                        $selected = isset($_GET['filtroMes']) && $_GET['filtroMes'] == $numeroMes ? 'selected' : '';
                        echo "<option value='" . $numeroMes . "' $selected>" . $nomeMes . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="filtroAno">Filtrar por Ano</label>
                <input type="text" class="form-control" id="filtroAno" name="filtroAno" placeholder="Digite o ano" value="<?php echo isset($_GET['filtroAno']) ? htmlspecialchars($_GET['filtroAno']) : ''; ?>">
            </div>
            <div class="form-group col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </form>

    <!-- Só mostra feedback se a classe for a de erro -->
    <?php
            if (isset($classe) && $classe == 'alert alert-danger') { ?>
        <p class="<?php echo $classe ?>"><?php echo $feedback ?></p>
    <?php } else { ?>

        <table class="table table-striped table-bordered ">
            <thead class="thead-dark">
                <tr>
                    <th>Ações</th>
                    <th>Nome Campeonato</th>
                    <th>Nome Kartodromo</th>
                    <th>Nome Corrida</th>
                    <th>Categoria</th>
                    <th>Data da Corrida</th>
                    <th>Status Resultado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($corridas as $corrida) {
                        echo "<tr>";
                        echo "<td>";
                       
                        // Verifica se existe resultado para essa corrida
                        $resultadoModel = new Resultado();
                        $resultado = $resultadoModel->selecionarResultadoPorCorridaId($corrida['Id']);
                    
                        // Se nao tiver resultado, desativa os botoes de exibir, cadastrar, editar e excluir
                        $disabled = !$resultado ? "disabled" : "";
                        $disabledCadastrar = $resultado ? "disabled" : "";

                        echo "<a class='btn btn-primary $disabledCadastrar' href='/sistemackc/admtm85/resultado/cadastrar/{$corrida["Id"]}'>Cadastrar</a>";
                        echo "<a class='btn btn-primary $disabled' href='/sistemackc/admtm85/resultado/exibir/{$corrida["Id"]}'>Exibir</a>";
                        echo "<a class='btn btn-primary $disabled' href='/sistemackc/admtm85/corrida/atualizar/{$corrida["Id"]}'>Editar</a>";
                        echo "<a class='btn btn-danger $disabled'href='/sistemackc/admtm85/resultado/excluir/{$corrida["Id"]}'>Excluir</a>";
                        echo "</td>";
                    
                        echo "<td>" . $corrida['Nome_Campeonato'] . "</td>";
                        echo "<td>" . $corrida['Nome_Kartodromo'] . "</td>";
                        echo "<td>" . $corrida['Nome'] . "</td>";
                        echo "<td>" . $corrida['Categoria'] . "</td>";
                    
                        $dataCorrida = new DateTime($corrida['Data_corrida']);
                        echo "<td>" . $dataCorrida->format('d/m/Y') . "</td>";
                    
                        echo "<td class='statusContainer'>";
                        if ($resultado) {
                            echo "<span class='status status_true'>Cadastrado</span>";
                        } else {
                            echo "<span class='status status_false'>Não cadastrado</span>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                ?>


                <script>
                    function confirmarExclusao(id, nome, campeonato) {
                        if (confirm(`Tem certeza que deseja excluir TODOS os registros:\n${campeonato} - ${nome} \n\nOBS.: Essa ação é irreversível.`)) {
                            window.location.href = '/sistemackc/admtm85/resultado/excluir/' + id;
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