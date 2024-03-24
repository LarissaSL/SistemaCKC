<?php

require_once 'models/Kartodromo.php';

class KartodromoController extends RenderView
{
    public function index()
    {
        $kartodromoModel = new Kartodromo();
        $kartodromos = $kartodromoModel->selecionarTodosKartodromos();

        if (!empty($kartodromos))
        {
            $this->carregarViewComArgumentos('usuario/kartodromo', [
                'kartodromos'=> $kartodromos
            ]);
        } 
        else{
            $this->carregarViewComArgumentos('usuario/kartodromo', [
                'feedback'=> 'Nenhum kartódromo cadastrado.',
                'classe' => 'erro'
            ]);
        }  
    }

    public function mostrarKartodromos()
    {
        $kartodromoModel = new Kartodromo();

        $kartodromos = $kartodromoModel->selecionarTodosKartodromos();

        $this->carregarViewComArgumentos('adm/crudKartodromos', [
            'kartodromos' => $kartodromos
        ]);
    }

    public function cadastrar()
    {
        // Verificar se foi feita uma requisição POST para cadastrar o kartódromo
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $kartodromoModel = new Kartodromo();

            // Dados do formulário
            $nome = $_POST['nome'];
            $cep = $_POST['cep'];
            $rua = $_POST['rua'];
            $bairro = $_POST['bairro'];
            $numero = $_POST['numero'];
            $site = $_POST['site'] ?? '';
            $tratarURL = $kartodromoModel->adicionarPrefixoHttp($site);

            // Inserir o kartódromo
            $resultado = $kartodromoModel->inserirKartodromoSeNaoExistir($nome, $cep, $rua, $bairro, $numero, $tratarURL);

            // Verificar se o cadastro foi realizado com sucesso
            if ($resultado === true) {
                $this->carregarViewComArgumentos('adm/cadastrarKartodromo', [
                    'feedback'=> 'Kartódromo cadastrado com sucesso!',
                    'classe'=>'sucesso'
                ]);
            } else {
                $this->carregarViewComArgumentos('adm/cadastrarKartodromo', [
                    'feedback'=> 'Erro ao cadastrar o kartódromo: ' . $resultado,
                    'classe'=>'erro'
                ]);
            }
        } 
        else {
            $this->carregarView('adm/cadastrarKartodromo');
        }
    }

    public function excluir($id)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'Administrador') {
            $kartodromo = new Kartodromo();
            
            //Excluindo o Kartodromo do BD
            $infoExcluido = $kartodromo->excluirKartodromo($id);
        }

        header('Location: /sistemackc/admtm85/kartodromo');
        exit();
    }
}

?>

