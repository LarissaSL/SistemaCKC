<?php

require_once 'models/Resultado.php';
require_once 'models/Usuario.php';
require_once 'models/Campeonato.php';
require_once 'models/Corrida.php';
require_once 'models/Kartodromo.php';

class ClassificacaoController extends RenderView
{

    // ADM
    public function mostrarResultados()
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $corridaModel = new Corrida();
        $campeonatoModel = new Campeonato();

        $campeonatos = $campeonatoModel->selecionarNomesEIdsDosCampeonatos();

        // Verifica se tem requisição GET, por conta do filtro
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $filtroCampeonato = isset($_GET['filtroCampeonato']) ? $_GET['filtroCampeonato'] : '';
            $filtroMes = isset($_GET['filtroMes']) ? $_GET['filtroMes'] : '';
            $filtroAno = isset($_GET['filtroAno']) ? $_GET['filtroAno'] : '';
            $filtroDia = isset($_GET['filtroDia']) ? $_GET['filtroDia'] : '';

            if (!empty($filtroCampeonato) || (!empty($filtroMes)) || !empty($filtroAno) || !empty($filtroDia)) {
                $consulta = $corridaModel->consultarCorridaPorFiltroParaResultado($filtroCampeonato, $filtroMes, $filtroAno, $filtroDia);

                $corridas = $consulta['corridas'];
                $feedback = $consulta['feedback'];
                $classe = $consulta['classe'];
            } else {
                $corridas = $corridaModel->selecionarTodasAsCorridasComNomes('data');
                if (empty($corridas)) {
                    $feedback = 'Nenhuma corrida encontrada.';
                    $classe = 'alert alert-danger';
                }
            }
        }

        $this->carregarViewComArgumentos('adm/crudResultado', [
            'corridas' => isset($corridas) ? $corridas : [],
            'feedback' => isset($feedback) ? $feedback : '',
            'classe' => isset($classe) ? $classe : '',
            'campeonatos' => isset($campeonatos) ? $campeonatos : []
        ]);
    }

    // Usuario
    public function exibirTodosOsResultados() {
        $corridaModel = new Corrida();
        $campeonatoModel = new Campeonato();
    
        $campeonatos = $campeonatoModel->selecionarNomesEIdsDosCampeonatos();
        $corridasComResultados = array(); 
    
        // Verifica se tem requisição GET, por conta do filtro
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $filtroCampeonato = isset($_GET['filtroCampeonato']) ? $_GET['filtroCampeonato'] : '';
            $filtroMes = isset($_GET['filtroMes']) ? $_GET['filtroMes'] : '';
            $filtroAno = isset($_GET['filtroAno']) ? $_GET['filtroAno'] : '';
            $filtroDia = isset($_GET['filtroDia']) ? $_GET['filtroDia'] : '';
            $filtroClassificacao = isset($_GET['filtroClassificacao']) ? $_GET['filtroClassificacao'] : 'corrida'; 

            if (!empty($filtroCampeonato) || !empty($filtroMes) || !empty($filtroAno) || !empty($filtroDia)) {
                $consulta = $corridaModel->consultarCorridaPorFiltroParaResultado($filtroCampeonato, $filtroMes, $filtroAno, $filtroDia);

                if (!empty($consulta['corridas'])) {
                    // Tratar para exibir corridas com resultados
                    $corridasEncontradas = $consulta['corridas'];
                     
                    foreach ($corridasEncontradas as $corrida) {
                        if ($corridaModel->corridaTemResultado($corrida['Id'])) {
                            $corridasComResultados[] = $corrida; 
                        }
                    }

                    // Construir HTML para as corridas com resultados
                    if (!empty($corridasComResultados)) {
                        $corridas = $corridaModel->construirHtml($corridasComResultados);
                    
                    // Caso tenha corridas com o Filtro, mas não tenha resultados nessas corridas
                    } else {
                        $feedback = 'Sentimos muito, mas as corridas com esse filtro, ainda não tem Resultado registrado.';
                        $classe = 'erro';
                    }
  
                // Caso não tenha encontrado as corridas com algum dos filtros
                } else {
                    $feedback = 'Nenhuma corrida e resultado encontrados para o filtro desejado.';
                    $classe = 'erro';
                }
            } else {
                // Caso nao tenha filtro, verifica se tem corridas no sistema e trata para mostrar apenas as corridas com Resultados
                $corridasEncontradas = $corridaModel->selecionarTodasAsCorridasComNomesEEnderecos();
                if (!empty($corridasEncontradas)){
                    
                foreach ($corridasEncontradas as $corrida) {
                    if ($corridaModel->corridaTemResultado($corrida['Id'])) {
                        $corridasComResultados[] = $corrida; 
                    }
                }

                // Construir HTML para as corridas com resultados
                $corridas = $corridaModel->construirHtml($corridasComResultados);
                } else {
                    $feedback = 'Nenhuma corrida encontrada.';
                    $classe = 'erro';
                }
            }
        }
    
        $this->carregarViewComArgumentos('classificacao', [
            'corridas' => isset($corridas) ? $corridas : [],
            'feedback' => isset($feedback) ? $feedback : '',
            'classe' => isset($classe) ? $classe : '',
            'tipoDeExibicao' => strtolower($filtroClassificacao),
            'campeonatos' => isset($campeonatos) ? $campeonatos : []
        ]);
    }

    public function exibirResultadoUsuario() {
        $url = $_SERVER['REQUEST_URI'];

        $partesUrl = explode('/', $url);

        $tipoDeExibicao = $partesUrl[3] == 'corrida' ?  NULL : 'geral';
    
        $idCorrida = isset($partesUrl[4]) ? $partesUrl[4] : '';


        $this->exibir($idCorrida, 'usuario', $tipoDeExibicao);
    }

    public function exibir($idCorrida, $local = NULL, $tipoResultado = NULL)
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $resultadoModel = new Resultado();
        $corridaModel = new Corrida();
        $usuarioModel = new Usuario();

        $dadosCorrida = $corridaModel->selecionarCorridaPorIdComNomeDoCamp($idCorrida);
        $nomeAbreviado = empty($dadosCorrida) ? '' : $corridaModel->definirAbreviacao($dadosCorrida['Nome_Campeonato']);

        // colocar a funcao de calcular classificacao geral
        $dadosResultados = $tipoResultado == null ? $resultadoModel->selecionarResultadoPorCorridaId($idCorrida) : $resultadoModel->selecionarResultadoPorCorridaId($idCorrida);
        if (empty($dadosCorrida)) {
            $feedback = "Erro ao selecionar os dados da corrida";
            $classe = "erro";
        }

        // Definindo a view de exibicao
        if($local == null) {
            $definirAView = 'adm/exibirResultado';
            $urlParaRedirecionar = '/sistemackc/admtm85/resultado';
        } elseif ($local == 'usuario') {
            $definirAView = 'usuario/exibirResultadoUsuario';
            $urlParaRedirecionar = '/sistemackc/classificacao';
        } else {
            $definirAView = 'adm/atualizarResultado';
            $urlParaRedirecionar = '/sistemackc/admtm85/resultado/atualizar/5';
        }

        if (empty($dadosResultados)) {
            $feedback = "Não existe resultado cadastrado para essa corrida";
            $classe = "erro";
        }

        $usuarios = $local == null ? null : $usuarioModel->obterNomeESobrenomeDosUsuarios();
            $this->carregarViewComArgumentos( $definirAView, [
                'dadosCorrida' => isset($dadosCorrida) ? $dadosCorrida : [],
                'usuarioModel' => $usuarioModel,
                'nomeAbreviado' => $nomeAbreviado,
                'dadosResultado' => $dadosResultados,
                'tipoDeClassificacao' => $tipoResultado != null ? $tipoResultado : '',
                'usuarios' => isset($usuarios) ? $usuarios : null,
                'classe' => isset($classe) ? $classe : null,
                'feedback' => isset($feedback) ? $feedback : null,
                'urlParaRedirecionar' => isset($urlParaRedirecionar) ? $urlParaRedirecionar : ''
            ]);
    }

    public function cadastrar($idCorrida)
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $dadosPilotos = [];
        $resultadoModel = new Resultado();
        $corridaModel = new Corrida();
        $usuarioModel = new Usuario();

        $dadosCorrida = $corridaModel->selecionarCorridaPorIdComNomeDoCamp($idCorrida);
        $nomeAbreviado = $corridaModel->definirAbreviacao($dadosCorrida['Nome_Campeonato']);
        $dadosUsuarios = $usuarioModel->obterNomeESobrenomeDosUsuarios();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $posicoes = $_POST['posicoes'];
            $pilotos = $_POST['pilotos'];
            $melhor_tempo = $_POST['melhor_tempo'];
            $pontuacoes = $_POST['pontuacao'];

            // Verificar duplicatas de resultados
            $verificacao = $resultadoModel->verificarDuplicatas(
                $posicoes,
                $pilotos,
                $melhor_tempo,
                $pontuacoes,
                $idCorrida
            );

            $houveErro = $verificacao['houveErro'];
            $classe = $verificacao['classe'];
            $feedbackInsercaoErro = $verificacao['feedback'];
            $dadosParaInserir = $verificacao['dadosParaInserir'];

            // Popular os dados dos Pilotos caso tenha erro
            foreach ($posicoes as $i => $posicaoPiloto) {
                $dadosPilotos[] = array(
                    $posicaoPiloto,
                    $pilotos[$i],
                    $melhor_tempo[$i],
                    $pontuacoes[$i]
                );
            }

            if (!$houveErro) {
                foreach ($dadosParaInserir as $dados) {
                    $resultadoModel->inserirResultado(
                        $dados['idPiloto'],
                        $dados['idCorrida'],
                        $dados['melhorTempoPiloto'],
                        $dados['posicaoPiloto'],
                        $dados['pontuacaoPiloto'],
                        1
                    );
                }
                // Redirecionar para a pagina de resultados se der tudo certo
                header("Location: /sistemackc/admtm85/resultado");
                exit();
            } else {
                $feedback = $feedbackInsercaoErro;
            }
        }

        $this->carregarViewComArgumentos('adm/cadastrarResultado', [
            'dadosCorrida' => $dadosCorrida,
            'usuarios' => $dadosUsuarios,
            'nomeAbreviado' => $nomeAbreviado,
            'dados' => $dadosPilotos,
            'classe' => isset($classe) ? $classe : null,
            'feedback' => isset($feedback) ? $feedback : null
        ]);
    }

    public function atualizar($idCorrida)
    {
        // Alterar de todos os dados de uma vez
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultadoModel = new Resultado();
            
            $posicoes = $_POST['posicoes'];
            $pilotos = $_POST['pilotos'];
            $melhor_tempo = $_POST['melhor_tempo'];
            $pontuacoes = $_POST['pontuacao'];
            $ids = $_POST['ids'];
    
            foreach ($ids as $i => $id) {
                $resultadoModel->alterarResultado(
                    $id,
                    $pilotos[$i],
                    $posicoes[$i],
                    $melhor_tempo[$i],
                    $pontuacoes[$i]
                );
            }
            // Redirecionar para a página de resultados após a atualização
            header("Location: /sistemackc/admtm85/resultado");
            exit();
        }

        $this->exibir($idCorrida, "viewDeAtualizar");
    }

    public function excluir($idCorrida)
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $resultadoModel = new Resultado();
        $corridaModel = new Corrida();
        $usuarioModel = new Usuario();

        $dadosCorrida = $corridaModel->selecionarCorridaPorIdComNomeDoCamp($idCorrida);
        $nomeAbreviado = $corridaModel->definirAbreviacao($dadosCorrida['Nome_Campeonato']);
        $dadosResultados = $resultadoModel->selecionarResultadoPorCorridaId($idCorrida);

        if (empty($dadosCorrida)) {
            $feedback = "Erro ao selecionar os dados da corrida";
            $classe = "erro";
            $this->carregarViewComArgumentos('adm/telaConfirmacaoExcluirResultado', [
                'dadosCorrida' => $dadosCorrida,
                'usuarioModel' => $usuarioModel,
                'nomeAbreviado' => $nomeAbreviado,
                'dadosResultado' => $dadosResultados,
                'classe' => $classe,
                'feedback' => $feedback
            ]);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultado = $resultadoModel->excluirResultado($idCorrida);

            if ($resultado == "Sucesso") {
                header("Location: /sistemackc/admtm85/resultado");
                exit();
            } else {
                $feedback = "Erro ao tentar excluir resultados, tente novamente";
                $classe = "erro";

                $this->carregarViewComArgumentos('adm/telaConfirmacaoExcluirResultado', [
                    'dadosCorrida' => $dadosCorrida,
                    'usuarioModel' => $usuarioModel,
                    'nomeAbreviado' => $nomeAbreviado,
                    'dadosResultado' => $dadosResultados,
                    'classe' => $classe,
                    'feedback' => $feedback
                ]);
            }
        } else {
            if (!empty($dadosResultados)) {
                $this->carregarViewComArgumentos('adm/telaConfirmacaoExcluirResultado', [
                    'dadosCorrida' => $dadosCorrida,
                    'usuarioModel' => $usuarioModel,
                    'nomeAbreviado' => $nomeAbreviado,
                    'dadosResultado' => $dadosResultados,
                    'classe' => isset($classe) ? $classe : null,
                    'feedback' => isset($feedback) ? $feedback : null
                ]);
            } else {
                header("Location: /sistemackc/admtm85/resultado");
                exit();
            }
        }
    }

    public function excluirDireto($idCorrida)
    {
        $resultadoModel = new Resultado();
        $resultado = $resultadoModel->excluirResultado($idCorrida);

        if ($resultado == "Sucesso") {
            header("Location: /sistemackc/admtm85/resultado");
            exit();
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("Erro ao tentar excluir resultados, tente novamente");';
            echo '</script>';
        }
    }

    public function teste()
    {
        $resultado = new Resultado();
        $resultado = $resultado->teste();

        $this->carregarViewComArgumentos('teste', [
            'feedback' => $resultado['feedback'],
            'classe' => $resultado['classe'],
            'classe2' => 'semCadastro'

        ]);
    }
}
