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

    public function cadastrar($id) {
        if (!isset($_SESSION)) {
            session_start();
        }

        $dadosVerComoTa = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $posicoes = $_POST['posicoes'];
            $pilotos = $_POST['pilotos'];
            $qtd_voltas = $_POST['qtd_voltas'];
            $melhor_tempo = $_POST['melhor_tempo'];
            $advs = $_POST['advTotal'];
            $pontuacoes = $_POST['pontuacao'];
        
            $dadosVerComoTa = array();

            for ($i = 0; $i < count($posicoes); $i++) {
                $posicao = $posicoes[$i];
                $piloto = $pilotos[$i];
                $qtd_volta = $qtd_voltas[$i];
                $melhorTempo = $melhor_tempo[$i];
                $advs_piloto = $advs[$i];
                $pontuacao = $pontuacoes[$i];

                $dadosVerComoTa[] = array($posicao, $piloto, $qtd_volta, $melhorTempo, $advs_piloto, $pontuacao);
            }
        }

        $corridaModel = new Corrida();
        $usuarioModel = new Usuario();

        $dadosCorrida = $corridaModel->selecionarCorridaPorIdComNomeDoCamp($id);
        $nomeAbreviado = $corridaModel->definirAbreviacao($dadosCorrida['Nome_Campeonato']);
        $dadosUsuarios = $usuarioModel->obterNomeESobrenomeDosUsuarios();
        


        $this->carregarViewComArgumentos('adm/cadastrarResultado', [
            'dadosCorrida' => $dadosCorrida,
            'usuarios' => $dadosUsuarios,
            'nomeAbreviado' => $nomeAbreviado,
            'dados' => $dadosVerComoTa
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