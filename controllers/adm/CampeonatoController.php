<?php

require_once 'models/Campeonato.php';

class CampeonatoController extends RenderView
{
    public function mostrarCampeonatos() {
        
        $campeonatoModel = new Campeonato();
    
        // Verifica se tem requisição GET, por conta do filtro
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $filtroNome = isset($_GET['filtroNome']) ? $_GET['filtroNome'] : '';
    
            if (!empty($filtroNome)) {
                $consulta = $campeonatoModel->consultarCampeonatoPorFiltro($filtroNome);
    
                $campeonatos = $consulta['campeonatos'];
                $feedback = $consulta['feedback'];
                $classe = $consulta['classe'];
    
            } else {
                $campeonatos = $campeonatoModel->selecionarTodosOsCampeonatos();
                if (empty($campeonatos)) {
                    $feedback = 'Nenhum campeonato encontrado.';
                    $classe = 'alert alert-danger';
                }
            }
        }
    
        $this->carregarViewComArgumentos('adm/crudCampeonato', [
            'campeonatos' => isset($campeonatos) ? $campeonatos : [],
            'feedback' => isset($feedback) ? $feedback : '',
            'classe' => isset($classe) ? $classe : ''
        ]);
    }

    public function cadastrar()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome = $_POST['nome'];
            $dataInicio = $_POST['dataInicio'];
            $dataTermino = $_POST['dataTermino'];
            $feedback = "";
        
            $dataInicioFormatada = date('Y-m-d', strtotime($dataInicio));
            $dataTerminoFormatada = date('Y-m-d', strtotime($dataTermino));
            $dadosPreenchidos = [$nome, $dataInicio, $dataTermino];

            $novoCampeonato = new Campeonato();
            $validarData = $novoCampeonato->validarData($dataInicioFormatada, $dataTerminoFormatada); 

            if($validarData == "aceito") {
                //Cadastrando no BD
                $resultado = $novoCampeonato->inserirCampeonato($nome, $dataInicioFormatada, $dataTerminoFormatada);

                if ($resultado == "Sucesso") {
                    header('Location: /sistemackc/admtm85/campeonato');
                    exit();
                } else {
                    $feedback = $resultado;
                }
            } else {
                $feedback = $validarData;
            }
            $this->carregarViewComArgumentos('adm/cadastrarCampeonato', [
                'feedback' => $feedback,
                'classe' => "erro",
                'dados' => $dadosPreenchidos
            ]);
        } else {
            $this->carregarView('adm/cadastrarCampeonato');
        }
    } 
    

    public function atualizar($id) {
        if (!isset($_SESSION)) {
            session_start();
        }
        $campeonatoModel = new Campeonato();
        $infoCampeonato = $campeonatoModel->selecionarCampeonatoPorId($id);

        $feedback = "";
        $classe = "";
        $dados = [$infoCampeonato['Nome'], $infoCampeonato['Data_inicio'], $infoCampeonato['Data_termino']];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $nome = $_POST['nome'];
            $dataInicio = $_POST['dataInicio'];
            $dataTermino = $_POST['dataTermino'];
            /* Se quiser que retorne no formulario os dados antigos e ja salvos do sistema, retirar a linha de codigo abaixo */
            $dados = [$nome, $dataInicio, $dataTermino];
        
            $dataInicioFormatada = date('Y-m-d', strtotime($dataInicio));
            $dataTerminoFormatada = date('Y-m-d', strtotime($dataTermino));

            $validarData = $campeonatoModel->validarData($dataInicioFormatada, $dataTerminoFormatada); 

            if($validarData == "aceito") {
                //Alterar no BD
                $resultado = $campeonatoModel->alterarCampeonato($id, $nome, $dataInicioFormatada, $dataTerminoFormatada);

                if ($resultado == "Sucesso") {
                    header('Location: /sistemackc/admtm85/campeonato');
                    exit();
                } else {
                    $feedback = $resultado;
                    $classe = "erro";
                }
            } else {
                $feedback = $validarData;
                $classe = "erro";
            }
        }
        $this->carregarViewComArgumentos('adm/atualizarCampeonato', [
            'feedback' => $feedback,
            'classe' => $classe,
            'dados' => $dados
        ]);
    } 

    public function excluir($id) {
        if (!isset($_SESSION)) {
            session_start();
        }
        
        if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
            $campeonato = new Campeonato();

            $infoExcluido = $campeonato->selecionarCampeonatoPorId($id);
            $infoExcluido = $campeonato->excluirCampeonato($id);
            
            if($infoExcluido == "Sucesso") {
                header('Location: /sistemackc/admtm85/campeonato');
                exit();
            } else {
                $campeonatos = $campeonato->selecionarTodosOsCampeonatos();
                $this->carregarViewComArgumentos('adm/crudCampeonato', [
                    'feedback' => $infoExcluido,
                    'classe' => 'alert alert-danger',
                    'campeonatos' => $campeonatos
                ]);
            }
        }  
    }
    
}

?>