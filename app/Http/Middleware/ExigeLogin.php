<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Exige que alguém tenha entrado no sistema (sessão com "usuario_id").
 * Para chamadas feitas pelo JavaScript da tela, responde 401 em JSON em vez de redirecionar.
 */
class ExigeLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->has('usuario_id')) {
            if ($request->expectsJson()) {
                return response()->json(['erro' => 'Sua sessão expirou. Entre de novo.'], 401);
            }

            return redirect('/login');
        }

        return $next($request);
    }
}
