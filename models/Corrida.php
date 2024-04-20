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

    public function selecionarTodasAsCorridasComNomes() {
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

    //Ver o filtro de NomeDoCampeonato
    public function consultarCorridaPorFiltro($filtroNome, $filtroDataInicio, $filtroData)
    {
        try {
            $sql = "SELECT * FROM corrida WHERE 1";

            if (!empty($filtroNome)) {
                $sql .= " AND Nome LIKE :filtroNome";
            }

            if (!empty($filtroDataInicio)) {
                $sql .= " AND Data_corrida >= :filtroDataInicio";
            }

            if (!empty($filtroData)) {
                $sql .= " AND Data_corrida = :filtroData";
            }

            $consulta = $this->conexao->prepare($sql);

            if (!empty($filtroNome)) {
                $filtroNome = "%{$filtroNome}%";
                $consulta->bindParam(':filtroNome', $filtroNome);
            }

            if (!empty($filtroDataInicio)) {
                $consulta->bindParam(':filtroDataInicio', $filtroDataInicio);
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
