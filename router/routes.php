<?php

$routes = [
    //Toda Rota nova vai entrando aqui (pasta#Controller#função)
    '/' => 'usuario#IndexUsuarioController#index',
    '/logout' => 'usuario#UsuarioController#logout',
    '/kartodromo' => 'usuario#KartodromoController#index',

    //Rotas Usuario
    '/usuario/{id}' => 'usuario#UsuarioController#mostrarPerfil',
    '/usuario/login' => 'usuario#UsuarioController#login',
    '/usuario/cadastro' => 'usuario#UsuarioController#cadastrar',
    '/usuario/atualizar/{id}' => 'usuario#UsuarioController#atualizar',

    //Rotas ADM
    '/admtm85/login' => 'adm#AdmController#login',
    '/admtm85/menu' => 'adm#AdmController#index',

    // CRUD do Usuário
    '/admtm85/usuario' => 'adm#UsuariosAdmController#mostrarUsuarios',
    '/admtm85/usuario/cadastrar' => 'adm#UsuariosAdmController#cadastrar',
    '/admtm85/usuario/{id}' => 'adm#UsuariosAdmController#atualizar',
    '/admtm85/usuario/excluir/{id}' => 'adm#UsuariosAdmController#excluir',


];
