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
        $this->criarTabelaKartodromo();
        $this->criarTabelaCampeonato();
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

    function criarTabelaCampeonato()
    {
        try {
            $query = "CREATE TABLE IF NOT EXISTS campeonato (
                Id INT AUTO_INCREMENT PRIMARY KEY,
                Nome VARCHAR(50) UNIQUE,
                Data_inicio DATE,
                Data_termino DATE
            )";
            $this->conexao->exec($query);
        } catch (PDOException $erro) {
            echo "Erro ao criar tabela dos Campeonatos: " . $erro->getMessage();
        }
    }
    
    function getConexao()
    {
        return $this->conexao;
    }
}
