<?php

require_once 'models/Usuario.php';
require_once 'models/Imagem.php';
require_once 'models/Email.php';

class UsuarioController extends RenderView
{

    public function mostrarUsuarios()
    {
        $usuario = new Usuario();
        $usuarios = [];
        $feedback = '';
        $classe = '';

        // Verifica se tem uma requisição GET na pagina
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $busca = isset($_GET['busca']) ? $_GET['busca'] : '';
            $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';

            if(!empty($busca) || !empty($tipo))
            {
                $consulta = $usuario->consultarUsuariosComFiltro($busca, $tipo);

                $usuarios = $consulta['usuarios'];
                $feedback = $consulta['feedback'];
                $classe = $consulta['classe'];
            } else {
                $usuarios = $usuario->consultarTodosOsUsuarios();
            }
            
        } else {
            // Se nao tiver requisição GET, mostra todos
            $usuarios = $usuario->consultarTodosOsUsuarios();
        }

        // Carregaento da view
        $this->carregarViewComArgumentos('adm/crudUsuarios', [
            'usuarios' => $usuarios,
            'busca' => $busca,
            'tipo' => $tipo,
            'feedback' => $feedback,
            'classe' => $classe
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

        if ($usuario) {
            $this->carregarViewComArgumentos('usuario/perfil', [
                'usuario' => $usuario
            ]);
        } else {
            $this->carregarViewComArgumentos('usuario/perfil', [
                'feedbackSobrePerfil' => "Nenhum usuário encontrado com o ID: " . $id
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
                $this->carregarViewComArgumentos('usuario/loginUsuario', [
                    'feedback' => $autenticacao,
                    'classe' => 'erro',
                    'email' => $email
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

    // Funciona pro usuário comum e pro adm atualizar
    public function atualizar($id)
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $usuarioModel = new Usuario();
        $feedback = "";
        $classe = "";
        $infoUsuario = $usuarioModel->consultarUsuarioPorId($id);
        $dados = [
            $infoUsuario['Foto'],
            $infoUsuario['Nome'],
            $infoUsuario['Sobrenome'],
            $infoUsuario['Cpf'],
            $infoUsuario['Email'],
            $infoUsuario['Peso'],
            $infoUsuario['Data_nascimento'],
            $infoUsuario['Genero'],
            $infoUsuario['Telefone']
        ];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $imagem = new Imagem();

            // Dados do formulario
            $nome = $_POST['nome'];
            $sobrenome = $_POST['sobrenome'];
            $cpf = $_POST['cpf'];
            $email = $_POST['email'];
            $peso = $_POST['peso'];
            $genero = $_POST['genero'];
            $telefone = $_POST['telefone'];
            $dataNascimento = $_POST['dataNascimento'];
            $nomeFoto = "";

            // Verificações sobre a IMG
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $validacaoDaImagem = $imagem->validarImagem($_FILES['foto']);
                if ($validacaoDaImagem !== 'aceito') {
                    $feedback = $validacaoDaImagem;
                    $classe = "erro";
                } else {
                    $caminhoFoto = $imagem->moverParaPasta($_FILES['foto'], 'usuario');
                    if (!$caminhoFoto) {
                        $feedback = 'Erro ao salvar nova foto';
                        $classe = "erro";
                    } else {
                        // Salvar a informação do Usuario sobre o nome da Imagem antiga
                        $nomeDaFotoAntiga = $infoUsuario['Foto'];

                        if (!empty($nomeDaFotoAntiga)) {
                            // Excluir a imagem antiga do servidor
                            $caminhoFotoAntiga = "./views/Img/ImgUsuario/" . $nomeDaFotoAntiga;
                            $imagem->excluirImagem($caminhoFotoAntiga);
                        }
                        // Definir o nome da nova imagem
                        $nomeFoto = basename($caminhoFoto);
                    }
                }
            } elseif ($_FILES['foto']['error'] === UPLOAD_ERR_NO_FILE) {
                // Se não houver uma nova imagem enviada, manter o nome da imagem antiga
                $nomeFoto = $infoUsuario['Foto'];
                $validacaoDaImagem = 'aceito';
            }

            if($validacaoDaImagem == 'aceito') {
                // Validações e Formatação do restante de Dados
                $statusDaValidacaoCpf = $usuarioModel->validarCpf($cpf, 'atualizar', $id);
                $statusDaValidacaoEmail = $usuarioModel->validarEmail($email, $email, 'atualizar');
                $telefoneFormatado = $usuarioModel->formatarTelefone($telefone);
                $dataFormatada = date('Y-m-d', strtotime($dataNascimento));

                if ($statusDaValidacaoCpf == "aceito" && $statusDaValidacaoEmail == "aceito") {
                    // Atualizando no BD
                    $resultado = $usuarioModel->atualizarUsuario($id, $nome, $sobrenome, $cpf, $email, $peso, $dataFormatada, $genero, $telefoneFormatado, $nomeFoto);

                    if ($resultado == "atualizado") {
                        if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador')
                        {
                            $feedback = "Atualizado com Sucesso!";
                            $classe = "sucesso";
                        } 
                        else {
                            $_SESSION['email'] = $email;
                            $_SESSION['nome'] = $nome;
                        } 
    
                    } else {
                        $feedback = $resultado;
                        $classe = "erro";
                    }
                } else {
                    if ($statusDaValidacaoCpf !== "aceito") {
                        $feedback = $statusDaValidacaoCpf;
                    }
                    if ($statusDaValidacaoEmail !== "aceito") {
                        $feedback = $statusDaValidacaoEmail;
                    }
                }
            }
            // Carregar a view com os dados do Usuário para e pós edição
            $usuario = $usuarioModel->consultarUsuarioPorId($id);
            $this->carregarViewComArgumentos('usuario/perfil', [
                'feedback' => $feedback,
                'classe' => $classe,
                'dados' => $dados,
                'usuario' => $usuario
            ]);
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
            $excluirFotoDePerfilDoServer->excluirImagem($caminho);

            //Excluindo o usuário do BD
            $infoExcluido = $usuario->excluirUsuarioPorId($id);
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
