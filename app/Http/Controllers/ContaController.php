<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

/**
 * "Minha conta": nome, e-mail, senha e PIN de silenciamento da própria pessoa que está logada.
 */
class ContaController extends Controller
{
    private function usuarioLogado(): Usuario
    {
        return Usuario::findOrFail(session('usuario_id'));
    }

    public function atualizar(Request $request): JsonResponse
    {
        $usuario = $this->usuarioLogado();

        $dados = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('usuarios', 'email')->ignore($usuario->id)],
        ]);

        $usuario->update($dados);
        session(['usuario_name' => $usuario->name]);

        return response()->json(['mensagem' => 'Dados salvos.', 'name' => $usuario->name]);
    }

    public function senha(Request $request): JsonResponse
    {
        $usuario = $this->usuarioLogado();

        $request->validate([
            'senha_atual' => 'required|string',
            'senha_nova' => 'required|string|min:8|confirmed|different:senha_atual',
        ]);

        if (! Hash::check($request->input('senha_atual'), $usuario->password)) {
            return response()->json([
                'message' => 'A senha atual está incorreta.',
                'errors' => ['senha_atual' => ['A senha atual está incorreta.']],
            ], 422);
        }

        $usuario->password = Hash::make($request->input('senha_nova'));
        $usuario->precisa_trocar_senha = false;
        $usuario->save();

        $request->session()->regenerate();

        return response()->json(['mensagem' => 'Senha trocada.']);
    }

    /** PIN para silenciar o alarme. Só o responsável define. Guardado só com hash. */
    public function pin(Request $request): JsonResponse
    {
        $request->validate([
            'pin' => ['required', 'regex:/^\d{4,8}$/'],
        ], [
            'pin.regex' => 'O PIN deve ter de 4 a 8 números.',
        ]);

        $usuario = $this->usuarioLogado();
        $usuario->pin_hash = Hash::make($request->input('pin'));
        $usuario->save();

        return response()->json(['mensagem' => 'PIN definido.']);
    }
}
