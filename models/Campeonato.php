<?php

require_once 'Config/Conexao.php';

class Campeonato
{
    protected $conexao;

    public function __construct()
    {
        $bancoDeDados = new Conexao();
        $this->conexao = $bancoDeDados->getConexao();
    }

    
}

?>