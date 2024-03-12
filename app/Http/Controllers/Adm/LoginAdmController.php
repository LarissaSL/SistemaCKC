<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginAdmController extends Controller
{
    public function login() {
        return view('Adm/login');
    }
}
