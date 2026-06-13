<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\GasController;
//use App\Http\Controllers\LeituraController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/cadastro', function () {
    return view('cadastro');
});

Route::get('/painel', function () {
    return view('painel');
});

Route::get('/matriz', function () {
    return view('matriz');
});

Route::get('/historico', function () {
    return view('historico');
});

Route::get('/analise', function () {
    return view('analise');
});

Route::get('/telegram', function () {
    return view('telegram');
});
//Route::resource('gases', GasController::class);
//Route::resource('leituras', LeituraController::class);