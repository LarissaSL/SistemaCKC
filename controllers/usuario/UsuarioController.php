<?php

require_once 'models/Usuario.php';
require_once 'models/Imagem.php';
require_once 'models/Email.php';

class UsuarioController extends RenderView
{

    public function mostrarPerfil($id)
    {
        $usuarioModel = new Usuario();
        // Carregar o perfil do usuário
        $usuario = $usuarioModel->consultarUsuarioPorId($id);

        // Verificar se foi feita uma requisição POST para atualizar a foto de perfil e verificar se ela passa nas validações
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['fotoPerfil'])) {
            $imagemDePerfil = $_FILES['fotoPerfil'];
            $imagem = new Imagem();

            $statusFormatoDaImagem = $imagem->validarImagem($imagemDePerfil);

            if ($statusFormatoDaImagem !== "aceito") {
                $this->carregarViewComArgumentos('usuario/perfil', [
                    'feedbackDaImagem' => $statusFormatoDaImagem,
                    'usuario' => $usuario,
                    'classe' => 'erro'
                ]);
                exit();
            } else {
                $caminhoImg = $imagem->moverParaPasta($imagemDePerfil);
                $usuarioModel->inserirFoto($caminhoImg, $id);
                if ($_SESSION['tipo'] === 'Administrativo') {
                    header('Location: /sistemackc/admtm85/usuario/' . $id);
                } else {
                    header('Location: /sistemackc/usuario/' . $id);
                }
                exit();
            }
        }

        // Se não tiver requisição POST então só carrega o perfil
        if ($usuario) {
            $this->carregarViewComArgumentos('usuario/perfil', [
                'usuario' => $usuario
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
            $tipo = 'Comum';

            $feedback = "";
            $nomeDaClasseParaErro = "error";
            $dataFormatada = date('Y-m-d', strtotime($dataNascimento));

            $novoUsuario = new Usuario();

            $statusDaValidacaoCpf = $novoUsuario->validarCpf($cpf, 'cadastrar');
            $statusDaValidacaoEmail = $novoUsuario->validarEmail($email, $confirmarEmail, 'cadastrar');
            $statusDaValidacaoSenha = $novoUsuario->validarSenha($senha, $confirmarSenha);
            $telefoneFormatado = $novoUsuario->formatarTelefone($telefone);

            if ($statusDaValidacaoCpf == "aceito" && $statusDaValidacaoEmail == "aceito" && $statusDaValidacaoSenha == "aceito") {
                $senhaCriptografada = $novoUsuario->criptografarSenha($senha);

                //Cadastrando no BD
                $resultado = $novoUsuario->inserirUsuario($tipo, $nome, $sobrenome, $cpf, $email, $senhaCriptografada, $peso, $dataFormatada, $genero, $telefoneFormatado);

                //Enviando o E-mail de Boas Vindas
                $emailBoasVindas = new Email();
                $bodyDoEmail = file_get_contents('views\Email\boasVindas.html');
                $nomeDaPessoa = $nome . " " . $sobrenome;
                $bodyDoEmail = str_replace('%NOME_DA_PESSOA%', $nomeDaPessoa, $bodyDoEmail);
                $altDoBody = 'Seja bem-vindo(a) ao CKC';
                $statusEnvioDoEmail = $emailBoasVindas->enviarEmail($email, 'Boas vindas ao CKC', $bodyDoEmail, $altDoBody);

                if ($resultado && $statusEnvioDoEmail == "Sucesso") {
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
            $usuario = $usuario->consultarUsuarioPorEmail($email);

            if ($autenticacao === "Sucesso") {
                // Inicia a sessão se não estiver iniciada
                if (!isset($_SESSION)) {
                    session_start();
                    // Caso já tenha o nome na sessão, destroi ela e inicia novamente
                    if (isset($_SESSION['nome'])) {
                        session_unset();
                        session_destroy();
                        session_start();
                    }
                }

                $_SESSION['id'] = $usuario['Id'];
                $_SESSION['nome'] = $usuario['Nome'];
                $_SESSION['tipo'] = $usuario['Tipo'];
                $_SESSION['email'] = $usuario['Email'];

                $rotaParaRedirecionar = $_SESSION['tipo'] == 'Comum' ? "/sistemackc/usuario/{$usuario['Id']}" : "/sistemackc/admtm85/menu";
                header('Location:'.$rotaParaRedirecionar);
                exit();
                
            } else {
                $viewParaRedirecionar = $usuario['Tipo'] == 'Comum' ? "usuario/loginUsuario" : "adm/loginAdm";
                $this->carregarViewComArgumentos($viewParaRedirecionar, [
                    'feedback' => $autenticacao,
                    'classe' => 'erro'
                ]);
            }
        } else {
            $urlAtual = $_SERVER['REQUEST_URI'];
            if (strpos($urlAtual, 'admtm85') !== false) {
                $this->carregarView('adm/loginAdm');
            } else {
                $this->carregarView('usuario/loginUsuario');
            }
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

    public function atualizar($id)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome = $_POST['nome'];
            $sobrenome = $_POST['sobrenome'];
            $cpf = $_POST['cpf'];
            $email = $_POST['email'];
            $peso = $_POST['peso'];
            $genero = $_POST['genero'];
            $telefone = $_POST['telefone'];
            $dataNascimento = $_POST['dataNascimento'];

            $atualizarUsuario = new Usuario();

            $feedbackDeAtualizacao = "";

            $statusDaValidacaoCpf = $atualizarUsuario->validarCpf($cpf, 'atualizar', $id);
            $statusDaValidacaoEmail = $atualizarUsuario->validarEmail($email, $email, 'atualizar');
            $telefoneFormatado = $atualizarUsuario->formatarTelefone($telefone);
            $dataFormatada = date('Y-m-d', strtotime($dataNascimento));

            if ($statusDaValidacaoCpf == "aceito" && $statusDaValidacaoEmail == "aceito") {
                // Atualizando no BD
                $resultado = $atualizarUsuario->atualizarUsuario($id, $nome, $sobrenome, $cpf, $email, $peso, $dataFormatada, $genero, $telefoneFormatado);

                if ($resultado == "atualizado") {
                    session_start();
                    $_SESSION['email'] = $email;
                    $_SESSION['nome'] = $nome;
                    header('Location: /sistemackc/usuario/' . $id);
                    exit();
                } else {
                    $feedbackDeAtualizacao = $resultado;
                }
            } else {
                if ($statusDaValidacaoCpf !== "aceito") {
                    $feedbackDeAtualizacao = $statusDaValidacaoCpf;
                }
                if ($statusDaValidacaoEmail !== "aceito") {
                    $feedbackDeAtualizacao = $statusDaValidacaoEmail;
                }
            }
            echo "<script>
                      alert('$feedbackDeAtualizacao');
                      window.location.href = '/sistemackc/usuario/$id'; 
                  </script>";
                exit();
        }
    }
}
