<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado da Corrida</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <script defer src="/sistemackc/views/Js/notificacao.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/sistemackc/views/Css/CssUsuario/notificacoes.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/variaveis.css">
    <link rel="stylesheet" href="/sistemackc/views/Css/CssAdm/resultadoExibir.css">
    <link rel="icon" href="/sistemackc/views/Img/ImgIcones/crash_icon.ico" type="image/x-icon">

    <script defer src="/sistemackc/views/Js/nav.js"></script>
</head>

<body>
    <?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
    ?>
        <header class="header">
            <nav class="nav">
                <a class="logo" href="/sistemackc/">
                    <img src="/sistemackc/views/Img/ImgSistema/logoCKC.png" alt="logo do CKC">
                </a>
                <button class="hamburger"></button>
                <ul class="nav-list">
                    <li><a href="/sistemackc/admtm85/usuario">Usuarios</a></li>
                    <li><a href="/sistemackc/admtm85/campeonato">Campeonatos</a></li>
                    <li><a href="/sistemackc/admtm85/corrida">Corridas</a></li>
                    <li><a href="/sistemackc/admtm85/resultado">Resultados</a></li>
                    <li><a href="/sistemackc/admtm85/kartodromo">Kartodromos</a></li>

                    <li class="drop-down">
                        <a href='#' class='dropdown-toggle'>Olá, <?php echo $_SESSION['nome']; ?><i class='ph ph-caret-down'></i></a>
                        <ul class='dropdown-menu'>
                            <li><a href='/sistemackc/usuario/<?php echo $_SESSION['id']; ?>'>Perfil</a></li>
                            <li><a href='/sistemackc/admtm85/menu'>Menu</a></li>
                            <li><a href='/sistemackc/logout'>Sair</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </header>

        <main>
            <div class="background-image"></div>
            <h1 class="titulo">Classificação da Corrida</h1>
            <?php
            if (isset($feedback) && $feedback != '') {
                echo "<div class='container-feedback'>";
                echo '
                    <div class="nofifications">
<<<<<<< HEAD
                        <div class="toast alerta">
=======
                    <div class="toast success">
>>>>>>> a747ce414197091e30f776c6112dfa9fd3a4e60b
                            <div class="column">
                            <i class="ph-fill ph-warning"></i><!--icone de exclamação-->
                            <span class="' . $classe . '">' . $feedback . '</span>
                            </div>
                            <i class="ph ph-x" onclick="(this.parentElement).remove()"></i><!--iconde de X -->
                            </div>
                    </div>';
                echo '<a class="btn-voltar" href="/sistemackc/admtm85/resultado">Voltar</a>';
                echo "</div>";
            } else {
            ?>

                <div class="containerInformacoes">
                    <div class="containerImagem">
                        <img class="fundoImg" src="/sistemackc/Views/Img/ImgTelas/fundo.png" alt="fundo da foto do Crash">
                        <img class="imagem" src="/sistemackc/Views/Img/ImgTelas/crash.png" alt="foto do Crash">
                    </div>
                    <div class="informacoesCorrida">
                        <div class="title">
                            <span><?php echo $dadosCorrida['Nome_Campeonato']; ?></span>
                        </div>
                        <?php $classeH2 = strtolower($nomeAbreviado) . $dadosCorrida['Categoria']; ?>
                        <h2>
                            <strong class="<?php echo $classeH2; ?>"><?php echo strtoupper($nomeAbreviado) ?></strong>
                            <?php echo $dadosCorrida['Nome']; ?>
                        </h2>
                        <div class="date">
                            <span><?php echo date('d/m/Y', strtotime($dadosCorrida['Data_corrida'])); ?></span>
                        </div>
                        <div class="categoria">
                            <span class="categoria <?php echo 'cat' . $dadosCorrida['Categoria']; ?>">
                                <?php
                                if ($dadosCorrida['Categoria'] == "Livre") {
                                    echo $dadosCorrida['Categoria'];
                                } else {
                                    echo $dadosCorrida['Categoria'] . " kg";
                                }
                                ?>

                            </span>
                        </div>
                    </div>
                </div>

                <div class="ranking-container">
                    <p>Confira abaixo a classificação da corrida:</p>
                    <?php
                    foreach ($dadosResultado as $resultado) :
                        $usuario = $usuarioModel->consultarUsuarioPorId($resultado['Usuario_id']);
                        $nome = $usuario['Nome'];
                        $sobrenome = $usuario['Sobrenome'];
                        $foto = $usuario['Foto'] != NULL ? $usuario['Foto'] : 'perfil_branco.png';
                    ?>
                        <div class="pilot">
                            <div class="pilot-img-container">
                                <img class="pilot-img" src="/sistemackc/views/Img/ImgUsuario/<?php echo $foto; ?>" alt="<?php echo $nome . ' ' . $sobrenome; ?>">
                            </div>
                            <div class="pilot-info posicao<?php echo $resultado['Posicao']; ?>">
                                <span class="posicaoPiloto"><?php echo $resultado['Posicao']; ?>º</span>
                                <span class="nomePiloto"><?php echo $nome . ' ' . $sobrenome; ?></span>
                                <span><?php echo $resultado['Melhor_tempo']; ?></span>
                                <span><?php echo $resultado['Pontuacao_total']; ?> pts</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="botoes">
                    <a class="btn-editar" href="/sistemackc/admtm85/resultado/atualizar/<?php echo $dadosCorrida['Id']; ?>">Editar</a>
                    <button class="btn-danger" onclick="confirmarExclusao(<?php echo $dadosCorrida['Id']; ?>, '<?php echo $dadosCorrida['Nome']; ?>', '<?php echo $dadosCorrida['Nome_Campeonato']; ?>')">Excluir</button>
                </div>
            <?php } ?>
        </main>

        <script>
            function confirmarExclusao(id, nome, campeonato) {
                if (confirm(`Tem certeza que deseja excluir TODOS os registros:\n${campeonato} - ${nome} \n\nOBS.: Essa ação é irreversível.`)) {
                    window.location.href = '/sistemackc/admtm85/resultado/excluir/corrida/' + id;
                }
            }
        </script>

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
    <?php } else { ?>
        <div class="containerAcesso">
            <h1>Acesso não autorizado<i class="ph-fill ph-warning"></i></h1>
            <p>Apenas administradores do Sistema tem acesso</p>
        </div>
    <?php } ?>
</body>

</html>