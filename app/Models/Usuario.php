<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuario';

    protected $fillable = [
        'nome',
        'cpf',
        'email',
        'senha',
        'data_nascimento',
        'genero',
        'telefone',
        'data_registro'
    ];

    protected $dates = [
        'data_nascimento',
        'data_registro'
    ];

    public $timestamps = false;
}
