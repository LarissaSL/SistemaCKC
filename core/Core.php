<?php

class Core 
{
    public function run($routes)
    {
        $url = isset($_GET['url']) ? '/' . rtrim($_GET['url'], '/') : '/';

        $rotaEncontrada = false;

        foreach ($routes as $path => $controller) 
        {
            // Criando uma expressão regular para a rota
            $pattern = '#^' . str_replace(['/', '{id}'], ['\/', '(\w+)'], $path) . '$#'; 
            
            // Verifica se a rota contém parâmetros
            $partesDaUrl = explode('/', $url);
            $ultimoParametroDaUrl = end($partesDaUrl);
            $comParametros = preg_match('/^\d+$/', $ultimoParametroDaUrl) === 1;

            // Divide o nome do controller e o método
            [$pastaDoController, $controllerAtual, $metodo] = explode('#', $controller);
            
            $caminhoDoController = __DIR__ . "/../controllers/$pastaDoController/$controllerAtual.php";

            // Se a rota não contém parâmetros e também verifica se a URL é exatamente igual à rota definida
            if (!$comParametros && $url === $path) 
            {
                $rotaEncontrada = true;

                if (file_exists($caminhoDoController)) {
                    require_once $caminhoDoController;
                    
                    $newController = new $controllerAtual();
                    $newController->$metodo(); 
                } 
                break;
            }
            
            // Se a rota contém parâmetros númericos
            if ($comParametros && preg_match($pattern, $url, $matches)) 
            {
                $rotaEncontrada = true;
                array_shift($matches);
 
                if (file_exists($caminhoDoController)) {
                    require_once $caminhoDoController;
                     
                    $newController = new $controllerAtual();
                    $newController->$metodo(...$matches); 
                } 
                break;
            }
        } 

        // Caso a rota não seja encontrada entra aqui
        if (!$rotaEncontrada) {
            require_once __DIR__ . "/../controllers/RotaNaoEncontradaController.php";
            
            $controller = new RotaNaoEncontradaController();
            $controller->index();  
        }  
    }
}

?>
