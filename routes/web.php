<?php

use App\Http\Controllers\Adm\CrudUsuarioController;
use App\Http\Controllers\Adm\KartodromoController;
use App\Http\Controllers\Adm\LoginAdmController;
use App\Http\Controllers\Usuario\CadastroController;
use App\Http\Controllers\Usuario\LoginController;
use App\Http\Controllers\Usuario\PerfilController;
use App\Mail\teste;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Route;


//Index do Usuário
Route::get('/', function () {
    return view('usuario/index');
});

Route::get('/teste-email', function () {
    Mail::to('larissa021222@gmail.com')->send(new teste());
});

//Index do ADM
Route::get('/admtm85', function () {
    return view('adm/index');
});

//Rotas de Acesso ao Usuário
Route::get('/login' , [LoginController::class, 'login']);
Route::get('/cadastro' , [CadastroController::class, 'create']);
Route::post('/cadastro' , [CadastroController::class, 'store']);
Route::get('/perfil' , [PerfilController::class, 'perfil']);

//Rotas de Acesso do ADM
Route::get('/admtm85/login' , [LoginAdmController::class, 'login']);
Route::get('/admtm85/usuarios' , [CrudUsuarioController::class, 'usuario']);
Route::get('/admtm85/kartodromos' , [KartodromoController::class, 'kartodromo']);