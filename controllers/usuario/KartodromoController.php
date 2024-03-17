<?php

class KartodromoController extends RenderView
{
    public function index()
    {
        $this->carregarView('usuario/kartodromo');
    }
}