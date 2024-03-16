<?php

require_once 'models/Usuario.php';

class UsuarioController extends RenderView
{
    public function index()
    {

    }

    public function mostrarPerfil($id)
    {
        $usuarioModel = new Usuario();

        $usuario = $usuarioModel->consultarUsuarioPorId($id);

        // Verifica se o usuário foi encontrado
        if ($usuario) {
            $this->carregarViewComArgumentos('perfil', [
                'id' => $usuario['Id'],
                'nome' => $usuario['Nome'],
                'email' => $usuario['Email']
            ]);
        } else {
            echo "Usuário não encontrado com o ID: $id";
        }
    }

    public function cadastrar() 
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome = $_POST['nome'];
            $cpf = $_POST['cpf'];
            $email = $_POST['email'];
            //$senha = $_POST['senha'];
            //$peso = $_POST['peso'];
            //$data_nascimento = $_POST['data_nascimento'];
            //$genero = $_POST['genero'];
            //$telefone = $_POST['telefone'];

            $novoUsuario = new Usuario();
            $resultado = $novoUsuario->inserirUsuario($nome, $cpf, $email, '$senha', 22, '021222', 'Feminino', 1155277239, 'teste.jpg');

            if ($resultado) {
                $feedback = "Usuário cadastrado com Sucesso!";
                $this->carregarViewComArgumentos('cadastro', ['feedback' => $feedback]);
            } else {
                echo "Erro ao cadastrar usuário.";
            }
        } 
        else 
        {
            $this->carregarView('cadastro');
        }
        
    }

    public function login()
    {
        echo "Controller do Login";
    }
}
