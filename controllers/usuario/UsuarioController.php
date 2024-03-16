<?php

require_once 'Config/Conexao.php';

class UsuarioController extends RenderView
{
    public function index()
    {

    }

    public function mostrarPerfil($id)
    {
        //Lógica para mostrar o Perfil do Usuário
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

    //Função para se conectar ao Banco de Dados
    public function getConexao()
    {
        try {
            $conexao = new Conexao();

            // Acessando o método de teste de conexão da classe Conexao
            $conexao->conexaoBancoDeDados();

            echo "Conexão com o banco de dados estabelecida com sucesso!";
        } catch (PDOException $erro) {
            echo "Error! ".$erro->getMessage();
        } 
    }
}