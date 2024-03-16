<?php

    define('HOST', 'localhost');
    define('DATABASENAME', 'ckc_bd');
    define('USER', 'root');
    define('PASSWORD', '');

    class Conexao 
    {
        protected $conexao;

        function __construct()
        {
            $this->conexaoBancoDeDados();
        }

        function conexaoBancoDeDados()
        {
            try{
                $this->conexao = new PDO('mysql:host='.HOST.';dbname='.DATABASENAME, USER, PASSWORD);
            } 
            catch (PDOException $erro)
            {
                echo "Error!".$erro->getMessage();
            }
        }
    }

?>