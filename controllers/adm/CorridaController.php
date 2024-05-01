<?php

require_once 'models/Corrida.php';
require_once 'models/Campeonato.php';
require_once 'models/Kartodromo.php';


class CorridaController extends RenderView
{
    public function mostrarCorridas() {
        $corridaModel = new Corrida();
        $campeonatoModel = new Campeonato();

        $corridas = $corridaModel->selecionarTodasAsCorridasComNomes();
        $campeonatos = $campeonatoModel->selecionarNomesEIdsDosCampeonatos();
        $feedback = '';
        $classe = '';
    
        // Verifica se tem requisição GET, por conta do filtro
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $filtroNome = isset($_GET['filtroNome']) ? $_GET['filtroNome'] : '';
            $filtroCampeonato = isset($_GET['filtroCampeonato']) ? $_GET['filtroCampeonato'] : '';
            $filtroData = isset($_GET['filtroData']) ? $_GET['filtroData'] : '';
    
            if (!empty($filtroNome) || !empty($filtroCampeonato) || !empty($filtroData)) {
                $consulta = $corridaModel->consultarCorridaPorFiltro($filtroNome, $filtroCampeonato, $filtroData);
    
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
    
        $this->carregarViewComArgumentos('adm/crudCorridas', [
            'corridas' => $corridas,
            'feedback' => $feedback,
            'classe' => $classe,
            'campeonatos' => $campeonatos
        ]);
    }

    public function mostrarCorridasUsuario() {
        
        $corridaModel = new Corrida();

        $corridas = $corridaModel->construirHtml();

        if (empty($corridas)) {
            $this->carregarViewComArgumentos('etapas', [
                'feedback' => 'Nenhuma corrida Cadastrada',
                'classe' => 'erro'
            ]);
        } else {
            $this->carregarViewComArgumentos('etapas', [
                'corridas' => $corridas,
                'classe' => 'Sucesso'
            ]);
        }
    }

    public function cadastrar()
    {
        $campeonatoModel = new Campeonato();
        $kartodromoModel = new Kartodromo();

        $dadosCampeonatos = $campeonatoModel->selecionarNomesEIdsDosCampeonatos();
        $dadosKartodromos = $kartodromoModel->selecionarNomesEIdsDosKartodromos();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $campeonato_id = $_POST['campeonato_id'];
            $kartodromo_id = $_POST['kartodromo_id'];
            $nome = $_POST['nome'];
            $categoria = $_POST['categoria'];
            $dataCorrida = $_POST['dataCorrida'];
            $horario = $_POST['horario'];
            $tempoCorrida = $_POST['tempoCorrida'];
            $feedback = "";
        
            $dataCorridaFormatada = date('Y-m-d', strtotime($dataCorrida));
            $tempoCorridaFormatada = date('H:i:s', strtotime($tempoCorrida));

            if ($campeonato_id == "" || $kartodromo_id == "") {
                $mensagem = "";
                $dados = [$nome, $campeonato_id, "", $kartodromo_id, "",  $categoria, $dataCorrida, $horario, $tempoCorrida];
                
                if ($campeonato_id == "" && $kartodromo_id == "") {
                    $mensagem = "Selecione um Campeonato e Kartódromo, por favor. ";
                } elseif ($campeonato_id == "") {
                    $mensagem = "Selecione um Campeonato, por favor.";
                    $dados[4] = $nomeKartodromoSelecionado = $kartodromoModel->selecionarKartodromoPorId($kartodromo_id)['Nome'];
                } else {
                    $mensagem = "Selecione um Kartódromo, por favor.";
                    $dados[2] = $nomeCampeonatoSelecionado = $campeonatoModel->selecionarCampeonatoPorId($campeonato_id)['Nome'];
                }
                
                $this->carregarViewComArgumentos('adm/cadastrarCorrida', [
                    'feedback' => $mensagem,
                    'classe' => "erro",
                    'dados' => $dados,
                    'dadosCampeonatos' => $dadosCampeonatos,
                    'dadosKartodromos' => $dadosKartodromos
                ]);
                return;
            }

            $nomeCampeonatoSelecionado = $campeonatoModel->selecionarCampeonatoPorId($campeonato_id);
            $nomeKartodromoSelecionado = $kartodromoModel->selecionarKartodromoPorId($kartodromo_id);

            $dadosPreenchidos = [$nome, $campeonato_id, $nomeCampeonatoSelecionado['Nome'], $kartodromo_id, $nomeKartodromoSelecionado['Nome'],  $categoria, $dataCorrida, $horario, $tempoCorrida];

            $corridaModel = new Corrida();
            $validarCategoria = $corridaModel->validarCategoria($nomeCampeonatoSelecionado['Nome'], $categoria);
            $validarDataCorrida = $corridaModel->validarDataCorrida($campeonato_id, $dataCorrida);
            $validarDuracao = $corridaModel->validarDuracao($tempoCorrida);
            $validarHorario = $corridaModel->validarHorario($campeonato_id, $categoria, $horario, $dataCorrida, $nome);

            if($validarDataCorrida == "Sucesso" && $validarCategoria == "Sucesso" && $validarDuracao == "Sucesso" && $validarHorario == "Sucesso") {
                $resultado = $corridaModel->inserirCorrida($campeonato_id, $kartodromo_id, $nome, $categoria, $dataCorridaFormatada, $horario, $tempoCorridaFormatada);

                if ($resultado == "Sucesso") {
                    header('Location: /sistemackc/admtm85/corrida');
                    exit();
                } else {
                    $feedback = $resultado;
                }
            } else {
                if($validarCategoria != "Sucesso") {
                    $feedback = $validarCategoria;
                } elseif ($validarDataCorrida != "Sucesso") {
                    $feedback = $validarDataCorrida['feedback'];
                } elseif ($validarHorario != "Sucesso") {
                    $feedback = $validarHorario;
                } else {
                    $feedback = $validarDuracao;
                }
            }

            $this->carregarViewComArgumentos('adm/cadastrarCorrida', [
                'feedback' => $feedback,
                'classe' => "erro",
                'dados' => $dadosPreenchidos,
                'dadosCampeonatos' => $dadosCampeonatos,
                'dadosKartodromos' => $dadosKartodromos
            ]);
        } else {
            $this->carregarViewComArgumentos('adm/cadastrarCorrida' , [
                'dadosCampeonatos' => $dadosCampeonatos, 
                'dadosKartodromos' => $dadosKartodromos
            ]);
        }
    }  
    

    public function atualizar($id) {
        if (!isset($_SESSION)) {
            session_start();
        }
        $corridaModel = new Corrida();
        $infoCorrida = $corridaModel->selecionarCorridaPorId($id);
    
        $feedback = "";
        $classe = "";
    
        $campeonatoModel = new Campeonato();
        $kartodromoModel = new Kartodromo();
        $dadosCampeonatos = $campeonatoModel->selecionarNomesEIdsDosCampeonatos();
        $dadosKartodromos = $kartodromoModel->selecionarNomesEIdsDosKartodromos();
    
        $nomeCampeonatoSelecionado = $campeonatoModel->selecionarCampeonatoPorId($infoCorrida['Campeonato_id']);
        $nomeKartodromoSelecionado = $kartodromoModel->selecionarKartodromoPorId($infoCorrida['Kartodromo_id']);
    
        $dados = [
            $infoCorrida['Nome'],
            $infoCorrida['Campeonato_id'],
            $nomeCampeonatoSelecionado['Nome'],
            $infoCorrida['Kartodromo_id'],
            $nomeKartodromoSelecionado['Nome'],
            $infoCorrida['Categoria'],
            $infoCorrida['Data_corrida'],
            $infoCorrida['Horario'],
            $infoCorrida['Tempo_corrida']
        ];
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $campeonato_id = $_POST['campeonato_id'];
            $kartodromo_id = $_POST['kartodromo_id'];
            $nome = $_POST['nome'];
            $categoria = $_POST['categoria'];
            $dataCorrida = $_POST['dataCorrida'];
            $horario = $_POST['horario'];
            $tempoCorrida = $_POST['tempoCorrida'];

            $nomeCampeonatoSelecionado = $campeonatoModel->selecionarCampeonatoPorId($campeonato_id);
            $nomeKartodromoSelecionado = $kartodromoModel->selecionarKartodromoPorId($infoCorrida['Kartodromo_id']);

            /* Se quiser que retorne no formulário os dados antigos e já salvos do sistema, retirar a linha de código abaixo */
            $dados = [
                $nome,
                $campeonato_id,
                $nomeCampeonatoSelecionado['Nome'],
                $kartodromo_id,
                $nomeKartodromoSelecionado['Nome'],
                $categoria,
                $dataCorrida,
                $horario,
                $tempoCorrida
            ];
    
            $dataCorridaFormatada = date('Y-m-d', strtotime($dataCorrida));
            $tempoCorridaFormatada = date('H:i:s', strtotime($tempoCorrida));
    
            // Alterar no BD
            $corridaModel = new Corrida();
            $validacaoDataCorrida = $corridaModel->validarDataCorrida($campeonato_id, $dataCorrida);
            $validarCategoria = $corridaModel->validarCategoria($nomeCampeonatoSelecionado['Nome'], $categoria);
            $validarHorario = $corridaModel->validarHorario($campeonato_id, $categoria, $horario, $dataCorrida, $nome);
            $validarDuracao = $corridaModel->validarDuracao($tempoCorrida);
    
            if($validacaoDataCorrida == "Sucesso" && $validarCategoria == "Sucesso" && $validarHorario == "Sucesso" && $validarDuracao == "Sucesso") {
                $resultado = $corridaModel->alterarCorrida($id, $campeonato_id, $kartodromo_id, $nome, $categoria, $dataCorridaFormatada, $horario, $tempoCorridaFormatada);
                if ($resultado == "Sucesso") {
                    header('Location: /sistemackc/admtm85/corrida');
                    exit();
                } else {
                    $feedback = $resultado;
                    $classe = "erro";
                }
            } else {
                $classe = "erro";
                if($validarCategoria != "Sucesso") {
                    $feedback = $validarCategoria;
    
                } elseif ($validacaoDataCorrida != "Sucesso") {
                    $feedback = $validacaoDataCorrida['feedback'];
                } elseif ($validarHorario != "Sucesso") {
                    $feedback = $validarHorario;
                } else {
                    $feedback = $validarDuracao;
                }
    
                $this->carregarViewComArgumentos('adm/atualizarCorrida', [
                    'feedback' => $feedback,
                    'classe' => $classe,
                    'dados' => $dados,
                    'dadosCampeonatos' => $dadosCampeonatos,
                    'dadosKartodromos' => $dadosKartodromos
                ]);
            }
            
        } else {
            $this->carregarViewComArgumentos('adm/atualizarCorrida' , [
                'dadosCampeonatos' => $dadosCampeonatos, 
                'dadosKartodromos' => $dadosKartodromos,
                'dados' => $dados
            ]);
        }
    }

    public function excluir($id) {
        if (!isset($_SESSION)) {
            session_start();
        }
        
        if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
            $corrida = new Corrida();

            $infoExcluido = $corrida->selecionarCorridaPorId($id);
            $infoExcluido = $corrida->excluirCorrida($id);
            
            if($infoExcluido == "Sucesso") {
                header('Location: /sistemackc/admtm85/corrida');
                exit();
            } else {
                $corridas = $corrida->selecionarTodasAsCorridas();
                $this->carregarViewComArgumentos('adm/crudCorridas', [
                    'feedback' => $infoExcluido,
                    'classe' => 'alert alert-danger',
                    'corridas' => $corridas
                ]);
            }
        }  
    }
    
}

?>
