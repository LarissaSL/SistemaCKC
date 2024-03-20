<!DOCTYPE html>
<html lang=pt-br>

<head>
    <meta charset=UTF-8>
    <meta name=viewport content=width=device-width, initial-scale=1.0>
    <title>Usuários</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<body>
    <header>
        <?php
        session_start();
        if (isset($_SESSION['username']) && $_SESSION['username'] === 'admtm85') {
        ?>
            <!-- Inicio do Conteúdo para o ADM -->
            <nav>
                <i class="ph ph-list"></i><!-- ícone de menu -->
                <ul>
                    <li><a href="/sistemackc/admtm85/menu"><img src="../views/Img/ImgSistema/logoCKC.png" alt="logo do CKC"></a></li>
                    <li><a href="/sistemackc/admtm85/usuario">Usuarios</a></li>
                    <li><a href="#">Corridas</a></li>
                    <li><a href="#">Kartodromos</a></li>
                    <li><a href="#">Resultados</a></li>

                    <li>
                        <?php
                        if (isset($_SESSION['username'])) {
                            echo "<p>Olá, " . $_SESSION['username'] . "</p>";
                            echo "<ul><li><a href='/sistemackc/logout'>Logout</a></li>";
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
    <h1>CRUD dos Usuarios</h1>

    <table class='table table-striped table-bordered '>
        <thead class='thead-dark'>
            <tr>
                <th>Foto de Perfil</th>
                <th>ID</th>
                <th>Nome</th>
                <th>Sobrenome</th>
                <th>CPF</th>
                <th>Email</th>
                <th>Senha</th>
                <th>Peso</th>
                <th>Data de nascimento</th>
                <th>Genero</th>
                <th>Telefone</th>
                <th>Data de Registro</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($usuarios as $usuario) {
                echo "<tr>";
                echo "<td><img style='width: 120px;' src='/sistemackc/views/Img/ImgUsuario/" . $usuario['Foto_perfil'] . "' alt='Imagem de " . $usuario['Nome'] . "'></td>";
                echo "<td>" . $usuario['Id'] . "</td>";
                echo "<td>" . $usuario['Nome'] . "</td>";
                echo "<td>" . $usuario['Sobrenome'] . "</td>";
                echo "<td>" . $usuario['Cpf'] . "</td>";
                echo "<td>" . $usuario['Email'] . "</td>";
                echo "<td>" . substr($usuario['Senha'], 0, 5) . " ...</td>";
                echo "<td>" . $usuario['Peso'] . "</td>";
                $dataNascimento = new DateTime($usuario['Data_nascimento']);
                echo "<td>" . $dataNascimento->format('d/m/Y') . "</td>";
                echo "<td>" . $usuario['Genero'] . "</td>";
                echo "<td>" . $usuario['Telefone'] . "</td>";
                echo "<td>" . $usuario['Data_registro'] . "</td>";
                echo "<td>
                <a class='btn btn-primary' href='./usuario/{$usuario["Id"]}'>Editar</a>
                <button class='btn btn-danger' onclick='confirmarExclusao({$usuario["Id"]}, \"{$usuario["Nome"]}\", \"{$usuario["Sobrenome"]}\")'>Excluir</button>
                </td>";
                echo "</tr>";
            }
            echo "</table>";
            ?>
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
</body>


</html>