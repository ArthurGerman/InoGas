<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/cadastro', function () {
    return view('auth.cadastro');
})->name('cadastro');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');


Route::get('/painel', function () {
    return view('painel');
})->name('painel');