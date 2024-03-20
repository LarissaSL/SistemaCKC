<?php 

require_once 'models/Usuario.php';
require_once 'models/Imagem.php';
require_once 'models/Email.php';

class UsuariosAdmController extends RenderView
{
    public function mostrarUsuarios()
    {
        $usuario = new Usuario();

        $usuarios = $usuario->consultarTodosOsUsuarios();

        $this->carregarViewComArgumentos('adm/crudUsuarios', [
            'usuarios'=>$usuarios
        ]);
    }


    public function excluir($id)
    {
        $usuario = new Usuario();
        $excluirFotoDePerfilDoServer = new Imagem();

        // Pegando a info do Usuario para poder excluir a foto de perfil do Servidor
        $infoExcluido = $usuario->consultarUsuarioPorId($id);
        $nomeArquivo = basename($infoExcluido['Foto_perfil']);
        $caminho = ".\\views\Img\ImgUsuario\\" . $nomeArquivo;
        $excluirFotoDePerfilDoServer->excluirImagem($caminho);

        //Excluindo o usuário do BD
        $infoExcluido = $usuario->excluirUsuarioPorId($id);
        echo $infoExcluido['Nome'];

        header('Location: /sistemackc/admtm85/usuario');
        exit();
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

            $statusDaValidacaoCpf = $novoUsuario->validarCpf($cpf, 'cadastrar');
            $statusDaValidacaoEmail = $novoUsuario->validarEmail($email, $confirmarEmail, 'cadastrar');
            $statusDaValidacaoSenha = $novoUsuario->validarSenha($senha, $confirmarSenha);
            $telefoneFormatado = $novoUsuario->formatarTelefone($telefone);
            $dataFormatada = date('Y-m-d', strtotime($dataNascimento));

            $feedback = "";

            if ($statusDaValidacaoCpf == "aceito" && $statusDaValidacaoEmail == "aceito" && $statusDaValidacaoSenha == "aceito") {
                $senhaCriptografada = $novoUsuario->criptografarSenha($senha);
                
                //Cadastrando no BD
                $resultado = $novoUsuario->inserirUsuario($nome, $sobrenome, $cpf, $email, $senhaCriptografada, $peso, $dataFormatada, $genero, $telefoneFormatado);

                //Enviando o E-mail de Boas Vindas
                $emailBoasVindas = new Email();
                $bodyDoEmail = file_get_contents('views\Email\boasVindas.html');
                $nomeDaPessoa = $nome." ".$sobrenome;
                $bodyDoEmail = str_replace('%NOME_DA_PESSOA%', $nomeDaPessoa, $bodyDoEmail);
                $altDoBody = 'Seja bem-vindo(a) ao CKC';
                $statusEnvioDoEmail = $emailBoasVindas->enviarEmail($email, 'Boas vindas ao CKC', $bodyDoEmail , $altDoBody);
                
                if ($resultado == "Sucesso") {
                    header('Location: /sistemackc/admtm85/usuario');
                    exit();
                } else {
                    $this->carregarViewComArgumentos('usuario/cadastro', [
                        'feedback' => "Erro ao cadastrar, tente novamente.",
                        'status' => "error",
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
                    'status' => 'error',
                    'dados' => $dadosPreenchidos
                ]);
            } 
        } else {
            $this->carregarView('usuario/cadastro');
        }
    }

    public function atualizar($id) {
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
            $redirecionar = "";

            session_start();
            if (isset($_SESSION['username']) &&  $_SESSION['username'] == 'admtm85') {
                $redirecionar = "/sistemackc/admtm85/usuario/'.$id";
            } else {
                $redirecionar = "/sistemackc/usuario/$id";
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
                    session_start();
    
                    if ($_SESSION['username'] == 'admtm85') {
                        header('Location: ' . $redirecionar);
                    } else {
                        $_SESSION['email'] = $email;
                        $_SESSION['nome'] = $nome;
                        header('Location: ' . $redirecionar);
                    }
                    exit();
                } else {
                    $feedbackDeAtualizacao = $resultado;
                }
            } else {
                if($statusDaValidacaoCpf !== "aceito")
                {
                    $feedbackDeAtualizacao = $statusDaValidacaoCpf;
                }
                if($statusDaValidacaoEmail !== "aceito")
                {
                    $feedbackDeAtualizacao = $statusDaValidacaoEmail;
                }
            }
    
            echo "<script>
                      alert('$feedbackDeAtualizacao');
                      window.location.href = $redirecionar; 
                  </script>";
            exit();
        } else {
            $this->carregarView('usuario/perfil');
        }
    }
}

