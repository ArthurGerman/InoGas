<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeituraController;
use App\Http\Controllers\LeituraTempoRealController;


Route::apiResource('leituras', LeituraController::class);


Route::post(
    '/leitura-atual',
    [LeituraTempoRealController::class, 'atualizar']
);

Route::get(
    '/leitura-atual',
    [LeituraTempoRealController::class, 'mostrar']
);