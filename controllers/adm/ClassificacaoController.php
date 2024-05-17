<?php

require_once 'models/Resultado.php';
require_once 'models/Usuario.php';
require_once 'models/Campeonato.php';
require_once 'models/Corrida.php';
require_once 'models/Kartodromo.php';

class ClassificacaoController extends RenderView {

    public function mostrarResultados() {
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

    public function cadastrar($idCorrida) {
        if (!isset($_SESSION)) {
            session_start();
        }
    
        $dadosPilotos = [];
        $resultadoModel = new Resultado();
    
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
                        "Cadastrado"
                    );
                }
                // Redirecionar para a pagina de resultados se der tudo certo
                header("Location: /sistemackc/admtm85/resultado");
                exit();
            } else {
                $feedback = $feedbackInsercaoErro;
            }
        }
    
        $corridaModel = new Corrida();
        $usuarioModel = new Usuario();
    
        $dadosCorrida = $corridaModel->selecionarCorridaPorIdComNomeDoCamp($idCorrida);
        $nomeAbreviado = $corridaModel->definirAbreviacao($dadosCorrida['Nome_Campeonato']);
        $dadosUsuarios = $usuarioModel->obterNomeESobrenomeDosUsuarios();
    
        $this->carregarViewComArgumentos('adm/cadastrarResultado', [
            'dadosCorrida' => $dadosCorrida,
            'usuarios' => $dadosUsuarios,
            'nomeAbreviado' => $nomeAbreviado,
            'dados' => $dadosPilotos,
            'classe' => isset($classe) ? $classe : null,
            'feedback' => isset($feedback) ? $feedback : null
        ]);
    }

    public function atualizar() {
        $this->carregarView('adm/atualizarResultado');
    }

    public function teste() {
        $resultado = new Resultado();
        $resultado = $resultado->teste();

        $this->carregarViewComArgumentos('teste', [
            'feedback' => $resultado['feedback'],
            'classe' => $resultado['classe'],
            'classe2' => 'semCadastro'

        ]);
    }

    
}
?>