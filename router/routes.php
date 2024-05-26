<?php

$routes = [
    // Toda Rota nova vai entrando aqui (pasta#Controller#função)
    '/' => 'usuario#SiteUsuarioController#index',
    '/logout' => 'usuario#UsuarioController#logout',
    '/historia' => 'usuario#SiteUsuarioController#historia',
    '/etapas' => 'adm#CorridaController#mostrarCorridasUsuario',
    '/classificacao' => 'adm#ClassificacaoController#exibirTodosOsResultados',
    '/classificacao/corrida/{id}' => 'adm#ClassificacaoController#exibirResultadoUsuario',
    '/classificacao/geral/{id}' => 'adm#ClassificacaoController#exibirResultadoUsuario',


    //Rotas Usuario
    '/usuario/{id}' => 'usuario#UsuarioController#mostrarPerfil',
    '/usuario/login' => 'usuario#UsuarioController#login',
    '/usuario/cadastro' => 'usuario#UsuarioController#cadastrar',
    '/usuario/atualizar/{id}' => 'usuario#UsuarioController#atualizar',
    '/usuario/atualizar/senha/{id}' => 'usuario#UsuarioController#atualizarSenha',
    '/usuario/redefinirSenha/{id}' => 'usuario#UsuarioController#redefinirSenha',


    // Rotas ADM
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

    // Rotas do Campeonato
    '/admtm85/campeonato' => 'adm#CampeonatoController#mostrarCampeonatos',
    '/admtm85/campeonato/cadastrar' => 'adm#CampeonatoController#cadastrar',
    '/admtm85/campeonato/atualizar/{id}' => 'adm#CampeonatoController#atualizar',
    '/admtm85/campeonato/excluir/{id}' => 'adm#CampeonatoController#excluir',

    // Rotas das Corridas
    '/admtm85/corrida' => 'adm#CorridaController#mostrarCorridas',
    '/admtm85/corrida/cadastrar' => 'adm#CorridaController#cadastrar',
    '/admtm85/corrida/atualizar/{id}' => 'adm#CorridaController#atualizar',
    '/admtm85/corrida/excluir/{id}' => 'adm#CorridaController#excluir',

    // Rotas das Resultados
    '/admtm85/resultado' => 'adm#ClassificacaoController#mostrarResultados',
    '/admtm85/resultado/exibir/{id}' => 'adm#ClassificacaoController#exibir',
    '/admtm85/resultado/cadastrar/{id}' => 'adm#ClassificacaoController#cadastrar',
    '/admtm85/resultado/atualizar/{id}' => 'adm#ClassificacaoController#atualizar',
    '/admtm85/resultado/excluir/{id}' => 'adm#ClassificacaoController#excluir',
    '/admtm85/resultado/excluir/corrida/{id}' => 'adm#ClassificacaoController#excluirDireto',


    //Rota para testar Alertas
    '/teste' => 'adm#ClassificacaoController#teste',
];
