<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CrudUsuarioController extends Controller
{
    public function usuario() {
        return view('adm/usuario');
    }
}
