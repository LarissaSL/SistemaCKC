<?php

$routes = [
    //Toda Rota nova vai entrando aqui
    '/' => 'usuario#IndexUsuarioController#index',
    '/usuario/{id}' => 'usuario#UsuarioController#mostrarPerfil',
    '/usuario/login' => 'usuario#UsuarioController#login'
];

?>