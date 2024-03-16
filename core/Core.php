<?php

class Core 
{
    public function run($routes)
    {
        $url = '/';

        isset($_GET['url']) ? $url .= $_GET['url'] : '';

        $rotaEncontrada = false;

        foreach($routes as $path => $controller) 
        {
            $pattern = '#^'.preg_replace('/{id}/','(\w+)', $path).'$#'; 
            
            if (preg_match($pattern, $url, $matches)) 
            {
                array_shift($matches);
                $rotaEncontrada = true;

                /* 
                Aqui eu to pegando a Pasta, Controller e o Metodo através de um "Split" delimitado pela # lá nas rotas
                */
                [$pastaDoController, $controllerAtual, $metodo] = explode('#', $controller);
                $caminhoDoController = __DIR__."/../controllers/$pastaDoController/$controllerAtual.php";

                if (file_exists($caminhoDoController)) {
                    require_once $caminhoDoController;
                    
                    $newController = new $controllerAtual();
                    $newController->$metodo();
                    exit;
                } 
            }
        } 
        if(!$rotaEncontrada) {
            require_once __DIR__."/../controllers/RotaNaoEncontradaController.php";
            
            $controller = new RotaNaoEncontradaController();
            $controller->index();  
        }  
    }
}

// https://youtu.be/jamKWbvmerQ?t=1139 Vídeo e Horario