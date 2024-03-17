<?php

$routes = [
    //Toda Rota nova vai entrando aqui (pasta#Controller#função)
    '/' => 'usuario#IndexUsuarioController#index',
    '/logout' => 'usuario#UsuarioController#logout',

    '/usuario/{id}' => 'usuario#UsuarioController#mostrarPerfil',
    '/usuario/login' => 'usuario#UsuarioController#login',

    //Essa Rota é para solicitações GET e POST
    '/usuario/cadastro' => 'usuario#UsuarioController#cadastrar'

];

?>