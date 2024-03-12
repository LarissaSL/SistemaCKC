<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KartodromoController extends Controller
{
    public function kartodromo() {
        return view('adm/kartodromo');
    }
}
