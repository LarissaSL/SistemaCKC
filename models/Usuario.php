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

    public function inserirUsuario($nome, $sobrenome, $cpf, $email, $senha, $peso, $dataNascimento, $genero, $telefone)
    {
        try {
            $inserir = $this->conexao->prepare("INSERT INTO usuario (Nome, Sobrenome, Cpf, Email, Senha, Peso, Data_nascimento, Genero, Telefone) VALUES (:nome, :sobrenome, :cpf, :email, :senha, :peso, :data_nascimento, :genero, :telefone)");
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
            return true; 
        } catch (PDOException $erro) {
            echo "Erro na inserção: " . $erro->getMessage();
            return false; 
        }
    }

    public function inserirFoto($foto, $id)
    {
        try {
            // Exclui a imagem antiga do servidor
            $usuarioModel = new Usuario();
            $usuarioAntigo = $usuarioModel->consultarUsuarioPorId($id);
            if ($usuarioAntigo && isset($usuarioAntigo['Foto_perfil'])) {
                
                $nomeArquivo = basename($usuarioAntigo['Foto_perfil']);
                $caminho = ".\\views\Img\ImgUsuario\\" . $nomeArquivo;
                if (file_exists($caminho)) {
                    unlink($caminho);
                }
            }

            $inserir = $this->conexao->prepare("UPDATE usuario SET Foto_perfil = :foto_perfil WHERE Id = :id");
            $inserir->bindValue(':foto_perfil', $foto);
            $inserir->bindValue(':id', $id);
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

    public function consultarUsuarioPorEmail($email)
    {
        try {
            $consulta = $this->conexao->prepare("SELECT * FROM usuario WHERE Email = :email");
            $consulta->bindValue(':email', $email);
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

    public function validarCpf($cpf) 
    {
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

    public function validarEmail($email, $confirmarEmail) {
        $statusDaValidacao = "aceito";

        // Verifica se a formatação inserida do Email tem o @
        if (strpos($email, "@") == false) {
            return $statusDaValidacao = "Digite um e-mail válido";
        }

        if ($email !== $confirmarEmail) {
            return $statusDaValidacao = "Os e-mails devem ser idênticos";
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

    public function validarSenha($senha, $confirmarSenha) 
    {
        if ($senha !== $confirmarSenha) {
            return $statusDaValidacao = "As senhas devem ser idênticas";
        }
        return "aceito";
    }

    public function criptografarSenha($senha) 
    {
        return $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);
    }

    function formatarTelefone($telefone) 
    {
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

    public function autentificar($email, $senha) 
    {
        $usuario = $this->consultarUsuarioPorEmail($email);

        if($usuario !== null) {
            if(password_verify($senha, $usuario['Senha'])){
                return "Sucesso";
            } else {
                return "Senha inválida";
            }
        } else {
            return "Email inválido";
        }
    }
}

?>
