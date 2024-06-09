<?php

require_once 'models/Resultado.php';
require_once 'models/Usuario.php';
require_once 'models/Campeonato.php';
require_once 'models/Corrida.php';
require_once 'models/Kartodromo.php';

class ClassificacaoController extends RenderView
{
    public function __construct()
    {
        // Verifica se a requisição é uma chamada AJAX - Usado na Atualizacao e Exclui individual de um Resultado
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            if (isset($_POST['funcao'])) {
                $funcao = $_POST['funcao'];
                switch ($funcao) {
                    case 'excluirUmResultado':
                        if (isset($_POST['excluir_resultado_id'])) {
                            $idResultado = $_POST['excluir_resultado_id'];
                            $this->excluirUmResultado($idResultado);
                        } else {
                            echo "Erro: ID do resultado não fornecido.";
                        }
                        break;
                    default:
                        echo "Erro: Função desconhecida.";
                        break;
                }
                exit(); 
            }
        }
    }

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
                $corridasEncontradas = $corridaModel->selecionarTodasAsCorridasComNomesEEnderecos('data');
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
            'campeonatos' => isset($campeonatos) ? $campeonatos : []
        ]);
    }

    public function exibirResultadoUsuario() {
        $url = $_SERVER['REQUEST_URI'];

        $partesUrl = explode('/', $url);
    
        $idCorrida = isset($partesUrl[4]) ? $partesUrl[4] : '';

        $this->exibir($idCorrida, 'usuario', NULL);
    }

    public function exibir($idCorrida, $local = NULL, $tipoResultado = NULL)
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $resultadoModel = new Resultado();

        //Verificar se ja tem Cadastro
        $resultadosExistentes = $resultadoModel->verificarResultadosExistentes($idCorrida);
        
        if (!$resultadosExistentes && $local != 'usuario') {
            echo "<script>
                if (confirm('Atenção! Não existe resultado cadastrado para esta corrida.')) {
                    window.location.href = '/sistemackc/admtm85/resultado/';
                } else {
                    window.location.href = '/sistemackc/admtm85/resultado/';
                }
            </script>";
            exit();
        }

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

        //Verificar se ja tem Cadastro
        $resultadosExistentes = $resultadoModel->verificarResultadosExistentes($idCorrida);
        
        if ($resultadosExistentes) {
            echo "<script>
                if (confirm('Atenção! Já existem resultados cadastrados para esta corrida. Deseja atualizar os resultados ou adicionar novos pilotos?')) {
                    window.location.href = '/sistemackc/admtm85/resultado/atualizar/' + $idCorrida;
                } else {
                    window.location.href = '/sistemackc/admtm85/resultado/';
                }
            </script>";
            exit();
        }

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
        $resultadoModel = new Resultado();

        // Verificar se já tem Cadastro
        $resultadosExistentes = $resultadoModel->verificarResultadosExistentes($idCorrida);

        if (!$resultadosExistentes) {
            echo "<script>
                if (confirm('Atenção! Não existe resultado cadastrado para esta corrida.')) {
                    window.location.href = '/sistemackc/admtm85/resultado/';
                } else {
                    window.location.href = '/sistemackc/admtm85/resultado/';
                }
            </script>";
            exit();
        }

        // Alterar de todos os dados de uma vez
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $posicoes = $_POST['posicoes'];
            $pilotos = $_POST['pilotos'];
            $melhor_tempo = $_POST['melhor_tempo'];
            $pontuacoes = $_POST['pontuacao'];
            $ids = $_POST['ids'];

            $vetorAtualizacao = [];
            $vetorCadastro = [];

            foreach ($ids as $i => $id) {
                if (!empty($id)) {
                    $vetorAtualizacao[] = [
                        'id' => $id,
                        'piloto' => $pilotos[$i],
                        'posicao' => $posicoes[$i],
                        'melhor_tempo' => $melhor_tempo[$i],
                        'pontuacao' => $pontuacoes[$i]
                    ];
                } else {
                    $vetorCadastro[] = [
                        'piloto' => $pilotos[$i],
                        'posicao' => $posicoes[$i],
                        'melhor_tempo' => $melhor_tempo[$i],
                        'pontuacao' => $pontuacoes[$i]
                    ];
                }
            }

            // Processar atualizações
            foreach ($vetorAtualizacao as $resultadoParaAtualizar) {
                $resultadoModel->alterarResultado(
                    $resultadoParaAtualizar['id'],
                    $resultadoParaAtualizar['piloto'],
                    $resultadoParaAtualizar['posicao'],
                    $resultadoParaAtualizar['melhor_tempo'],
                    $resultadoParaAtualizar['pontuacao']
                );
            }

            // Processar novos cadastros
            foreach ($vetorCadastro as $resultadoParaCadastrar) {
                $resultadoModel->inserirResultado(
                    $resultadoParaCadastrar['piloto'],
                    $idCorrida,
                    $resultadoParaCadastrar['melhor_tempo'],
                    $resultadoParaCadastrar['posicao'],
                    $resultadoParaCadastrar['pontuacao']
                );
            }
        }

        $corridaModel = new Corrida();
        $usuarioModel = new Usuario();

        $dadosCorrida = $corridaModel->selecionarCorridaPorIdComNomeDoCamp($idCorrida);
        $nomeAbreviado = empty($dadosCorrida) ? '' : $corridaModel->definirAbreviacao($dadosCorrida['Nome_Campeonato']);
        $dadosResultados = $resultadoModel->selecionarResultadoPorCorridaId($idCorrida);
        

        $usuarios = $usuarioModel->obterNomeESobrenomeDosUsuarios();
            $this->carregarViewComArgumentos( 'adm/atualizarResultado', [
                'dadosCorrida' => isset($dadosCorrida) ? $dadosCorrida : [],
                'usuarioModel' => $usuarioModel,
                'nomeAbreviado' => $nomeAbreviado,
                'dadosResultado' => $dadosResultados,
                'usuarios' => isset($usuarios) ? $usuarios : null,
                'classe' => isset($classe) ? $classe : null,
                'feedback' => isset($feedback) ? $feedback : null,
                'urlParaRedirecionar' => isset($urlParaRedirecionar) ? $urlParaRedirecionar : ''
            ]);
    }

    public function excluir($idCorrida)
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $resultadoModel = new Resultado();
        $corridaModel = new Corrida();
        $usuarioModel = new Usuario();

        //Verificar se ja tem Cadastro
        $resultadosExistentes = $resultadoModel->verificarResultadosExistentes($idCorrida);
        
        if (!$resultadosExistentes) {
            echo "<script>
                if (confirm('Atenção! Não existe resultado cadastrado para esta corrida.')) {
                    window.location.href = '/sistemackc/admtm85/resultado/';
                } else {
                    window.location.href = '/sistemackc/admtm85/resultado/';
                }
            </script>";
            exit();
        }

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

    public function excluirUmResultado($idResultado) {
        if (!isset($_SESSION)) {
            session_start();
        }

        $resultadoModel = new Resultado();
    
        $resultadoExcluido = $resultadoModel->excluirResultadoPiloto($idResultado);

        if ($resultadoExcluido === "Sucesso") {
            echo "Resultado excluído com sucesso!";
        } else {
            echo "Erro ao excluir resultado. Por favor, tente novamente mais tarde.";
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
