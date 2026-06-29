<?php

use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Leitura;

Route::redirect('/', '/login');

Route::get('/cadastro', [UsuarioController::class, 'cadastro'])->name('cadastro');
Route::post('/cadastro', [UsuarioController::class, 'salvar']);

Route::get('/login', [UsuarioController::class, 'login'])->name('login');
Route::post('/login', [UsuarioController::class, 'autenticar']);

Route::post('/logout', [UsuarioController::class, 'logout'])->name('logout');





// Rota para histórico de alertas
Route::get('/historico', function (Request $request) {
    if (!session()->has('usuario_id')) {
        return redirect('/login');
    }

    $query = Leitura::where('valor', '>', 200);

    if ($request->filled('inicio')) {
        $query->whereDate('created_at', '>=', $request->input('inicio'));
    }

    if ($request->filled('fim')) {
        $query->whereDate('created_at', '<=', $request->input('fim'));
    }

    $alertas = $query
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->withQueryString();

    return view('historico', compact('alertas'));
})->name('historico');







// Rota para relatórios
Route::get('/relatorios', function () {

    if (!session()->has('usuario_id')) {
        return redirect('/login');
    }

    return view('relatorios');

})->name('relatorios');






// Rota para painel
Route::get('/painel', function () {

    if (!session()->has('usuario_id')) {
        return redirect('/login');
    }
    
    return view('painel');

})->name('painel');