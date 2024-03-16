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
                return null;
            }
        } catch (PDOException $erro) {
            echo "Erro na consulta: " . $erro->getMessage();
            return null;
        }
    }

    public function validarCpf($cpf) {
        $statusDaValidacao = "aceito";

        // Verifica se a formatação inserida do CPF é válida (tam 11 e apenas números)
        if (strlen($cpf) !== 11 || !ctype_digit($cpf)) {
            return $statusDaValidacao = "Digite o CPF apenas com números<br>Ex.: 11122233344.";
        }

        // Verifica se o CPF do usuário já foi Cadastrado
        try {
            $consulta = $this->conexao->prepare("SELECT COUNT(*) AS total FROM usuario WHERE Cpf = :cpf");
            $consulta->bindValue(':cpf', $cpf);
            $consulta->execute();
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
            
            if($resultado['total'] > 0) {
                return $statusDaValidacao = "CPF já cadastrado no Sistema";
            }
            
        
        } catch (PDOException $erro) {
            return $statusDaValidacao = "Erro na consulta: ".$erro->getMessage();
        }
        
        return $statusDaValidacao;
    }

    public function validarEmail($email) {
        $statusDaValidacao = "aceito";

        // Verifica se a formatação inserida do Email tem o @
        if (strpos($email, "@") == false) {
            return $statusDaValidacao = "Digite um e-mail válido";
        }

        // Verifica se o E-mail do usuário já foi Cadastrado
        try {
            $consulta = $this->conexao->prepare("SELECT COUNT(*) AS total FROM usuario WHERE Email = :email");
            $consulta->bindValue(':email', $email);
            $consulta->execute();
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
            
            if($resultado['total'] > 0) {
                return $statusDaValidacao = "E-mail já cadastrado no Sistema";
            }
            
        
        } catch (PDOException $erro) {
            return $statusDaValidacao = "Erro na consulta: ".$erro->getMessage();
        }
        
        return $statusDaValidacao;
    }

    public function criptografarSenha($senha) {
        return $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);
    }

    function formatarTelefone($telefone) {
        // Deixando apenas os números
        $telefone = preg_replace('/\D/', '', $telefone);
    
        if (strlen($telefone) === 11) {
            // Formata o número de telefone para (NN) NNNNN-NNNN
            return '(' . substr($telefone, 0, 2) . ') ' . substr($telefone, 2, 5) . '-' . substr($telefone, 7);
        } else {
            // Pra caso o Usuário já tenha digitado nesse formato
            return $telefone;
        }
    }


}

?>
