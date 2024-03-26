<?php

define('HOST', 'localhost');
define('DATABASENAME', 'ckc_bd');
define('USER', 'root');
define('PASSWORD', '');

require_once 'models/Usuario.php';

class Conexao 
{
    protected $conexao;

    function __construct()
    {
        $this->conectarBancoDeDados();
        $this->criarTabelaUsuario();
        $this->inserirAdmManualmente('Administrador','fotoThiago.jpeg' ,'Thiago', 'Menezes', '32241247847', 'ckckart23@gmail.com', password_hash('crash', PASSWORD_DEFAULT), 74, '1985-03-12', 'Masculino', '(11) 98437-2045');
        $this->criarTabelaKartodromo();
        $this->inserirKartodromoManualmente('Kartódromo Granja Viana', '06711270', 'R. Tomás Sepé', 'Jardim da Gloria', 443, 'https://kartodromogranjaviana.com.br', 'kgv.png');
        $this->inserirKartodromoManualmente('Kartódromo Internacional Nova Odessa', '13460000', 'Rod. Anhanguera, KM 116 acesso via Marginal', 'Jardim das Palmeiras, Nova Odessa', 330, 'https://kartodromonovaodessa.com.br', 'kno.png');
    }

    function conectarBancoDeDados()
    {
        try {
            $this->conexao = new PDO('mysql:host='.HOST.';dbname='.DATABASENAME, USER, PASSWORD);
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $erro) {
            echo "Error! " . $erro->getMessage();
        }
    }

    function criarTabelaUsuario()
    {
        try {
            $query = "CREATE TABLE IF NOT EXISTS usuario (
                Id INT AUTO_INCREMENT PRIMARY KEY,
                Tipo VARCHAR(30) DEFAULT 'Comum',
                Nome VARCHAR(25),
                Sobrenome VARCHAR(30), 
                Cpf CHAR(11) UNIQUE,
                Email VARCHAR(50) UNIQUE,
                Senha VARCHAR(60),
                Peso DECIMAL(5,2),
                Data_nascimento DATE,
                Genero ENUM('Masculino', 'Feminino', 'Outro'),
                Telefone VARCHAR(15),
                Foto VARCHAR(60),
                Data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            $this->conexao->exec($query);
        } catch (PDOException $erro) {
            echo "Erro ao criar tabela de usuário: " . $erro->getMessage();
        }
    }

    public function inserirAdmManualmente($tipo, $foto, $nome, $sobrenome, $cpf, $email, $senha, $peso, $dataNascimento, $genero, $telefone)
    {
        try {
            $consulta = $this->conexao->prepare("SELECT * FROM usuario WHERE Email = :email");
            $consulta->bindValue(':email', $email);
            $consulta->execute();
            $usuarioExistente = $consulta->fetch();

            // Se não houver usuário com o e-mail especificado, inserir o usuário administrador
            if (!$usuarioExistente) {
                $inserir = $this->conexao->prepare("INSERT INTO usuario (Tipo, Foto, Nome, Sobrenome, Cpf, Email, Senha, Peso, Data_nascimento, Genero, Telefone) VALUES (:tipo, :foto, :nome, :sobrenome, :cpf, :email, :senha, :peso, :data_nascimento, :genero, :telefone)");
                $inserir->bindValue(':tipo', $tipo);
                $inserir->bindValue(':foto', $foto);
                $inserir->bindValue(':nome', $nome);
                $inserir->bindValue(':sobrenome', $sobrenome);
                $inserir->bindValue(':cpf', $cpf);
                $inserir->bindValue(':email', $email);
                $inserir->bindValue(':senha', $senha);
                $inserir->bindValue(':peso', $peso);
                $inserir->bindValue(':data_nascimento', $dataNascimento);
                $inserir->bindValue(':genero', $genero);
                $inserir->bindValue(':telefone', $telefone);
                $inserir->execute(); 
            } 
        } catch (PDOException $erro) {
            echo "Erro no cadastro: " . $erro->getMessage();
            return false; 
        }
    }

    function criarTabelaKartodromo()
    {
        try {
            $query = "CREATE TABLE IF NOT EXISTS kartodromo (
                Id INT AUTO_INCREMENT PRIMARY KEY,
                Nome VARCHAR(50) UNIQUE,
                CEP VARCHAR(9),
                Rua VARCHAR(50),
                Bairro VARCHAR(50),
                Numero INTEGER,
                Site VARCHAR(50),
                Foto VARCHAR(50)
            )";
            $this->conexao->exec($query);
        } catch (PDOException $erro) {
            echo "Erro ao criar tabela dos Kartodromos: " . $erro->getMessage();
        }
    }

    function inserirKartodromoManualmente($nome, $cep, $rua, $bairro, $numero, $site, $foto)
    {
        try {
            $consulta = $this->conexao->prepare("SELECT * FROM kartodromo WHERE Nome = :nome");
            $consulta->bindValue(':nome', $nome);
            $consulta->execute();
            $kartodromoExistente = $consulta->fetch();
    
            if ($kartodromoExistente) {
                return "Já existe um kartódromo com o nome especificado.";
            } else {
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
            }
        } catch (PDOException $erro) {
            return "Erro ao inserir kartódromo: " . $erro->getMessage();
        }  
    }
    
    function getConexao()
    {
        return $this->conexao;
    }
}
