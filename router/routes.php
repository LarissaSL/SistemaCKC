<?php

$routes = [
    //Toda Rota nova vai entrando aqui (pasta#Controller#função)
    '/' => 'usuario#IndexUsuarioController#index',
    '/logout' => 'usuario#UsuarioController#logout',
    '/kartodromo' => 'usuario#KartodromoController#index',

    //Essas Rotas tem solicitações GET e POST
    '/usuario/{id}' => 'usuario#UsuarioController#mostrarPerfil',
    '/usuario/login' => 'usuario#UsuarioController#login',
    '/usuario/cadastro' => 'usuario#UsuarioController#cadastrar',
    '/usuario/atualizar/{id}' => 'usuario#UsuarioController#atualizar',

    //CRUD do Usuario (Ler, Alterar, Excluir)
    '/admtm85/usuario' => 'adm#UsuariosAdmController#index',
    '/admtm85/usuario/{id}' => 'usuario#UsuarioController#mostrarPerfil',
    '/admtm85/usuario/excluir/{id}' => 'adm#UsuariosAdmController#excluir',
    

];

?>