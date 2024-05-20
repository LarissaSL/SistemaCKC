<?php

require_once 'models/Resultado.php';
require_once 'models/Usuario.php';
require_once 'models/Campeonato.php';
require_once 'models/Corrida.php';
require_once 'models/Kartodromo.php';

class ClassificacaoController extends RenderView
{

    public function mostrarResultados()
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $corridaModel = new Corrida();
        $campeonatoModel = new Campeonato();

        $corridas = $corridaModel->selecionarTodasAsCorridasComNomes();
        $campeonatos = $campeonatoModel->selecionarNomesEIdsDosCampeonatos();
        $feedback = '';
        $classe = '';

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
                $corridas = $corridaModel->selecionarTodasAsCorridasComNomes();
                if (empty($corridas)) {
                    $feedback = 'Nenhuma corrida cadastrada.';
                    $classe = 'alert alert-danger';
                }
            }
        }

        $this->carregarViewComArgumentos('adm/crudResultado', [
            'corridas' => $corridas,
            'feedback' => $feedback,
            'classe' => $classe,
            'campeonatos' => $campeonatos
        ]);
    }

    public function exibir($idCorrida, $local = null)
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
        }

        if (empty($dadosResultados)) {
            $feedback = "Nenhum resultado cadastrado para essa corrida";
            $classe = "erro";
        } else {
            $definirAView = $local == null ? 'adm/exibirResultado' : 'adm/atualizarResultado';
            $usuarios = $local == null ? null : $usuarioModel->obterNomeESobrenomeDosUsuarios();
            $this->carregarViewComArgumentos( $definirAView, [
                'dadosCorrida' => $dadosCorrida,
                'usuarioModel' => $usuarioModel,
                'nomeAbreviado' => $nomeAbreviado,
                'dadosResultado' => $dadosResultados,
                'usuarios' => isset($usuarios) ? $usuarios : null,
                'classe' => isset($classe) ? $classe : null,
                'feedback' => isset($feedback) ? $feedback : null
            ]);
        }
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
