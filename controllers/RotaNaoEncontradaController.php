<?php
class RotaNaoEncontradaController {
    
    public function index()
    {
        echo "Rota não encontrada<br>";
        echo $_SERVER['REQUEST_URI'];
    }
}
?>