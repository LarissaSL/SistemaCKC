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

    public function selecionarCorridaPorIdComNomeDoCamp($id)
    {
        try {
            $query = "SELECT corrida.*, campe.Nome AS Nome_Campeonato
                    FROM corrida
                    INNER JOIN campeonato campe ON corrida.Campeonato_id = campe.Id
                    WHERE corrida.Id = :id";
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
            $query = "SELECT * FROM corrida ORDER BY Id DESC";
            $selecionar = $this->conexao->prepare($query);
            $selecionar->execute();

            return $selecionar->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $erro) {
            return "Erro ao selecionar todas as corridas: " . $erro->getMessage();
        }
    }

    public function selecionarTodasAsCorridasComNomes($ordem)
    {
        $ordenacao = $ordem == "id" ? 'ORDER BY infoCorrida.Id DESC' : 'ORDER BY infoCorrida.data_corrida DESC';

        try {
            $query = "SELECT infoCorrida.*, campe.Nome AS Nome_Campeonato, karto.Nome AS Nome_Kartodromo 
                      FROM corrida infoCorrida 
                      INNER JOIN campeonato campe ON infoCorrida.Campeonato_id = campe.Id 
                      INNER JOIN kartodromo karto ON infoCorrida.Kartodromo_id = karto.Id
                      $ordenacao";
            $selecionar = $this->conexao->prepare($query);
            $selecionar->execute();

            return $selecionar->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $erro) {
            return "Erro ao selecionar todas as corridas com nomes: " . $erro->getMessage();
        }
    }

    public function verificarSeCorridaJaExiste($campeonato_id, $kartodromo_id, $nome, $categoria, $dataCorrida, $horario, $tempoCorrida)
    {
        try {
            $query = "SELECT COUNT(*) AS total FROM corrida 
                    WHERE Campeonato_id = :campeonato_id 
                    AND Kartodromo_id = :kartodromo_id 
                    AND Nome = :nome 
                    AND Categoria = :categoria 
                    AND DATE(Data_corrida) = :dataCorrida 
                    AND Horario = :horario 
                    AND Tempo_corrida = :tempoCorrida";

            $selecionar = $this->conexao->prepare($query);
            $selecionar->bindParam(':campeonato_id', $campeonato_id);
            $selecionar->bindParam(':kartodromo_id', $kartodromo_id);
            $selecionar->bindParam(':nome', $nome);
            $selecionar->bindParam(':categoria', $categoria);
            $selecionar->bindParam(':dataCorrida', $dataCorrida);
            $selecionar->bindParam(':horario', $horario);
            $selecionar->bindParam(':tempoCorrida', $tempoCorrida);
            $selecionar->execute();

            $resultado = $selecionar->fetch(PDO::FETCH_ASSOC);

            return $resultado;
        } catch (PDOException $erro) {
            throw new Exception("Erro ao verificar se a corrida já existe: " . $erro->getMessage());
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

        if (stripos($nomeCampeonatoMinusculo, 'Crash Kart Championship') !== false || stripos($nomeCampeonatoMinusculo, 'ckc') !== false) {
            if ($categoria == "Livre") {
                return $feedbackErro;
            } else {
                return "Sucesso";
            }
        } elseif (stripos($nomeCampeonatoMinusculo, 'Desafio dos Loucos') !== false || stripos($nomeCampeonatoMinusculo, 'ddl') !== false) {
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

    public function validarHorario($campeonato_id, $kartodromo_id, $nome, $categoria, $dataCorrida, $horario, $tempoCorrida, $corrida_id = null)
    {
        try {
            $campeonatoModel = new Campeonato();
            $dadosCampeonato = $campeonatoModel->selecionarCampeonatoPorId($campeonato_id);
            
            $outrasCorridasCkc95 = $campeonatoModel->selecionarCampeonatosPorCategoriaHorarioData("95", $horario, $dataCorrida, $corrida_id);
            $outrasCorridasCkc110 = $campeonatoModel->selecionarCampeonatosPorCategoriaHorarioData("110", $horario, $dataCorrida, $corrida_id);
            $outrasCorridasDdl = $campeonatoModel->selecionarCampeonatosPorCategoriaHorarioData('Livre', $horario, $dataCorrida, $corrida_id);

            // Verificações pro DDL
            if (stripos($dadosCampeonato['Nome'], 'Desafio dos Loucos') !== false || stripos($dadosCampeonato['Nome'], 'ddl') !== false) {
                $corridaJaExiste = $this->verificarSeCorridaJaExiste($campeonato_id, $kartodromo_id, $nome, $categoria, $dataCorrida, $horario, $tempoCorrida, $corrida_id);
                if ($corridaJaExiste) {
                    if($corrida_id == null && $corridaJaExiste['total'] > 0) {
                        return "Não é possível realizar a operação, pois já existe uma com mesma data, horário e nome";
                    } 
                } 
                    if($outrasCorridasCkc95) {
                        return "Não é possível realizar a operação, pois ela não pode acontecer no mesmo dia e horário que uma do Crash Kart Championship categoria 95"; 
                    } elseif($outrasCorridasDdl) {
                        return "Não é possível realizar a operação, pois já existe uma corrida do Desafio dos Loucos, na mesma data e horário";
                    }
                    
                return "Sucesso";
                
            // Verificações pro CKC
            } elseif (stripos($dadosCampeonato['Nome'], 'Crash Kart Championship') !== false || stripos($dadosCampeonato['Nome'], 'ckc') !== false) {
                if ($categoria == "95") {
                    $corridaJaExiste = $this->verificarSeCorridaJaExiste($campeonato_id, $kartodromo_id, $nome, $categoria, $dataCorrida, $horario, $tempoCorrida, $corrida_id);
                    if ($corridaJaExiste) {
                        if($corrida_id == null && $corridaJaExiste['total'] > 0) {
                            return "Não é possível realizar a operação, pois já existe uma com mesma data, horário e nome";
                        } 
                    }
                     
                    if ($outrasCorridasCkc95) {
                        return "Não é possível realizar a operação, pois já existe uma corrida da categoria 95, na mesma data e horário";
                    } elseif ($outrasCorridasCkc110) {
                        return "Não é possível realizar a operação, pois ela não pode acontecer no mesmo dia e horário que uma da categoria 110"; 
                    } elseif ($outrasCorridasDdl) {
                        return "Não é possível realizar a operação, pois ela não pode acontecer no mesmo dia e horário que uma do Desafio dos Loucos";
                    }
                }

                if ($categoria == "110") {
                    $corridaJaExiste = $this->verificarSeCorridaJaExiste($campeonato_id, $kartodromo_id, $nome, $categoria, $dataCorrida, $horario, $tempoCorrida, $corrida_id);
                    if ($corridaJaExiste) {
                        if($corrida_id == null && $corridaJaExiste['total'] > 0) {
                            return "Não é possível realizar a operação, pois já existe uma com mesma data, horário e nome";
                        }
                    } 
                    
                    if ($outrasCorridasCkc110){
                        return "Não é possível realizar a operação, pois já existe uma corrida da categoria 110, na mesma data e horário";
                    } elseif ($outrasCorridasCkc95){
                        return "Não é possível realizar a operação, pois ela não pode acontecer no mesmo dia e horário que uma da categoria 95";
                    }
                }
                return "Sucesso"; 
            } else {
                $corridaJaExiste = $this->verificarSeCorridaJaExiste($campeonato_id, $kartodromo_id, $nome, $categoria, $dataCorrida, $horario, $tempoCorrida, $corrida_id);
                if ($corridaJaExiste) {
                    if($corrida_id == null && $corridaJaExiste['total'] > 0) {
                        return "Não é possível realizar a operação, pois já existe uma com mesma data, horário e nome";
                    }
                } 
                
                if ($outrasCorridasCkc110){
                    return "Não é possível realizar a operação, pois já existe uma corrida da categoria 110, na mesma data e horário";
                } elseif ($outrasCorridasCkc95){
                    return "Não é possível realizar a operação, pois ela não pode acontecer no mesmo dia e horário que uma da categoria 95";
                } elseif ($outrasCorridasDdl) {
                    return "Não é possível realizar a operação, pois ela não pode acontecer no mesmo dia e horário que uma do Desafio dos Loucos";
                }
                return "Sucesso";
            }
        } catch (PDOException $erro) {
            return "Erro ao validar o horário da corrida: " . $erro->getMessage();
        }
    }


    public function selecionarTodasAsCorridasComNomesEEnderecos($ordem = NULL)
    {
        $ordenacao = $ordem == NULL ? 'ORDER BY corrida.Id DESC' : 'ORDER BY corrida.Data_corrida DESC';

        try {
            $query = "SELECT corrida.*, campe.Nome AS Nome_Campeonato, karto.Nome AS Nome_Kartodromo, CONCAT(karto.Rua, ', ', karto.Bairro, ', CEP: ', karto.CEP, ', ', karto.Numero) AS Endereco_Kartodromo
                    FROM corrida 
                    INNER JOIN campeonato campe ON corrida.Campeonato_id = campe.Id 
                    INNER JOIN kartodromo karto ON corrida.Kartodromo_id = karto.Id
                    $ordenacao";
            $selecionar = $this->conexao->prepare($query);
            $selecionar->execute();

            return $selecionar->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $erro) {
            throw new Exception("Erro ao selecionar todas as corridas com nomes e endereços: " . $erro->getMessage());
        }
    }

    public function definirAbreviacao($nomeCampeonato) {
        if (stripos($nomeCampeonato, 'Crash Kart Championship') !== false || stripos($nomeCampeonato, 'ckc') !== false) {
            return 'ckc';
        } elseif (stripos($nomeCampeonato, 'Desafio dos Loucos') !== false || stripos($nomeCampeonato, 'ddl') !== false) {
            return 'ddl'; 
        } else {
            return 'cmp';
        }
    }

    public function contarPilotosNaCorrida($corrida_id)
    {
        try {
            $query = "SELECT COUNT(Usuario_id) AS total_pilotos FROM resultado WHERE Corrida_id = :corrida_id";

            $consulta = $this->conexao->prepare($query);

            $consulta->bindParam(':corrida_id', $corrida_id);

            $consulta->execute();

            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

            return $resultado['total_pilotos'];
        } catch (PDOException $erro) {
            return "Erro ao contar pilotos na corrida: " . $erro->getMessage();
        }
    }

    public function corridaTemResultado($idCorrida)
    {
        try {
            $query = "SELECT COUNT(*) AS total_resultados FROM resultado WHERE Corrida_id = :corrida_id";
            $selecionar = $this->conexao->prepare($query);
            $selecionar->bindParam(':corrida_id', $idCorrida, PDO::PARAM_INT);
            $selecionar->execute();

            $resultado = $selecionar->fetch(PDO::FETCH_ASSOC);
            
            // Ver se tem algum resultado cadastrado
            if ($resultado && $resultado['total_resultados'] > 0) {
                return true; 
            } else {
                return false; 
            }
        } catch (PDOException $erro) {
            echo "Erro ao verificar se a corrida tem resultado: " . $erro->getMessage();
            return false;
        }
    }

    public function construirHtml($infoCorridas = null) {
        $infoCorridas = $infoCorridas == null ? $this->selecionarTodasAsCorridasComNomesEEnderecos() : $infoCorridas;
    
        if (!empty($infoCorridas)) {
            $corridasFormatadas = array();
    
            foreach ($infoCorridas as $corrida) {
                // Formatações de Data e Horário
                $data = date('d/m/Y', strtotime($corrida['Data_corrida']));
                
                $horaFormatada = date('H:i:s', strtotime($corrida['Horario']));
                $partesHora = explode(":", $horaFormatada);
                $horas = $partesHora[0];
                $minutos = $partesHora[1]; 
    
                // Contagem de pilotos na corrida (só aparece no exibir resultados pro usuario)
                $qtdPilotos = $this->contarPilotosNaCorrida($corrida['Id']);
    
                $nomeAbreviado = $this->definirAbreviacao($corrida['Nome_Campeonato']);
                $enderecoKartodromo = isset($corrida['Endereco_Kartodromo']) ? $corrida['Endereco_Kartodromo'] : '';
    
                // Retornos para a view
                $corridasFormatadas[] = array(
                    'id' => $corrida['Id'],
                    'nome' => $corrida['Nome'],
                    'categoria' => $corrida['Categoria'],
                    'nomeDoCampeonato' => $corrida['Nome_Campeonato'],
                    'nomeDoKartodromo' => $corrida['Nome_Kartodromo'],
                    'nomeAbreviado' => $nomeAbreviado,
                    'enderecoDoKartodromo' => $enderecoKartodromo,
                    'data' => $data,
                    'hora' => $horas,
                    'minuto' => $minutos,
                    'qtdPilotos' => $qtdPilotos
                );
            }
            return $corridasFormatadas;
        } else {
            return null; 
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
                $consulta->bindValue(':filtroNome', $filtroNome);
            }

            if (!empty($filtroCampeonatoId)) {
                $consulta->bindValue(':filtroCampeonatoId', $filtroCampeonatoId);
            }

            if (!empty($filtroData)) {
                $consulta->bindValue(':filtroData', $filtroData);
            }

            $consulta->execute();

            $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

            if (empty($resultados)) {
                return array( 
                    'corridas' => $resultados,
                    'feedback' => "Nenhuma corrida encontrada",
                    'classe' => "erro"
                );
            } else {
                return array(
                    'corridas' => $resultados,
                    'feedback' => "Sucesso",
                    'classe' => "Sucesso"
                );
            } 
        } catch (PDOException $erro) {
            return array(
                'corridas' => array(),
                'feedback' => "Erro na consulta: " . $erro->getMessage(),
                'classe' => "erro"
            );
        }
    }

    public function consultarCorridaPorFiltroParaResultado($filtroCampeonato, $filtroMes, $filtroAno, $filtroDia)
    {
        try {
            $sql = "SELECT corrida.*, campe.Nome AS Nome_Campeonato, karto.Nome AS Nome_Kartodromo, 
                            DAY(corrida.Data_corrida) AS Dia, 
                            MONTH(corrida.Data_corrida) AS Mes, 
                            YEAR(corrida.Data_corrida) AS Ano
                    FROM corrida 
                    INNER JOIN campeonato campe ON corrida.Campeonato_id = campe.Id 
                    INNER JOIN kartodromo karto ON corrida.Kartodromo_id = karto.Id
                    WHERE 1";

            // Verificacao de quais filtros foram passados
            if (!empty($filtroCampeonato)) {
                $sql .= " AND corrida.Campeonato_id = :filtroCampeonato";
            }

            if (!empty($filtroMes)) {
                $sql .= " AND MONTH(corrida.Data_corrida) = :filtroMes";
            }

            if (!empty($filtroAno)) {
                $sql .= " AND YEAR(corrida.Data_corrida) = :filtroAno";
            }

            if (!empty($filtroDia)) {
                $sql .= " AND DAY(corrida.Data_corrida) = :filtroDia";
            }

            $consulta = $this->conexao->prepare($sql);

            // Bindando os valores a serem passados
            if (!empty($filtroCampeonato)) {
                $consulta->bindValue(':filtroCampeonato', $filtroCampeonato);
            }

            if (!empty($filtroMes)) {
                $consulta->bindValue(':filtroMes', $filtroMes);
            }

            if (!empty($filtroAno)) {
                $consulta->bindValue(':filtroAno', $filtroAno);
            }

            if (!empty($filtroDia)) {
                $consulta->bindValue(':filtroDia', $filtroDia);
            }

            $consulta->execute();

            $corridas = $consulta->fetchAll(PDO::FETCH_ASSOC);

            if (empty($corridas)) {
                return array( 
                    'corridas' => $corridas,
                    'feedback' => "Nenhuma corrida encontrada",
                    'classe' => "alert alert-danger"
                );
            } else {
                return array(
                    'corridas' => $corridas,
                    'feedback' => "Sucesso",
                    'classe' => "alert alert-success"
                );
            } 
        } catch (PDOException $erro) {
            return array(
                'corridas' => array(),
                'feedback' => "Erro na consulta: " . $erro->getMessage(),
                'classe' => "alert alert-danger"
            );
        }
    }
}
