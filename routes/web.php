<?php

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HistoricoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Leitura;

Route::redirect('/', '/login');

Route::get('/cadastro', [UsuarioController::class, 'cadastro'])->name('cadastro');
Route::post('/cadastro', [UsuarioController::class, 'salvar']);

Route::get('/login', [UsuarioController::class, 'login'])->name('login');
Route::post('/login', [UsuarioController::class, 'autenticar']);

Route::post('/logout', [UsuarioController::class, 'logout'])->name('logout');





Route::get('/historico', [HistoricoController::class, 'historico'])->name('historico'); // Rota para histórico de alertas
Route::get('/historico/export', [HistoricoController::class, 'export'])->name('historico.export'); // Rota para exportar histórico de alertas




// Rota para relatórios
Route::get('/relatorio', function () {

    if (!session()->has('usuario_id')) {
        return redirect('/login');
    }

    return view('relatorio');

})->name('relatorio');






// Rota para painel
Route::get('/painel', function () {

    if (!session()->has('usuario_id')) {
        return redirect('/login');
    }
    
    return view('painel');

})->name('painel');