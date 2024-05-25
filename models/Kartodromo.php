<?php

require_once 'Config/Conexao.php';

class Kartodromo
{
    protected $conexao;

    public function __construct()
    {
        $bancoDeDados = new Conexao();
        $this->conexao = $bancoDeDados->getConexao();
    }

    public function inserirKartodromo($nome, $cep, $rua, $bairro, $numero, $redes, $foto)
    {
        try {
            $queryInserir = "INSERT INTO kartodromo (Nome, CEP, Rua, Bairro, Numero, Redes, Foto) VALUES (:nome, :cep, :rua, :bairro, :numero, :redes, :foto)";
            $inserir = $this->conexao->prepare($queryInserir);
            $inserir->bindParam(':nome', $nome);
            $inserir->bindParam(':cep', $cep);
            $inserir->bindParam(':rua', $rua);
            $inserir->bindParam(':bairro', $bairro);
            $inserir->bindParam(':numero', $numero);
            $inserir->bindParam(':redes', $redes);
            $inserir->bindParam(':foto', $foto);
            $inserir->execute();

            return "Sucesso";
        } catch (PDOException $erro) {
            return "Erro ao inserir kartódromo: " . $erro->getMessage();
        }
    }

    public function verificarNomeKartodromo($nome)
    {
        $consulta = $this->conexao->prepare("SELECT * FROM kartodromo WHERE Nome = :nome");
        $consulta->bindParam(':nome', $nome);
        $consulta->execute();
        $kartodromoExistente = $consulta->fetch();
        return $kartodromoExistente ? true : false;
    }

    public function verificarCep($cep)
    {
        if (preg_match('/[a-zA-Z]/', $cep)) {
            return 'Digite apenas números no CEP, por favor';
        }
        
        if (strlen($cep) !== 8) {
            return 'Tamanho do CEP está incorreto, por favor digite apenas 8 números';
        }
        return 'aceito';
    }

    public function formatarCep($cep)
    {
        $cepFormatado = preg_replace("/[^0-9]/", "", $cep);
        return $cepFormatado; 
    }

    public function adicionarPrefixoHttp($url)
    {
        // Verificar se o URL nao começa com http:// ou https://
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = 'https://' . $url;
        }
        return $url;
    }

    public function alterarKartodromo($id, $nome, $cep, $rua, $bairro, $numero, $redes, $foto)
    {
        try {
            $query = "UPDATE kartodromo SET Nome = :nome, CEP = :cep, Rua = :rua, Bairro = :bairro, Numero = :numero, Redes = :redes, Foto = :foto WHERE Id = :id";
            $alterar = $this->conexao->prepare($query);
            $alterar->bindParam(':id', $id);
            $alterar->bindParam(':nome', $nome);
            $alterar->bindParam(':cep', $cep);
            $alterar->bindParam(':rua', $rua);
            $alterar->bindParam(':bairro', $bairro);
            $alterar->bindParam(':numero', $numero);
            $alterar->bindParam(':redes', $redes);
            $alterar->bindParam(':foto', $foto);

            $alterar->execute();

            return "Sucesso";
        } catch (PDOException $erro) {
            $codigoDoErro = $erro->getCode();

            switch($codigoDoErro)
            {
                case 23000:
                    return "Ocorreu um erro. Este kartódromo já está registrado no sistema.";
                    break;
                default:
                    return "Ocorreu um erro ao alterar o kartódromo: " . $erro->getMessage();
                    break;
            }     
        }
    }

    public function excluirKartodromo($id)
    {
        try {
            $query = "DELETE FROM kartodromo WHERE Id = :id";
            $excluir = $this->conexao->prepare($query);
            $excluir->bindParam(':id', $id);
            $excluir->execute();

            return "Sucesso";
        } catch (PDOException $erro) {
            return "Erro ao excluir kartódromo: " . $erro->getMessage();
        }
    }

    public function selecionarKartodromoPorId($id)
    {
        try {
            $query = "SELECT * FROM kartodromo WHERE Id = :id";
            $selecionar = $this->conexao->prepare($query);
            $selecionar->bindParam(':id', $id);
            $selecionar->execute();

            return $selecionar->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $erro) {
            echo "Erro ao selecionar kartodromo por ID: " . $erro->getMessage();
            return false;
        }
    }

    public function selecionarTodosKartodromos()
    {
        try {
            $query = "SELECT * FROM kartodromo ORDER BY Id DESC";
            $selecionar = $this->conexao->prepare($query);
            $selecionar->execute();

            return $selecionar->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $erro) {
            echo "Erro ao selecionar todos os kartodromos: " . $erro->getMessage();
            return false;
        }
    }

    public function selecionarNomesEIdsDosKartodromos()
    {
        try {
            $query = "SELECT Id, Nome FROM kartodromo";
            $selecionar = $this->conexao->prepare($query);
            $selecionar->execute();

            return $selecionar->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $erro) {
            return "Erro ao selecionar os nomes dos kartodromos: " . $erro->getMessage();
        }
    }

    public function pegarProximoId()
    {
        try {
            $query = "SELECT MAX(Id) AS MaxId FROM kartodromo";
            $statement = $this->conexao->query($query);
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if ($result && isset($result['MaxId'])) {
                return $result['MaxId'] + 1;
            } else {
                return 1;
            }
        } catch (PDOException $erro) {
            echo "Erro ao obter o próximo ID: " . $erro->getMessage();
            return false;
        }
    }

    public function consultarKartodromoComFiltro($busca)
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
                    'kartodromos' => $resultados,
                    'feedback' => "Nenhum Kartódromo encontrado",
                    'classe' => "alert alert-danger"
                );
            } else {
                return array(
                    'kartodromos' => $resultados,
                    'feedback' => "Sucesso",
                    'classe' => "Sucesso"
                );
            } 
        } catch (PDOException $erro) {
            return array(
                'kartodromos' => array(),
                'feedback' => "Erro na consulta: " . $erro->getMessage(),
                'classe' => "alert alert-danger"
            );
        }
    }
}
