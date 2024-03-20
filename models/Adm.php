<?php

require_once 'Config/Conexao.php';

class Adm 
{
    protected $conexao;

    public function __construct()
    {
        $bancoDeDados = new Conexao();
        $this->conexao = $bancoDeDados->getConexao();
    }
    
    public function consultarAdmPorUsername($username)
    {
        try {
            $consulta = $this->conexao->prepare("SELECT * FROM adm WHERE Username = :username");
            $consulta->bindValue(':username', $username);
            $consulta->execute();
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
            
            if ($resultado) {
                return $resultado;
            } else {
                return false;
            }
        } catch (PDOException $erro) {
            echo "Erro na consulta: " . $erro->getMessage();
            return false;
        }
    }
    
    
    public function autentificar($username, $senha) 
    {
        $adm = $this->consultarAdmPorUsername($username);

        if($adm !== null) {
            if(password_verify($senha, $adm['Senha'])){
                return "Sucesso";
            } else {
                return "Senha inválida";
            }
        } else {
            return "Username inválido";
        }
    }
}

?>