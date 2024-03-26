<?php

$routes = [
    // Toda Rota nova vai entrando aqui (pasta#Controller#função)
    '/' => 'usuario#IndexUsuarioController#index',
    '/logout' => 'usuario#UsuarioController#logout',

    //Rotas Usuario
    '/usuario/{id}' => 'usuario#UsuarioController#mostrarPerfil',
    '/usuario/login' => 'usuario#UsuarioController#login',
    '/usuario/cadastro' => 'usuario#UsuarioController#cadastrar',
    '/usuario/atualizar/{id}' => 'usuario#UsuarioController#atualizar',
    '/usuario/atualizar/senha/{id}' => 'usuario#UsuarioController#atualizarSenha',

    // Rotas ADM
    '/admtm85/login' => 'usuario#UsuarioController#login',
    '/admtm85/menu' => 'adm#AdmController#index',

    // CRUD do Usuário
    '/admtm85/usuario' => 'usuario#UsuarioController#mostrarUsuarios',
    '/admtm85/usuario/cadastrar' => 'usuario#UsuarioController#cadastrar',
    '/admtm85/usuario/{id}' => 'usuario#UsuarioController#mostrarPerfil',
    '/admtm85/usuario/atualizar/{id}' => 'usuario#UsuarioController#atualizar',
    '/admtm85/usuario/atualizar/senha/{id}' => 'usuario#UsuarioController#atualizarSenha',
    '/admtm85/usuario/excluir/{id}' => 'usuario#UsuarioController#excluir',

    // Rotas do Kartodromo
    '/kartodromo' => 'adm#KartodromoController#index',
    '/admtm85/kartodromo' => 'adm#KartodromoController#mostrarKartodromos',
    '/admtm85/kartodromo/cadastrar' => 'adm#KartodromoController#cadastrar',
    '/admtm85/kartodromo/atualizar/{id}' => 'adm#KartodromoController#atualizar',
    '/admtm85/kartodromo/excluir/{id}' => 'adm#KartodromoController#excluir',


];
