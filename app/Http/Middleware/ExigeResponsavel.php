<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Deixa passar só quem entrou como responsável.
 * Quem entrou antes da mudança de papéis (sem "usuario_papel" na sessão) conta como responsável,
 * porque hoje todas as contas são de responsável.
 * Para chamadas feitas pelo JavaScript da tela, responde em JSON em vez de redirecionar.
 */
class ExigeResponsavel
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->has('usuario_id')) {
            if ($request->expectsJson()) {
                return response()->json(['erro' => 'Sua sessão expirou. Entre de novo.'], 401);
            }

            return redirect('/login');
        }

        if ($request->session()->get('usuario_papel', 'responsavel') !== 'responsavel') {
            if ($request->expectsJson()) {
                return response()->json(['erro' => 'Esta ação é só do responsável.'], 403);
            }

            return redirect('/painel')->with('aviso', 'Esta área é do responsável.');
        }

        return $next($request);
    }
}
