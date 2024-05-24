<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/sistemackc/views/Img/ImgIcones/crash_icon.ico" type="image/x-icon">

      <!-- Google Fonts -->
      <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">

    <link rel="icon" href="/sistemackc/views/Img/ImgIcones/crash_icon.ico" type="image/x-icon">

    <script src="https://unpkg.com/@phosphor-icons/web"></script> <!-- ONDE PEGUEI OS ICON TEMPORARIOS 'phosphor-icons' -->

    <script defer src="/sistemackc/views/Js/notificacao.js"></script> 
      <!-- Custom CSS -->
      <link rel="stylesheet" href="/sistemackc/views/Css/variaveis.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/CssUsuario/notificacoes.css">
    <title>Teste</title>
</head>

<body>

    <!-- 
        Classes que mais mando = 
            erro
            semCadastro 
            e a de erro do Bootstrap: 
            alert alert-danger 

            OBS.: Em alguns casos preciso mandar algo pra redirecionar o usuário, como o Jeito 3 demonstra
    -->
    <h1>Jeito 1:</h1>
    <?php
    if (isset($feedback) && !empty($feedback)) {
        echo '
<div class="nofifications">
    <div class="toast success">
        <div class="column">
            <i class="ph-fill ph-warning"></i><!--icone de exclamação-->
            <span> '. $feedback .'</span>
        </div>
        <i class="ph ph-x"></i><!--iconde de X -->
    </div>
</div>';
    }
    ?>

    <h1>Jeito 2:</h1>
    <?php
    if (isset($classe) && $classe == 'erro') : ?>
        <p class="<?php echo $classe ?>"><?php echo $feedback ?></p>
    <?php endif ?>

    <h1>Jeito 3:</h1>
    <?php
    if (isset($feedback) && !empty($feedback) && $classe2 == "semCadastro") {
        echo "<div class='container-feedback'>";
        if ($classe2 == 'semCadastro') {
            echo "<span class='$classe2'><i class='ph ph-warning-circle'></i><strong>$feedback</strong></span>";
        }
        echo "<a class='bt-redirecionar' href='/sistemackc/admtm85/campeonato'>Cadastrar campeonato</a><br>";
        echo "<a class='bt-redirecionar' href='/sistemackc/admtm85/kartodromo'>Cadastrar kartodromo</a>";
        echo "</div>";
    }
    ?>

</body>

</html>