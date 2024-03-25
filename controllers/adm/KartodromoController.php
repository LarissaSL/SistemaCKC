<?php

require_once 'models/Kartodromo.php';
require_once 'models/Imagem.php';

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
        $kartodromo = new Kartodromo();
        $kartodromos = [];
        $feedback = '';
        $classe = '';

        // Verifica se tem uma requisição GET na pagina
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $busca = isset($_GET['busca']) ? $_GET['busca'] : '';

            if(!empty($busca))
            {
                $consulta = $kartodromo->consultarKartodromoComFiltro($busca);

                $kartodromos = $consulta['kartodromos'];
                $feedback = $consulta['feedback'];
                $classe = $consulta['classe'];
            } else {
                $kartodromos = $kartodromo->selecionarTodosKartodromos();
            }
            
        } else {
            // Se nao tiver requisição GET, mostra todos
            $kartodromos = $kartodromo->selecionarTodosKartodromos();
        }

        // Carregamento da view
        $this->carregarViewComArgumentos('adm/crudKartodromos', [
            'kartodromos' => $kartodromos,
            'busca' => $busca,
            'feedback' => $feedback,
            'classe' => $classe
        ]);
    }

    public function cadastrar()
    {
        // Verificar se foi feita uma requisição POST para cadastrar o kartodromo
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $kartodromoModel = new Kartodromo();
            $imagem = new Imagem();

            // Dados do formulario
            $nome = $_POST['nome'];
            $cep = $_POST['cep'];
            $rua = $_POST['rua'];
            $bairro = $_POST['bairro'];
            $numero = $_POST['numero'];
            $site = $_POST['site'] ?? '';
            $tratarURL = $kartodromoModel->adicionarPrefixoHttp($site);
            $dados = [$nome, $cep, $rua, $bairro, $numero, $site];
            $feedback = "";
            $classe = "";

            // validacoes
            $validacaoDoNome = $kartodromoModel->verificarNomeKartodromo($nome);
            $validarTamanhoCep = $kartodromoModel->verificarCep($cep);

            // Se o nome do kartódromo já existe ou o CEP não está no tamanho correto
            if ($validacaoDoNome) {
                $feedback = 'Kartódromo já está cadastrado no Sistema';
                $classe = "erro";
            } elseif ($validarTamanhoCep !== 'aceito') {
                $feedback = $validarTamanhoCep;
                $classe = "erro";
            } else {
                if (isset($_FILES['foto'])) {
                    $validacaoDaImagem = $imagem->validarImagem($_FILES['foto']);
                    $caminhoFoto = $imagem->moverParaPasta($_FILES['foto'], 'kartodromo');
                    // Se uma imagem foi enviada e deu algo de errado ao mover para pasta
                    if (!$caminhoFoto) {
                        $feedback = 'Erro ao salvar foto';
                        $classe = "erro";
                    } elseif ($validacaoDaImagem !== 'aceito') {
                        $feedback = $validacaoDaImagem;
                        $classe = "erro";
                    } else {
                        $nomeFoto = basename($caminhoFoto);

                        // Inserir o kartódromo
                        $cepFormatado = $kartodromoModel->formatarCep($cep);
                        $resultado = $kartodromoModel->inserirKartodromo($nome, $cepFormatado, $rua, $bairro, $numero, $tratarURL, $nomeFoto);

                        // Verificar se o cadastro foi realizado com sucesso
                        if ($resultado === true) {
                            $feedback = 'Kartódromo cadastrado com sucesso!';
                            $classe = "sucesso";
                        } else {
                            $feedback = 'Erro ao cadastrar o kartódromo: ' . $resultado;
                            $classe = "erro";
                        }
                    }
                }
            }

            // Carregar a view com o feedback correspondente
            $this->carregarViewComArgumentos('adm/cadastrarKartodromo', [
                'feedback' => $feedback,
                'classe' => $classe,
                'dados' => $dados
            ]);
        } else {
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
            $imagem = new Imagem();

            $infoExcluido = $kartodromo->selecionarKartodromoPorId($id);
            $nomeDaFoto = $infoExcluido['Foto'];
            
            // Excluir o kartódromo do BD
            $caminho = "./views/Img/ImgSistema/" . $nomeDaFoto;
            $infoExcluido = $kartodromo->excluirKartodromo($id);
            $imagem->excluirImagem($caminho, 'kartodromo');
        }

        header('Location: /sistemackc/admtm85/kartodromo');
        exit();
    }
}

?>

