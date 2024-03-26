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

    public function atualizar($id)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $kartodromoModel = new Kartodromo();
        $feedback = "";
        $classe = "";
        $infoKartodromo = $kartodromoModel->selecionarKartodromoPorId($id);
        $dados = [
            $infoKartodromo['Foto'],
            $infoKartodromo['Nome'],
            $infoKartodromo['CEP'],
            $infoKartodromo['Rua'],
            $infoKartodromo['Bairro'],
            $infoKartodromo['Numero'],
            $infoKartodromo['Site']
        ];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $imagem = new Imagem();

            // Dados do formulário
            $nome = $_POST['nome'];
            $cep = $_POST['cep'];
            $rua = $_POST['rua'];
            $bairro = $_POST['bairro'];
            $numero = $_POST['numero'];
            $site = $_POST['site'] ?? '';
            $tratarURL = $kartodromoModel->adicionarPrefixoHttp($site);
            $dados = [$infoKartodromo['Foto'], $nome, $cep, $rua, $bairro, $numero, $site];

            // Verificar se uma nova imagem foi enviada
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $validacaoDaImagem = $imagem->validarImagem($_FILES['foto']);
                if ($validacaoDaImagem !== 'aceito') {
                    $feedback = $validacaoDaImagem;
                    $classe = "erro";
                } else {
                    $caminhoFoto = $imagem->moverParaPasta($_FILES['foto'], 'kartodromo');
                    if (!$caminhoFoto) {
                        $feedback = 'Erro ao salvar nova foto';
                        $classe = "erro";
                    } else {
                        // Buscar informações do kartódromo para obter o nome da imagem antiga
                        $infoKartodromo = $kartodromoModel->selecionarKartodromoPorId($id);
                        $nomeDaFotoAntiga = $infoKartodromo['Foto'];

                        if (!empty($nomeDaFotoAntiga)) {
                            // Excluir a imagem antiga do servidor
                            $caminhoFotoAntiga = "./views/Img/ImgSistema/" . $nomeDaFotoAntiga;
                            $imagem->excluirImagem($caminhoFotoAntiga, 'kartodromo');
                        }
                        // Definir o nome da nova imagem
                        $nomeFoto = basename($caminhoFoto);
                    }
                }
            } else {
                // Se não houver uma nova imagem enviada, manter o nome da imagem antiga
                $nomeFoto = $infoKartodromo['Foto'];
            }

            // Validacao do CEP
            $validarTamanhoCep = $kartodromoModel->verificarCep($cep);
            if ($validarTamanhoCep != 'aceito')
            {
                $feedback = $validarTamanhoCep;
                $classe = "erro";
            } 
            else
            {
                // Atualizar os dados do kartódromo no banco de dados
                $cepFormatado = $kartodromoModel->formatarCep($cep);
                $resultado = $kartodromoModel->alterarKartodromo($id, $nome, $cepFormatado, $rua, $bairro, $numero, $tratarURL, $nomeFoto);

                // Verificar se a alteração foi realizada com sucesso
                if ($resultado === true) {
                    $feedback = 'Kartódromo alterado com sucesso!';
                    $classe = "sucesso";
                    $kartodromoResultado = $kartodromoModel->selecionarKartodromoPorId($id);
                    $dados = [$kartodromoResultado['Foto'], $kartodromoResultado['Nome'], $kartodromoResultado['CEP'], $kartodromoResultado['Rua'], $kartodromoResultado['Bairro'], $kartodromoResultado['Numero'], $kartodromoResultado['Site']];
                } else {
                    $feedback = 'Erro ao alterar o kartódromo: ' . $resultado;
                    $classe = "erro";
                }
            }
            
        }
        // Carregar a view com os dados do kartódromo para edição
        $this->carregarViewComArgumentos('adm/atualizarKartodromo', [
            'feedback' => $feedback,
            'classe' => $classe,
            'dados' => $dados
        ]);
    }
}

?>

