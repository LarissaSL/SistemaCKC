<?php

require_once 'models/Adm.php';

class AdmController extends RenderView
{

    public function index()
    {
        $this->carregarView('adm/menu');
    }


    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $senha = $_POST['senha'];

            $adm = new Adm();
            $autenticacao = $adm->autentificar($username, $senha);

            if ($autenticacao === "Sucesso") {
                // Inicia a sessão se não estiver iniciada
                if (!isset($_SESSION)) {
                    session_start();
                }
                $admAutenticado = $adm->consultarAdmPorUsername($username);

                $_SESSION['username'] = $admAutenticado['Username'];

                header('Location: /sistemackc/admtm85/menu');
                exit();
            } else {
                $this->carregarViewComArgumentos('adm/loginAdm', [
                    'feedback' => $autenticacao,
                    'classe' => 'erro'
                ]);
            }
        } else {
            $this->carregarView('adm/loginAdm');
        }
    }
}


?>