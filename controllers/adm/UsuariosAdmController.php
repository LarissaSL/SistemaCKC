<?php 

require_once 'models/Usuario.php';
require_once 'models/Imagem.php';

class UsuariosAdmController extends RenderView
{
    public function index()
    {
        $usuario = new Usuario();

        $usuarios = $usuario->consultarTodosOsUsuarios();

        $this->carregarViewComArgumentos('adm/crudUsuarios', [
            'usuarios'=>$usuarios
        ]);
    }

    public function editar($id)
    {
        echo "Editar" . $id;
    }

    public function excluir($id)
    {
        $usuario = new Usuario();
        $excluirFotoDePerfilDoServer = new Imagem();

        // Pegando a info dele para poder excluir a foto de perfil do Servidor
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
}

