<?php

require_once 'Config/Conexao.php';

class Usuario
{
    protected $conexao;

    public function __construct()
    {
        $bancoDeDados = new Conexao();
        $this->conexao = $bancoDeDados->getConexao();
    }

    public function inserirUsuario($nome, $cpf, $email, $senha, $peso, $dataNascimento, $genero, $telefone, $fotoPerfil)
    {
        try {
            $inserir = $this->conexao->prepare("INSERT INTO usuario (Nome, Cpf, Email, Senha, Peso, Data_nascimento, Genero, Telefone, Foto_perfil) VALUES (:nome, :cpf, :email, :senha, :peso, :data_nascimento, :genero, :telefone, :foto_perfil)");
            $inserir->bindValue(':nome', $nome);
            $inserir->bindValue(':cpf', $cpf);
            $inserir->bindValue(':email', $email);
            $inserir->bindValue(':senha', $senha);
            $inserir->bindValue(':peso', $peso);
            $inserir->bindValue(':data_nascimento', $dataNascimento);
            $inserir->bindValue(':genero', $genero);
            $inserir->bindValue(':telefone', $telefone);
            $inserir->bindValue(':foto_perfil', $fotoPerfil);
            $inserir->execute();
            return true; 
        } catch (PDOException $erro) {
            echo "Erro na inserção: " . $erro->getMessage();
            return false; 
        }
    }

    public function consultarUsuarioPorId($id)
    {
        try {
            $consulta = $this->conexao->prepare("SELECT * FROM usuario WHERE Id = :id");
            $consulta->bindValue(':id', $id);
            $consulta->execute();
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
            
            if ($resultado) {
                return $resultado;
            } else {
                echo "Nenhum usuário encontrado com o ID: $id";
                return null;
            }
        } catch (PDOException $erro) {
            echo "Erro na consulta: " . $erro->getMessage();
            return null;
        }
    }
}

?>
