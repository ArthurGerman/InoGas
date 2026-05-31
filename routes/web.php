<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\GasController;
//use App\Http\Controllers\LeituraController;

Route::get('/', function () {
    return view('welcome');
});


//Route::resource('gases', GasController::class);
//Route::resource('leituras', LeituraController::class);