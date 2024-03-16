<?php

class UsuarioController extends RenderView
{
    public function index()
    {

    }

    public function mostrarPerfil()
    {
        //Lógica para mostrar o Perfil do Usuário
        $url = $_SERVER['REQUEST_URI'];
        $parteDaUrl = explode('/', $url);
        $id = end($parteDaUrl);

        echo "Perfil do Usuario\nID: " . $id;
        $this->carregarViewComArgumentos('perfil', [
            'nome' => 'Larissa',
            'id' => $id,
            'email' => 'email@teste'
        ]);

        
    }

    public function login()
    {
        echo "Controller do Login";
    }
}