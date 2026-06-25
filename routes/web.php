<?php

use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/cadastro', [UsuarioController::class, 'cadastro'])->name('cadastro');
Route::post('/cadastro', [UsuarioController::class, 'salvar']);

Route::get('/login', [UsuarioController::class, 'login'])->name('login');
Route::post('/login', [UsuarioController::class, 'autenticar']);

Route::post('/logout', [UsuarioController::class, 'logout'])->name('logout');


Route::get('/painel', function () {

    if (!session()->has('usuario_id')) {
        return redirect('/login');
    }
    
    return view('painel');

})->name('painel');