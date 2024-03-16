<?php

class RenderView 
{
    public function carregarView($view) {
        require_once __DIR__ . "/../views/$view.php";
    }

    public function carregarViewComArgumentos($view, $args) {
        extract($args);
        
        require_once __DIR__ . "/../views/$view.php";
    }
}