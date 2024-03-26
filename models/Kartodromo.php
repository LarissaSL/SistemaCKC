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

    public function inserirKartodromo($nome, $cep, $rua, $bairro, $numero, $site, $foto)
    {
        try {
            $queryInserir = "INSERT INTO kartodromo (Nome, CEP, Rua, Bairro, Numero, Site, Foto) VALUES (:nome, :cep, :rua, :bairro, :numero, :site, :foto)";
            $inserir = $this->conexao->prepare($queryInserir);
            $inserir->bindParam(':nome', $nome);
            $inserir->bindParam(':cep', $cep);
            $inserir->bindParam(':rua', $rua);
            $inserir->bindParam(':bairro', $bairro);
            $inserir->bindParam(':numero', $numero);
            $inserir->bindParam(':site', $site);
            $inserir->bindParam(':foto', $foto);
            $inserir->execute();

            return true;
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
        if (strlen($cep) !== 8) {
            return 'Tamanho do CEP está incorreto, por favor digite apenas 8 números';
        } else {
            return 'aceito';
        }
    }

    public function formatarCep($cep)
    {
        $cepFormatado = preg_replace("/[^0-9]/", "", $cep);
        return $cepFormatado; 
    }

    function adicionarPrefixoHttp($url)
    {
        // Verificar se o URL nao começa com http:// ou https://
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = 'https://' . $url;
        }
        return $url;
    }

    function alterarKartodromo($id, $nome, $cep, $rua, $bairro, $numero, $site, $foto)
    {
        try {
            $query = "UPDATE kartodromo SET Nome = :nome, CEP = :cep, Rua = :rua, Bairro = :bairro, Numero = :numero, Site = :site, Foto = :foto WHERE Id = :id";
            $alterar = $this->conexao->prepare($query);
            $alterar->bindParam(':id', $id);
            $alterar->bindParam(':nome', $nome);
            $alterar->bindParam(':cep', $cep);
            $alterar->bindParam(':rua', $rua);
            $alterar->bindParam(':bairro', $bairro);
            $alterar->bindParam(':numero', $numero);
            $alterar->bindParam(':site', $site);
            $alterar->bindParam(':foto', $foto);

            $alterar->execute();

            return true;
        } catch (PDOException $erro) {
            return "Erro ao alterar kartódromo: " . $erro->getMessage();
        }
    }

    function excluirKartodromo($id)
    {
        try {
            $query = "DELETE FROM kartodromo WHERE Id = :id";
            $excluir = $this->conexao->prepare($query);
            $excluir->bindParam(':id', $id);
            $excluir->execute();

            return 'true';
        } catch (PDOException $erro) {
            echo "Erro ao excluir kartódromo: " . $erro->getMessage();
            return false;
        }
    }

    function selecionarKartodromoPorId($id)
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
            $query = "SELECT * FROM kartodromo";
            $selecionar = $this->conexao->prepare($query);
            $selecionar->execute();

            return $selecionar->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $erro) {
            echo "Erro ao selecionar todos os kartodromos: " . $erro->getMessage();
            return false;
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

            return array(
                'kartodromos' => $consulta->fetchAll(PDO::FETCH_ASSOC),
                'feedback' => 'Consulta realizada com sucesso.',
                'classe' => 'alert alert-success'
            );
        } catch (PDOException $erro) {
            return array(
                'kartodromos' => array(),
                'feedback' => "Erro na consulta: " . $erro->getMessage(),
                'classe' => "alert alert-danger"
            );
        }
    }
}
