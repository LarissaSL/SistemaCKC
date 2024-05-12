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

    public function cadastrar() {
        $this->carregarView('adm/cadastrarResultado');
    }

    public function atualizar() {
        $this->carregarView('adm/atualizarResultado');
    }

    
}
?>