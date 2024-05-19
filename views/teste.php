<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/sistemackc/views/Img/ImgIcones/crash_icon.ico" type="image/x-icon">
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
            echo "<div class='container-feedback'>";
            if($classe == 'erro'){
                echo "<span class='$classe'><i class='ph ph-warning-circle'></i><strong>$feedback</strong></span>";
            }
            echo "</div>";
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
            if($classe2 == 'semCadastro'){
                echo "<span class='$classe2'><i class='ph ph-warning-circle'></i><strong>$feedback</strong></span>";
            }
                echo "<a class='bt-redirecionar' href='/sistemackc/admtm85/campeonato'>Cadastrar campeonato</a><br>";
                echo "<a class='bt-redirecionar' href='/sistemackc/admtm85/kartodromo'>Cadastrar kartodromo</a>";
                echo "</div>";
        }
    ?>
    
</body>
</html>