<?php

$routes = [
    //Toda Rota nova vai entrando aqui (pasta#Controller#função)
    '/' => 'usuario#IndexUsuarioController#index',
    '/usuario/{id}' => 'usuario#UsuarioController#mostrarPerfil',
    '/usuario/login' => 'usuario#UsuarioController#login',
    '/usuario/cadastro' => 'usuario#UsuarioController#cadastrar'
];

?>