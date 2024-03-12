<?php

use App\Http\Controllers\Adm\CrudUsuarioController;
use App\Http\Controllers\Adm\KartodromoController;
use App\Http\Controllers\Adm\LoginAdmController;
use App\Http\Controllers\Usuario\CadastroController;
use App\Http\Controllers\Usuario\LoginController;
use App\Http\Controllers\Usuario\PerfilController;
use Illuminate\Support\Facades\Route;


//Index do Usuário
Route::get('/', function () {
    return view('usuario/index');
});

//Index do ADM
Route::get('/admtm85', function () {
    return view('adm/index');
});

//Rotas de Acesso ao Usuário
Route::get('/login' , [LoginController::class, 'login']);
Route::get('/cadastro' , [CadastroController::class, 'cadastro']);
Route::get('/perfil' , [PerfilController::class, 'perfil']);

//Rotas de Acesso do ADM
Route::get('/admtm85/login' , [LoginAdmController::class, 'login']);
Route::get('/admtm85/usuarios' , [CrudUsuarioController::class, 'usuario']);
Route::get('/admtm85/kartodromos' , [KartodromoController::class, 'kartodromo']);