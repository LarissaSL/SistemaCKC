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

        // Carrega o perfil do usuário
        $usuario = $usuarioModel->consultarUsuarioPorId($id);

        if ($usuario) {
            $this->carregarViewComArgumentos('usuario/perfil', [
                'id' => $id,
                'nome' => $usuario['Nome'],
                'email' => $usuario['Email'],
                'fotoPerfil' => $usuario['Foto_perfil'],
            ]);
        } else {
            $this->carregarViewComArgumentos('usuario/perfil', [
                'feedback' => "Nenhum usuário encontrado com o ID: " . $id
            ]);
        }

        // Atualizar ou Inserir uma foto de perfil
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['fotoPerfil'])) {
            $imagemDePerfil = $_FILES['fotoPerfil'];
            $imagem = new Imagem();

            $statusFormatoDaImagem = $imagem->validarImagem($imagemDePerfil); 

            if ($statusFormatoDaImagem !== "aceito") {
                $this->carregarViewComArgumentos('usuario/perfil', [
                    'id' => $id,
                    'feedback' => $statusFormatoDaImagem,
                    'nome' => $usuarioModel['Nome'],
                    'email' => $usuarioModel['Email'],
                    'fotoPerfil' => $usuarioModel['Foto_perfil'],
                ]);
                return;
            }

            $caminhoImg = $imagem->moverParaPasta($imagemDePerfil);
            $usuarioModel->inserirFoto($caminhoImg, $id);
            header('Location: /sistemackc/usuario/'.$id);
            exit();
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
            $telefoneFormatado = $novoUsuario->formatarTelefone($telefone);
            $dataFormatada = date('Y-m-d', strtotime($dataNascimento));

            $feedback = "";
            $nomeDaClasseParaErro = "error";

            if ($statusDaValidacaoCpf == "aceito" && $statusDaValidacaoEmail == "aceito" && $statusDaValidacaoSenha == "aceito") {
                $senhaCriptografada = $novoUsuario->criptografarSenha($senha);
                
                $resultado = $novoUsuario->inserirUsuario($nome, $sobrenome, $cpf, $email, $senhaCriptografada, $peso, $dataFormatada, $genero, $telefoneFormatado);
                
                if ($resultado) {
                    $this->login($email, $senha);
                } else {
                    $this->carregarViewComArgumentos('usuario/cadastro', [
                        'feedback' => "Erro ao cadastrar, tente novamente.",
                        'status' => $nomeDaClasseParaErro,
                        
                    ]);
                }
                // Erros e seus feedbacks
            } else {
                $dadosPreenchidos = [$nome, $sobrenome, $cpf, $email, $confirmarEmail, $senha, $confirmarSenha, $peso, $genero, $telefone, $dataNascimento];
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
                    'status' => $nomeDaClasseParaErro,
                    'dados' => $dadosPreenchidos
                ]);
            } 
        } else {
            $this->carregarView('usuario/cadastro');
        }
    }

    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            $usuario = new Usuario();
            $autenticacao = $usuario->autentificar($email, $senha);

            if ($autenticacao === "Sucesso") {
                // Inicia a sessão se não estiver iniciada
                if (!isset($_SESSION)) {
                    session_start();
                }
                $usuarioAutenticado = $usuario->consultarUsuarioPorEmail($email);

                $_SESSION['id'] = $usuarioAutenticado['Id'];
                $_SESSION['nome'] = $usuarioAutenticado['Nome'];

                header('Location: /sistemackc/');
                exit();
            } else {
                $this->carregarViewComArgumentos('usuario/loginUsuario', [
                    'feedback' => $autenticacao,
                    'classe' => 'erro'
                ]);
            }
        } else {
            $this->carregarView('usuario/loginUsuario');
        }
    }

    public function logout() 
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        session_unset();
        session_destroy();

        header("Location: /sistemackc/");
        exit();
    }


}
