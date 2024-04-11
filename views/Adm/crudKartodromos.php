<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartódromos</title>

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
                    <!--<li><a href="/sistemackc/admtm85/menu"><img src="/sistemackc/views/Img/ImgSistema/logoCKC.png" alt="logo do CKC"></a></li> -->
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
    <h1>CRUD dos Kartódromos</h1>
    <a class='btn btn-primary' href='/sistemackc/admtm85/kartodromo/cadastrar'>Cadastrar novo kartódromo</a>

    <form method="get">
        <div class="row my-4">
            <div class="col">
                <label>Buscar por Nome</label>
                <input type="text" name="busca" class="form-control" value="<?php echo htmlspecialchars($busca); ?>">
            </div>
            <div class="col d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </form>

    <!-- Só mostra feedback se a classe for a de erro -->
    <?php 
        if (isset($classe) && $classe == 'alert alert-danger') : ?>
        <p class="<?php echo $classe ?>"><?php echo $feedback ?></p>
    <?php endif ?>

    <table class='table table-striped table-bordered '>
        <thead class='thead-dark'>
            <tr>
                <th>Foto</th>
                <th>ID</th>
                <th>Nome</th>
                <th>CEP</th>
                <th>Rua</th>
                <th>Bairro</th>
                <th>Número</th>
                <th>Site</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($kartodromos as $kartodromo) {
                    echo "<tr>";
                    echo "<td><img style='width: 120px;' src='/sistemackc/views/Img/ImgSistema/" . $kartodromo['Foto'] . "' alt='Imagem do Kartódromo'></td>";
                    echo "<td>" . $kartodromo['Id'] . "</td>";
                    echo "<td>" . $kartodromo['Nome'] . "</td>";
                    echo "<td>" . $kartodromo['CEP'] . "</td>";
                    echo "<td>" . $kartodromo['Rua'] . "</td>";
                    echo "<td>" . $kartodromo['Bairro'] . "</td>";
                    echo "<td>" . $kartodromo['Numero'] . "</td>";
                    echo "<td><a class='btn btn-primary' href='{$kartodromo['Site']}' target='_blank'>Visitar site</a></td>";
                    echo "<td>
                            <a class='btn btn-primary' href='/sistemackc/admtm85/kartodromo/atualizar/{$kartodromo["Id"]}'>Editar</a>
                            <button class='btn btn-danger' onclick='confirmarExclusao({$kartodromo["Id"]}, \"{$kartodromo["Nome"]}\")'>Excluir</button>
                        </td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>

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
