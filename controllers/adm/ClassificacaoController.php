<?php

require_once 'models/Resultado.php';

class ClassificacaoController extends RenderView {

    public function mostrarResultados() {
    $resultado = new Resultado();
    $resultado = $resultado->teste();

        $this->carregarViewComArgumentos('adm/crudResultado', [
            'Resultado' => $resultado
        ]);
    }

    public function cadastrar() {
        $this->carregarView('adm/cadastrarResultado');
    }

    public function atualizar() {
        $this->carregarView('adm/atualizarResultado');
    }

    
}
?>