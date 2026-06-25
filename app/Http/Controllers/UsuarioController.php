<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function cadastro()
    {
        return view('auth.cadastro');
    }

    public function salvar(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|confirmed'
        ]);

        Usuario::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect('/login')
            ->with('sucesso', 'Usuário cadastrado com sucesso!');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function autenticar(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $usuario = Usuario::where('email', $request->email)->first();

        if ($usuario && Hash::check($request->password, $usuario->password)) {

            session([
                'usuario_id' => $usuario->id,
                'usuario_name' => $usuario->name
            ]);

            return redirect('/painel');
        }

        return back()->with('erro', 'E-mail ou senha inválidos.');
    }

    public function logout()
    {
        session()->flush();

        return redirect('/login');
    }
}
