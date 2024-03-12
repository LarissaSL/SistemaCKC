<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;

//Esses dois serão usados para caso não exista a tabela no Banco de Dados
use Illuminate\Support\Facades\Schema; 
use Illuminate\Support\Facades\Artisan; 

class CadastroController extends Controller
{
    public function create()
    {
        return view('usuario/cadastro');
    }

    public function store(Request $request)
    {
        // Verificar se a tabela de usuários existe
        if (!Schema::hasTable('usuario')) {
            // Se a tabela de usuários não existir, chame o migration para criar a tabela
            Artisan::call('migrate:fresh', ['--path' => 'database\migrations\2024_03_12_223854_create_usuario_table.php']);
        }

        // Remove caracteres não numéricos do CPF
        $cpf = preg_replace('/[^0-9]/', '', $request->cpf);

        // Verificar se o CPF e Email já está cadastrado
        $cpfExists = Usuario::where('cpf', $cpf)->exists();
        $emailExists = Usuario::where('email', $request->email)->exists();

        // Se o CPF já existe, retornar uma resposta de erro
        if ($cpfExists) {
            return redirect('cadastro')->with('error', 'CPF já cadastrado. Por favor, verifique e tente novamente.');
        } else if ($emailExists) {
            return redirect('cadastro')->with('error', 'E-mail já cadastrado. Por favor, verifique e tente novamente.');
        }

        
        // Criação do usuário
        $usuario = new Usuario();
        $usuario->nome = $request->nome;
        $usuario->cpf = $cpf;
        $usuario->email = $request->email;
        $usuario->senha = bcrypt($request->senha);
        $usuario->data_nascimento = $request->data_nascimento;
        $usuario->genero = $request->genero;
        $usuario->telefone = $request->telefone;
        $usuario->data_registro = now();

        // Salvar o usuário no banco de dados
        $usuario->save();

        // Redireciona com uma mensagem de sucesso
        return redirect('perfil')->with(['success' => 'Seja bem-vindo, ' . $usuario->nome . '!']);
    }
}
