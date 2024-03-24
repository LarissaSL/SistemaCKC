<?php

require_once 'models/Usuario.php';
require_once 'models/Imagem.php';
require_once 'models/Email.php';

class UsuarioController extends RenderView
{

    public function mostrarUsuarios()
    {
        $usuario = new Usuario();

        $usuarios = $usuario->consultarTodosOsUsuarios();

        $this->carregarViewComArgumentos('adm/crudUsuarios', [
            'usuarios' => $usuarios
        ]);
    }

    public function mostrarPerfil($id)
    {
        $usuarioModel = new Usuario();
        if (!isset($_SESSION)) {
            session_start();
        }
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
                $caminhoImg = $imagem->moverParaPasta($imagemDePerfil, 'usuario');
                $usuarioModel->inserirFoto($caminhoImg, $id);
                if ($_SESSION['tipo'] == 'Administrador') {
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

    // Funciona pro usuário comum e pro adm cadastrar
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
                    if (!isset($_SESSION)) {
                        session_start();
                    }
                    if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador'){
                        header('Location: /sistemackc/admtm85/usuario');
                        exit();
                    } 
                    else
                    {
                        $this->login($email, $senha);
                    }  
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
                $urlAtual = $_SERVER['REQUEST_URI'];
                if (strpos($urlAtual, 'admtm85') !== false) {
                    $viewParaRedirecionar = "adm/loginAdm"; 
                } else
                {
                    $viewParaRedirecionar = "usuario/loginUsuario";
                }
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

    // Funciona pro usuário comum e pro adm atualizar
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

            if (!isset($_SESSION)) {
                session_start();
            }
            $feedbackDeAtualizacao = "";

            $statusDaValidacaoCpf = $atualizarUsuario->validarCpf($cpf, 'atualizar', $id);
            $statusDaValidacaoEmail = $atualizarUsuario->validarEmail($email, $email, 'atualizar');
            $telefoneFormatado = $atualizarUsuario->formatarTelefone($telefone);
            $dataFormatada = date('Y-m-d', strtotime($dataNascimento));

            if ($statusDaValidacaoCpf == "aceito" && $statusDaValidacaoEmail == "aceito") {
                // Atualizando no BD
                $resultado = $atualizarUsuario->atualizarUsuario($id, $nome, $sobrenome, $cpf, $email, $peso, $dataFormatada, $genero, $telefoneFormatado);

                if ($resultado == "atualizado") {
                    if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador')
                    {
                        header('Location: /sistemackc/admtm85/usuario/' . $id);
                        exit();
                    } 
                    else {
                        $_SESSION['email'] = $email;
                        $_SESSION['nome'] = $nome;
                        header('Location: /sistemackc/usuario/' . $id);
                        exit();
                    } 

                    
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
            $UrlParaRedirecionar = $_SESSION['tipo'] == 'Administrador' ? '/sistemackc/admtm85/usuario/'.$id : '/sistemackc/usuario/'.$id;
            echo "<script>
                    alert('$feedbackDeAtualizacao');
                    window.location.href = '$UrlParaRedirecionar'; 
                  </script>";
            exit();
        }    
    }

    public function excluir($id)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
            $usuario = new Usuario();
            $excluirFotoDePerfilDoServer = new Imagem();

            // Pegando a info do Usuario para poder excluir a foto de perfil do Servidor
            $infoExcluido = $usuario->consultarUsuarioPorId($id);
            $nomeArquivo = basename($infoExcluido['Foto']);
            $caminho = ".\\views\Img\ImgUsuario\\" . $nomeArquivo;
            $excluirFotoDePerfilDoServer->excluirImagem($caminho, 'usuario');

            //Excluindo o usuário do BD
            $infoExcluido = $usuario->excluirUsuarioPorId($id);
            echo $infoExcluido['Nome'];
        }

        header('Location: /sistemackc/admtm85/usuario');
        exit();
    }

    // Funciona pro usuário comum
    public function atualizarSenha($id)
    {
        $usuario = new Usuario();
        $usuarioDados = $usuario->consultarUsuarioPorId($id); 
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $senha = $_POST['senha'];
            $senhaConfirmacao = $_POST['confirmarSenha'];
        
            $feedbackDeSenha = $usuario->validarSenha($senha, $senhaConfirmacao);
            
            if ($feedbackDeSenha == "aceito") {
                $feedbackDeAtualizacao = $usuario->trocarSenha($id, $senha);

                if($feedbackDeAtualizacao == "Senha atualizada com sucesso")
                {
                    $this->carregarViewComArgumentos('usuario/alterarSenha', [
                        'feedback' => $feedbackDeAtualizacao,
                        'status' => 'sucesso',
                        'usuario'=> $usuarioDados
                    ]);
                } 
                else 
                {
                    $this->carregarViewComArgumentos('usuario/alterarSenha', [
                        'feedback' => $feedbackDeAtualizacao,
                        'status' => 'erro',
                        'usuario'=> $usuarioDados
                    ]);  
                } 
                
            } else {
                $this->carregarViewComArgumentos('usuario/alterarSenha', [
                    'feedback' => $feedbackDeSenha,
                    'status' => 'erro',
                    'usuario'=> $usuarioDados
                ]); 
            }
        } 
        else
        {
            if($usuarioDados == false)
            {
                $this->carregarViewComArgumentos('usuario/alterarSenha', [
                    'feedback' => "Usuário com ID $id não encontrado",
                    'status' => 'erro',
                ]);
            }
            $this->carregarViewComArgumentos('usuario/alterarSenha', [
                'usuario'=> $usuarioDados
            ]);
        }
    }

}
