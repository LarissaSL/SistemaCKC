<?php

require_once 'models/Usuario.php';
require_once 'models/Imagem.php';

class UsuarioController extends RenderView
{
    public function index()
    {

    }

    public function mostrarPerfil($id)
    {
        $usuarioModel = new Usuario();

        $usuario = $usuarioModel->consultarUsuarioPorId($id);

        if ($usuario) {
            $this->carregarViewComArgumentos('usuario/perfil', [
                'id' => $usuario['Id'],
                'nome' => $usuario['Nome'],
                'email' => $usuario['Email'],
                'foto_perfil' => $usuario['Foto_perfil'],
            ]);
        } else {
            $this->carregarViewComArgumentos('usuario/perfil', [
                'feedback' => "Nenhum usuário encontrado com o ID: " . $id
            ]);
        }
    }

    public function cadastrar() 
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome = $_POST['nome'];
            $sobrenome = $_POST['sobrenome'];
            $cpf = $_POST['cpf'];
            $email = $_POST['email'];
            $confirmarEmail = $_POST['confirmarEmail'];
            $senha = $_POST['senha'];
            $confirmarSenha = $_POST['confirmarSenha'];
            $peso = $_POST['peso'];
            $genero = $_POST['genero'];
            $telefone = $_POST['telefone'];
            $dataNascimento = $_POST['dataNascimento'];
            
            $novoUsuario = new Usuario();

            $statusDaValidacaoCpf = $novoUsuario->validarCpf($cpf);
            $statusDaValidacaoEmail = $novoUsuario->validarEmail($email, $confirmarEmail);
            $statusDaValidacaoSenha = $novoUsuario->validarSenha($senha, $confirmarSenha);

            $feedback = "";
            $nomeDaClasseParaErro = "error";

            if ($statusDaValidacaoCpf == "aceito" && $statusDaValidacaoEmail == "aceito" && $statusDaValidacaoSenha == "aceito") {
                $senhaCriptografada = $novoUsuario->criptografarSenha($senha);
                $telefoneFormatado = $novoUsuario->formatarTelefone($telefone);
                $dataFormatada = date('Y-m-d', strtotime($dataNascimento));
                
                $resultado = $novoUsuario->inserirUsuario($nome, $sobrenome, $cpf, $email, $senhaCriptografada, $peso, $dataFormatada, $genero, $telefoneFormatado);

                if ($resultado) {
                    $this->carregarViewComArgumentos('usuario/cadastro', [
                        'feedback' => "Usuário cadastrado com Sucesso!",
                        'status' => 'sucesso'
                    ]);
                } else {
                    $this->carregarViewComArgumentos('usuario/cadastro', [
                        'feedback' => "Erro ao cadastrar, tente novamente.",
                        'status' => $nomeDaClasseParaErro
                    ]);
                }
                // Erros e seus feedbacks
            } else {
                if ($statusDaValidacaoCpf !== "aceito") {
                    $feedback = $statusDaValidacaoCpf;
                } elseif ($statusDaValidacaoEmail !== "aceito") {
                    $feedback = $statusDaValidacaoEmail;
                } elseif ($statusDaValidacaoSenha !== "aceito") {
                    $feedback = $statusDaValidacaoSenha;
                }
                // Devolve a view com o Erro
                $this->carregarViewComArgumentos('usuario/cadastro', [
                    'feedback' => $feedback,
                    'status' => $nomeDaClasseParaErro
                ]);
            } 
        } else {
            $this->carregarView('usuario/cadastro');
        }
    }

    public function login()
    {
        echo "Controller do Login";
    }
}
