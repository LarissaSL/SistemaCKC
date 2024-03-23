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
        $this->inserirAdmManualmente('Administrador', 'Thiago', 'Menezes', '11122233344', 'ckckart23@gmail.com', password_hash('crash', PASSWORD_DEFAULT), 70, '1990-03-12', 'Masculino', '(11) 91122-3344');
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

    public function inserirAdmManualmente($tipo, $nome, $sobrenome, $cpf, $email, $senha, $peso, $dataNascimento, $genero, $telefone)
    {
        try {
            $consulta = $this->conexao->prepare("SELECT * FROM usuario WHERE Email = :email");
            $consulta->bindValue(':email', $email);
            $consulta->execute();
            $usuarioExistente = $consulta->fetch();

            // Se não houver usuário com o e-mail especificado, inserir o usuário administrador
            if (!$usuarioExistente) {
                $inserir = $this->conexao->prepare("INSERT INTO usuario (Tipo, Nome, Sobrenome, Cpf, Email, Senha, Peso, Data_nascimento, Genero, Telefone) VALUES (:tipo, :nome, :sobrenome, :cpf, :email, :senha, :peso, :data_nascimento, :genero, :telefone)");
                $inserir->bindValue(':tipo', $tipo);
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
    
    function getConexao()
    {
        return $this->conexao;
    }
}
