<?php

namespace App\Http\Middleware;

use App\Models\Usuario;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Roda em TODA página do site (grupo "web") e confere a conta no banco a cada pedido:
 *  - conta desativada ou apagada: encerra a sessão;
 *  - o papel (responsável ou morador) vem sempre do banco, então mudar o papel vale na hora;
 *  - quem ainda usa a senha temporária só consegue abrir a tela de troca de senha.
 * Quem não entrou no sistema passa direto.
 */
class SincronizaConta
{
    public function handle(Request $request, Closure $next): Response
    {
        $sessao = $request->session();

        if (! $sessao->has('usuario_id')) {
            return $next($request);
        }

        $usuario = Usuario::find($sessao->get('usuario_id'));

        if (! $usuario || ($usuario->ativo === false)) {
            $sessao->flush();

            if ($request->expectsJson()) {
                return response()->json(['erro' => 'Sua conta está desativada. Fale com o responsável.'], 401);
            }

            return redirect('/login')->with('erro', 'Sua conta está desativada. Fale com o responsável.');
        }

        $sessao->put('usuario_papel', $usuario->papel ?: 'responsavel');
        $sessao->put('usuario_name', $usuario->name);

        if ($usuario->precisa_trocar_senha && ! $request->is('trocar-senha', 'conta/senha', 'logout', 'login', 'cadastro', 'api/*')) {
            if ($request->expectsJson()) {
                return response()->json(['erro' => 'Troque a senha temporária antes de continuar.'], 423);
            }

            return redirect('/trocar-senha');
        }

        return $next($request);
    }
}
