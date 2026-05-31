<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GasController;
use App\Http\Controllers\LeituraController;

Route::apiResource('gases', GasController::class);
Route::apiResource('leituras', LeituraController::class);