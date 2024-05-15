<?php
require_once 'Config/Conexao.php';
require_once 'models/Usuario.php';


class Resultado
{
    protected $conexao;

    public function __construct()
    {
        $bancoDeDados = new Conexao();
        $this->conexao = $bancoDeDados->getConexao();
    }

    public function inserirResultado($usuario_id, $corrida_id, $quantidade_volta, $melhor_tempo, $adv, $posicao, $pontuacao_total, $status)
    {
        try {
            $queryInserir = "INSERT INTO resultado (Usuario_id, Corrida_id, Quantidade_volta, Melhor_tempo, Advertencia, Posicao, Pontuacao_total, Status) VALUES (:usuario_id, :corrida_id, :quantidade_volta, :melhor_tempo, :adv, :posicao, :pontuacao_total, :status)";
            $inserir = $this->conexao->prepare($queryInserir);
            $inserir->bindParam(':usuario_id', $usuario_id);
            $inserir->bindParam(':corrida_id', $corrida_id);
            $inserir->bindParam(':quantidade_volta', $quantidade_volta);
            $inserir->bindParam(':melhor_tempo', $melhor_tempo);
            $inserir->bindParam(':adv', $adv);
            $inserir->bindParam(':posicao', $posicao);
            $inserir->bindParam(':pontuacao_total', $pontuacao_total);
            $inserir->bindParam(':status', $status);
            $inserir->execute();

            return "Sucesso";
        } catch (PDOException $erro) {
            return "Erro ao inserir Resultado: " . $erro->getMessage();
        }
    }


    public function alterarResultado($id, $usuario_id, $corrida_id, $quantidade_volta, $melhor_tempo, $adv, $posicao, $pontuacao_total, $status )
    {
        try {
            $query = "UPDATE Resultado SET Usuario_id = :usuario_id, Corrida_id = :corrida_id, Quantidade_volta = :quantidade_volta, Tempo_volta = :tempo_volta, Advertencia = :adv, Pontuacao = :pontuacao, Pontuacao_total = :pontuacao_total Staus = :status WHERE Id = :id  ";
            $alterar = $this->conexao->prepare($query);
            $alterar->bindParam(':id', $id);
            $alterar->bindParam(':usuario_id', $usuario_id);
            $alterar->bindParam(':corrida_id', $corrida_id);
            $alterar->bindParam(':quantitade_volta', $quantidade_volta);
            $alterar->bindParam(':melhor_tempo', $melhor_tempo);
            $alterar->bindParam(':adv', $adv);
            $alterar->bindParam(':posicao', $posicao);
            $alterar->bindParam(':pontuacao_total', $pontuacao_total);
            $alterar->bindParam(':status', $status);
            $alterar->execute();

            return "Sucesso";
        } catch (PDOException $erro) {
            $codigoDoErro = $erro->getCode();

            switch($codigoDoErro)
            {
                case 23000:
                    return "Ocorreu um erro. Este resultado já está registrado no sistema.";
                    break;
                default:
                    return "Ocorreu um erro ao alterar resultado : " . $erro->getMessage();
                    break;
            }     
        }
    }

    public function excluirResultado($id)
    {
        try {
            $query = "DELETE FROM resultado WHERE Id = :id";
            $excluir = $this->conexao->prepare($query);
            $excluir->bindParam(':id', $id);
            $excluir->execute();

            return "Sucesso";
        } catch (PDOException $erro) {
            return "Erro ao excluir resultado: " . $erro->getMessage();
        }
    }

    public function selecionarResultadoPorId($id)
    {
        try {
            $query = "SELECT * FROM resultado WHERE Id = :id";
            $selecionar = $this->conexao->prepare($query);
            $selecionar->bindParam(':id', $id);
            $selecionar->execute();

            return $selecionar->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $erro) {
            echo "Erro ao selecionar resultado por ID: " . $erro->getMessage();
            return false;
        }
    }

    public function selecionarTodosResultados()
    {
        try {
            $query = "SELECT * FROM resultado";
            $selecionar = $this->conexao->prepare($query);
            $selecionar->execute();

            return $selecionar->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $erro) {
            echo "Erro ao selecionar todos os resultados: " . $erro->getMessage();
            return false;
        }
    }

    public function selecionarResultadoPorCorridaId($corrida_id)
    {
        try {
            $query = "SELECT * FROM resultado WHERE Corrida_id = :corrida_id";
            $selecionar = $this->conexao->prepare($query);
            $selecionar->bindParam(':corrida_id', $corrida_id);
            $selecionar->execute();

            return $selecionar->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $erro) {
            echo "Erro ao selecionar resultado por corrida ID: " . $erro->getMessage();
            return false;
        }
    }

    public function verificarDuplicatas($posicoes, $pilotos, $qtd_voltas, $melhor_tempo, $advs, $pontuacoes, $idCorrida)
    {
        $usuarioModel = new Usuario();
        $pilotosVerificados = [];
        $dadosParaInserir = [];
        $feedbackInsercaoErro = "Erro ao inserir essa posição: <br>";
        $houveErro = false;
        $classe = 'erro';

        for ($i = 0; $i < count($posicoes); $i++) {
            $posicaoPiloto = $posicoes[$i];
            $idPiloto = $pilotos[$i];
            $qtdVoltaPiloto = $qtd_voltas[$i];
            $melhorTempoPiloto = $melhor_tempo[$i];
            $advsPiloto = $advs[$i];
            $pontuacaoPiloto = $pontuacoes[$i];

            if (in_array($idPiloto, $pilotosVerificados)) {
                $piloto = $usuarioModel->consultarUsuarioPorId($idPiloto);
                $feedbackInsercaoErro .= "Piloto duplicado na posição: " . $posicaoPiloto . "º | Nome do Piloto: " . $piloto['Nome'] . " " . $piloto['Sobrenome'] ."<br>";
                $houveErro = true;
            } else {
                $pilotosVerificados[] = $idPiloto;
                $dadosParaInserir[] = array(
                    'idPiloto' => $idPiloto,
                    'idCorrida' => $idCorrida,
                    'qtdVoltaPiloto' => $qtdVoltaPiloto,
                    'melhorTempoPiloto' => $melhorTempoPiloto,
                    'advsPiloto' => $advsPiloto,
                    'posicaoPiloto' => $posicaoPiloto,
                    'pontuacaoPiloto' => $pontuacaoPiloto
                );
            }
        }

        return [
            'houveErro' => $houveErro,
            'classe' => $classe,
            'feedback' => $houveErro ? $feedbackInsercaoErro : null,
            'dadosParaInserir' => $dadosParaInserir
        ];
    }
    


    public function consultarResultadoComFiltro($busca)
    {
        try {
            $sql = "SELECT * FROM kartodromo WHERE 1";

            if (!empty($busca)) {
                $sql .= " AND (Nome LIKE :busca)";
            }

            $consulta = $this->conexao->prepare($sql);

            if (!empty($busca)) {
                $buscaParam = "%{$busca}%";
                $consulta->bindValue(':busca', $buscaParam);
            }

            $consulta->execute();

            $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

            if (empty($resultados)) {
                return array( 
                    'Resultados' => $resultados,
                    'feedback' => "Nenhum resultado encontrado",
                    'classe' => "alert alert-danger"
                );
            } else {
                return array(
                    'Resultados' => $resultados,
                    'feedback' => "Sucesso",
                    'classe' => "alert alert-success"
                );
            } 
        } catch (PDOException $erro) {
            return array(
                'Resultados' => array(),
                'feedback' => "Erro na consulta: " . $erro->getMessage(),
                'classe' => "alert alert-danger"
            );
        }
    }

    public function teste() {
        return array(
            'feedback' => "Erro fake para treinar o Alert da Giu",
            'classe' => "erro"
        );
    }
}

   ?>