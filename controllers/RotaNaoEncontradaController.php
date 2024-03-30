<?php

class RotaNaoEncontradaController extends RenderView{
    
    public function index()
    {
        $this->carregarViewComArgumentos('notFound', [
            'feedback' => "A Rota não foi encontrada no nosso Servidor",
            'classe' => "erro"
        ]);
        
        
    }
}
?>