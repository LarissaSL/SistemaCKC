<?php

require_once 'Config/Conexao.php';
require_once 'models/Campeonato.php';


class Corrida
{
    protected $conexao;

    public function __construct()
    {
        $bancoDeDados = new Conexao();
        $this->conexao = $bancoDeDados->getConexao();
    }

    public function inserirCorrida($campeonato_id, $kartodromo_id, $nome, $categoria, $dataCorrida, $horario, $tempoCorrida)
    {
        try {
            $queryInserir = "INSERT INTO corrida (Campeonato_id, Kartodromo_id, Nome, Categoria, Data_corrida, Horario, Tempo_corrida) VALUES (:campeonato_id, :kartodromo_id, :nome, :categoria, :dataCorrida, :horario, :tempoCorrida)";
            $inserir = $this->conexao->prepare($queryInserir);
            $inserir->bindParam(':campeonato_id', $campeonato_id);
            $inserir->bindParam(':kartodromo_id', $kartodromo_id);
            $inserir->bindParam(':nome', $nome);
            $inserir->bindParam(':categoria', $categoria);
            $inserir->bindParam(':dataCorrida', $dataCorrida);
            $inserir->bindParam(':horario', $horario);
            $inserir->bindParam(':tempoCorrida', $tempoCorrida);
            $inserir->execute();

            return "Sucesso";
        } catch (PDOException $erro) {
            return "Ocorreu um erro ao cadastrar a Corrida: " . $erro->getMessage();
        }
    }

    public function alterarCorrida($id, $campeonato_id, $kartodromo_id, $nome, $categoria, $dataCorrida, $horario, $tempoCorrida)
    {
        try {
            $query = "UPDATE corrida SET Campeonato_id = :campeonato_id, Kartodromo_id = :kartodromo_id, Nome = :nome, Categoria = :categoria, Data_corrida = :dataCorrida, Horario = :horario, Tempo_corrida = :tempoCorrida WHERE Id = :id";
            $alterar = $this->conexao->prepare($query);
            $alterar->bindParam(':id', $id);
            $alterar->bindParam(':campeonato_id', $campeonato_id);
            $alterar->bindParam(':kartodromo_id', $kartodromo_id);
            $alterar->bindParam(':nome', $nome);
            $alterar->bindParam(':categoria', $categoria);
            $alterar->bindParam(':dataCorrida', $dataCorrida);
            $alterar->bindParam(':horario', $horario);
            $alterar->bindParam(':tempoCorrida', $tempoCorrida);
            $alterar->execute();

            return "Sucesso";
        } catch (PDOException $erro) {
            return "Ocorreu um erro ao alterar a Corrida: " . $erro->getMessage();
        }
    }

    public function excluirCorrida($id)
    {
        try {
            $query = "DELETE FROM corrida WHERE Id = :id";
            $excluir = $this->conexao->prepare($query);
            $excluir->bindParam(':id', $id);
            $excluir->execute();

            return "Sucesso";
        } catch (PDOException $erro) {
            $codigoDoErro = $erro->getCode();

            switch ($codigoDoErro) {
                case 42000:
                    return "Erro de sintaxe SQL, por favor verificar com o Desenvolvedor.";
                    break;
                case 1452:
                    return "Ocorreu um erro. Não é possível excluir a Corrida pois existem Resultados dela no Sistema";
                    break;
                default:
                    return "Ocorreu um erro ao Excluir a Corrida: " . $erro->getMessage();
                    break;
            }
        }
    }

    public function selecionarCorridaPorId($id)
    {
        try {
            $query = "SELECT * FROM corrida WHERE Id = :id";
            $selecionar = $this->conexao->prepare($query);
            $selecionar->bindParam(':id', $id);
            $selecionar->execute();

            return $selecionar->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $erro) {
            return "Erro ao selecionar corrida por ID: " . $erro->getMessage();
        }
    }

    public function selecionarTodasAsCorridas()
    {
        try {
            $query = "SELECT * FROM corrida";
            $selecionar = $this->conexao->prepare($query);
            $selecionar->execute();

            return $selecionar->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $erro) {
            return "Erro ao selecionar todas as corridas: " . $erro->getMessage();
        }
    }

    public function selecionarTodasAsCorridasComNomes()
    {
        try {
            $query = "SELECT infoCorrida.*, campe.Nome AS Nome_Campeonato, karto.Nome AS Nome_Kartodromo 
                      FROM corrida infoCorrida 
                      INNER JOIN campeonato campe ON infoCorrida.Campeonato_id = campe.Id 
                      INNER JOIN kartodromo karto ON infoCorrida.Kartodromo_id = karto.Id";
            $selecionar = $this->conexao->prepare($query);
            $selecionar->execute();

            return $selecionar->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $erro) {
            return "Erro ao selecionar todas as corridas com nomes: " . $erro->getMessage();
        }
    }

    public function validarDataCorrida($idCampeonato, $dataCorrida)
    {
        try {
            $campeonatoModel = new Campeonato();
            $dadosCampeonato = $campeonatoModel->selecionarCampeonatoPorId($idCampeonato);

            if ($dadosCampeonato) {
                $dataInicioCampeonato = $dadosCampeonato['Data_inicio'];
                $dataTerminoCampeonato = $dadosCampeonato['Data_termino'];

                if ($dataCorrida >= $dataInicioCampeonato && $dataCorrida <= $dataTerminoCampeonato) {
                    return "Sucesso";
                } else {
                    return array(
                        'feedback' => "A data da corrida não está dentro do período do campeonato.",
                        'classe' => "erro"
                    );
                }
            }
        } catch (PDOException $erro) {
            return array(
                'feedback' => "Erro na validação da data da corrida: " . $erro->getMessage(),
                'classe' => "erro"
            );
        }
    }

    public function validarCategoria($nomeCampeonato, $categoria)
    {
        $nomeCampeonatoMinusculo = strtolower($nomeCampeonato);
        $feedbackErro = "Esse campeonato não permite essa categoria";

        if (strpos('crash kart championship', $nomeCampeonatoMinusculo) !== false) {
            if ($categoria == "Livre") {
                return $feedbackErro;
            } else {
                return "Sucesso";
            }
        } elseif (strpos('desafio dos loucos', $nomeCampeonatoMinusculo) !== false) {
            if ($categoria == "Livre") {
                return "Sucesso";
            } else {
                return $feedbackErro;
            }
        } else {
            return "Sucesso";
        }
    }

    public function validarDuracao($duracao)
    {
        list($horas, $minutos) = explode(':', $duracao);
        $duracao_em_minutos = ($horas * 60) + $minutos;

        if($duracao_em_minutos == 25) {
            return "Sucesso";
        } else {
            return "As corridas precisam ter a duração de 25 minutos";
        }
    }

    public function validarHorario($campeonato_id, $categoria, $horario, $data)
    {
        try {
            $campeonatoModel = new Campeonato();
            $dadosCampeonato = $campeonatoModel->selecionarCampeonatoPorId($campeonato_id);
            
            $categoriaDeBusca = $categoria == "95" ? "110" : "95";
            $outrasCorridasCkc = $campeonatoModel->selecionarCampeonatosPorCategoriaHorarioData($categoriaDeBusca, $horario, $data);
            $outrasCorridasDdl = $campeonatoModel->selecionarCampeonatosPorCategoriaHorarioData('Livre', $horario, $data);

            
            // Verificações pro DDL
            if (stripos($dadosCampeonato['Nome'], 'Desafio dos Loucos') !== false) {
                $outrasCorridasCkc = $campeonatoModel->selecionarCampeonatosPorCategoriaHorarioData("95", $horario, $data);
                if ($outrasCorridasCkc) {
                    return "Não é possível realizar a operação, pois ela não pode acontecer no mesmo dia e horário que uma do Crash Kart Championship categoria 95"; 
                } else {
                    if($outrasCorridasDdl) {
                        return "Não é possível realizar a operação, pois já existe uma com mesma data e horário";
                    }
                }
                return "Sucesso";
                 
            // Verificações pro CKC
            } elseif (stripos($dadosCampeonato['Nome'], 'Crash Kart Championship') !== false) {
                if ($categoria == "95") {
                    $corridaJaExiste = $campeonatoModel->selecionarCampeonatosPorCategoriaHorarioData("95", $horario, $data);
                    if ($outrasCorridasCkc) {
                        return "Não é possível realizar a operação, pois ela não pode acontecer no mesmo dia e horário que uma da categoria 110";
                    } elseif ($outrasCorridasDdl) {
                        return "Não é possível realizar a operação, pois ela não pode acontecer no mesmo dia e horário que uma do Desafio dos Loucos";
                    } elseif ($corridaJaExiste) {
                        return "Não é possível realizar a operação, pois já existe uma com mesma data e horário";
                    }
                }
                if ($categoria == "110") {
                    $corridaJaExiste = $campeonatoModel->selecionarCampeonatosPorCategoriaHorarioData("110", $horario, $data);
                    if ($outrasCorridasCkc) {
                        return "Não é possível realizar a operação, pois ela não pode acontecer no mesmo dia e horário que uma da categoria 95";
                    } elseif ($corridaJaExiste){
                        return "Não é possível realizar a operação, pois já existe uma com mesma data e horário";
                    }
                }
                return "Sucesso"; 
            } else {
                return "Sucesso";
            }
        } catch (PDOException $erro) {
            return "Erro ao validar o horário da corrida: " . $erro->getMessage();
        }
    }

    public function consultarCorridaPorFiltro($filtroNome, $filtroCampeonatoId, $filtroData)
    {
        try {
            $sql = "SELECT corrida.*, campe.Nome AS Nome_Campeonato, karto.Nome AS Nome_Kartodromo 
                    FROM corrida 
                    INNER JOIN campeonato campe ON corrida.Campeonato_id = campe.Id 
                    INNER JOIN kartodromo karto ON corrida.Kartodromo_id = karto.Id 
                    WHERE 1";

            if (!empty($filtroNome)) {
                $sql .= " AND corrida.Nome LIKE :filtroNome";
            }

            if (!empty($filtroCampeonatoId)) {
                $sql .= " AND corrida.Campeonato_id = :filtroCampeonatoId";
            }

            if (!empty($filtroData)) {
                $sql .= " AND corrida.Data_corrida = :filtroData";
            }

            $consulta = $this->conexao->prepare($sql);

            if (!empty($filtroNome)) {
                $filtroNome = "%{$filtroNome}%";
                $consulta->bindParam(':filtroNome', $filtroNome);
            }

            if (!empty($filtroCampeonatoId)) {
                $consulta->bindParam(':filtroCampeonatoId', $filtroCampeonatoId);
            }

            if (!empty($filtroData)) {
                $consulta->bindParam(':filtroData', $filtroData);
            }

            $consulta->execute();

            return array(
                'corridas' => $consulta->fetchAll(PDO::FETCH_ASSOC),
                'feedback' => "Sucesso",
                'classe' => "Sucesso"
            );
        } catch (PDOException $erro) {
            return array(
                'corridas' => array(),
                'feedback' => "Erro na consulta: " . $erro->getMessage(),
                'classe' => "erro"
            );
        }
    }
}
