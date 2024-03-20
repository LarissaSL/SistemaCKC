<?php

define('HOST', 'localhost');
define('DATABASENAME', 'ckc_bd');
define('USER', 'root');
define('PASSWORD', '');

class Conexao 
{
    protected $conexao;

    function __construct()
    {
        $this->conectarBancoDeDados();
        $this->criarTabelaUsuario();
        $this->criarTabelaAdm();
        $this->inserirAdm('admtm85', 'ckckart23@gmail.com', password_hash('crash', PASSWORD_DEFAULT),);
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
                Nome VARCHAR(100),
                Sobrenome VARCHAR(50), 
                Cpf CHAR(11) UNIQUE,
                Email VARCHAR(100) UNIQUE,
                Senha VARCHAR(100),
                Peso DECIMAL(5,2),
                Data_nascimento DATE,
                Genero ENUM('Masculino', 'Feminino', 'Outro'),
                Telefone VARCHAR(20),
                Foto_perfil VARCHAR(60),
                Data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            $this->conexao->exec($query);
        } catch (PDOException $erro) {
            echo "Erro ao criar tabela de usuário: " . $erro->getMessage();
        }
    }

    function criarTabelaAdm()
    {
        try {
            $query = "CREATE TABLE IF NOT EXISTS adm (
                Id INT AUTO_INCREMENT PRIMARY KEY,
                Username VARCHAR(50) NOT NULL,
                Email VARCHAR(100) NOT NULL,
                Senha VARCHAR(255) NOT NULL
            )";
            $this->conexao->exec($query);
        } catch (PDOException $erro) {
            echo "Erro ao criar tabela do adm: " . $erro->getMessage();
        }
    }

    public function inserirAdm($username, $email, $senha)
    {
        try {
            $inserir = $this->conexao->prepare("INSERT INTO adm (Username, Email, Senha) VALUES (:username, :email, :senha)");
            $inserir->bindValue(':username', $username);
            $inserir->bindValue(':email', $email);
            $inserir->bindValue(':senha', $senha);
            $inserir->execute();
            return true; 
        } catch (PDOException $erro) {
            echo "Erro na inserção: " . $erro->getMessage();
            return false; 
        }
    }  

    function getConexao()
    {
        return $this->conexao;
    }
}
