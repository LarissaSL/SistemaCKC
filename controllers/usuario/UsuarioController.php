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
            $this->carregarViewComArgumentos('perfil', [
                'id' => $usuario['Id'],
                'nome' => $usuario['Nome'],
                'email' => $usuario['Email'],
                'foto_perfil' => $usuario['Foto_perfil'],
            ]);
        } else {
            $this->carregarViewComArgumentos('perfil', [
                'feedback' => "Nenhum usuário encontrado com o ID: " . $id
            ]);
        }
    }

    public function cadastrar() 
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome = $_POST['nome'];
            $cpf = $_POST['cpf'];
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            $peso = $_POST['peso'];
            $genero = $_POST['genero'];
            $telefone = $_POST['telefone'];
            $dataNascimento = $_POST['data_nascimento'];
            $imagemDePerfil = $_FILES['foto_perfil'];
            
            $imagem = new Imagem();
            $novoUsuario = new Usuario();

            $statusDaValidacaoCpf = $novoUsuario->validarCpf($cpf);
            $statusDaValidacaoEmail = $novoUsuario->validarEmail($email);
            $statusFormatoDaImagem = $imagem->validarImagem($imagemDePerfil);

            $feedback = "";
            $nomeDaClasseParaErro = "error";

            // Foto de Perfil
            if (isset($_FILES['foto_perfil'])) { 
                $statusFormatoDaImagem = $imagem->validarImagem($imagemDePerfil); 

                if ($imagemDePerfil['error'] !== UPLOAD_ERR_OK) {
                    $this->carregarViewComArgumentos('cadastro', [
                        'feedback' => 'Erro no envio da Foto de Perfil',
                        'status' => 'error2'
                    ]);
                    return;
                }
            }

            if ($statusDaValidacaoCpf == "aceito" && $statusDaValidacaoEmail == "aceito" && $statusFormatoDaImagem == "aceito") {
                $senhaCriptografada = $novoUsuario->criptografarSenha($senha);
                $telefoneFormatado = $novoUsuario->formatarTelefone($telefone);
                $dataFormatada = date('Y-m-d', strtotime($dataNascimento));
                $nomeCaminhoDaImagem = $imagem->moverParaPasta($imagemDePerfil);
                
                $resultado = $novoUsuario->inserirUsuario($nome, $cpf, $email, $senhaCriptografada, $peso, $dataFormatada, $genero, $telefoneFormatado, $nomeCaminhoDaImagem);

                if ($resultado) {
                    $this->carregarViewComArgumentos('cadastro', [
                        'feedback' => "Usuário cadastrado com Sucesso!",
                        'status' => 'sucesso'
                    ]);
                } else {
                    $this->carregarViewComArgumentos('cadastro', [
                        'feedback' => "Erro ao cadastrar, tente novamente.",
                        'status' => $nomeDaClasseParaErro
                    ]);
                }
                //Aqui entra os erros
            } else {
                if ($statusDaValidacaoCpf !== "aceito") {
                    $feedback = $statusDaValidacaoCpf;
                } elseif ($statusDaValidacaoEmail !== "aceito") {
                    $feedback = $statusDaValidacaoEmail;
                } elseif ($statusFormatoDaImagem !== "aceito") {
                    $feedback = $statusFormatoDaImagem;
                }
                // Devolve a view com o Erro
                $this->carregarViewComArgumentos('cadastro', [
                    'feedback' => $feedback,
                    'status' => $nomeDaClasseParaErro
                ]);
            } 
        } else {
            $this->carregarView('cadastro');
        }
    }

    public function login()
    {
        echo "Controller do Login";
    }
}
