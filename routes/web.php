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

    $query = \App\Models\Alerta::visiveis()->withCount('confirmacoes')->with('silenciadoPor:id,name');

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







// Mantém links antigos de relatórios no fluxo atual.
Route::get('/relatorios', fn () => redirect()->route('historico'))
    ->middleware(\App\Http\Middleware\ExigeLogin::class)
    ->name('relatorios');






// Rota para painel
Route::get('/painel', function () {

    if (!session()->has('usuario_id')) {
        return redirect('/login');
    }
    
    return view('painel');

})->name('painel');

// ---- Colar no FINAL de routes/web.php (não apague nem altere as rotas existentes) ----

// Tela de alertas (exemplos visuais, sem back por enquanto)
Route::get('/alertas', function () {

    if (!session()->has('usuario_id')) {
        return redirect('/login');
    }

    return view('alertas');

})->name('alertas');


// Tela de residências e sensores (exemplos visuais, sem back por enquanto)
Route::get('/residencias', function () {

    if (!session()->has('usuario_id')) {
        return redirect('/login');
    }

    return view('residencias');

})->middleware(\App\Http\Middleware\ExigeResponsavel::class)->name('residencias');

// ---- Colar no FINAL de routes/web.php (não apague nem altere as rotas existentes) ----

// Configurações da conta e dos avisos (exemplos visuais, sem back por enquanto)
Route::get('/configuracoes', function () {

    if (!session()->has('usuario_id')) {
        return redirect('/login');
    }

    return view('configuracoes');

})->name('configuracoes');


// Moradores (exemplos visuais, sem back por enquanto)
Route::get('/moradores', function () {

    if (!session()->has('usuario_id')) {
        return redirect('/login');
    }

    return view('moradores');

})->middleware(\App\Http\Middleware\ExigeResponsavel::class)->name('moradores');

Route::middleware(\App\Http\Middleware\ExigeLogin::class)->group(function () {

    // Minha conta
    Route::post('/conta', [\App\Http\Controllers\ContaController::class, 'atualizar'])->name('conta.atualizar');
    Route::post('/conta/senha', [\App\Http\Controllers\ContaController::class, 'senha'])
        ->middleware('throttle:10,1')
        ->name('conta.senha');
    Route::post('/conta/pin', [\App\Http\Controllers\ContaController::class, 'pin'])
        ->middleware(\App\Http\Middleware\ExigeResponsavel::class)
        ->name('conta.pin');

    // Alertas: estado do alerta ativo, "Estou ciente", silenciar com PIN e modo de teste
    Route::get('/alertas/ativo', [\App\Http\Controllers\AlertaController::class, 'ativo'])->name('alertas.ativo');
    Route::post('/alertas/teste', [\App\Http\Controllers\AlertaController::class, 'teste'])
        ->middleware(\App\Http\Middleware\ExigeResponsavel::class)
        ->name('alertas.teste');
    Route::post('/alertas/{alerta}/ciente', [\App\Http\Controllers\AlertaController::class, 'ciente'])->name('alertas.ciente');
    Route::post('/alertas/{alerta}/silenciar', [\App\Http\Controllers\AlertaController::class, 'silenciar'])
        ->middleware([\App\Http\Middleware\ExigeResponsavel::class, 'throttle:5,1'])
        ->name('alertas.silenciar');
});

Route::middleware([\App\Http\Middleware\ExigeLogin::class, \App\Http\Middleware\ExigeResponsavel::class])->group(function () {

    // Locais
    Route::post('/locais', [\App\Http\Controllers\LocalController::class, 'criar'])->name('locais.criar');
    Route::post('/locais/{local}', [\App\Http\Controllers\LocalController::class, 'renomear'])->name('locais.renomear');
    Route::post('/locais/{local}/apagar', [\App\Http\Controllers\LocalController::class, 'apagar'])->name('locais.apagar');

    // Sensores
    Route::get('/dispositivos/estado', [\App\Http\Controllers\DispositivoController::class, 'estado'])->name('dispositivos.estado');
    Route::post('/dispositivos', [\App\Http\Controllers\DispositivoController::class, 'criar'])->name('dispositivos.criar');
    Route::post('/dispositivos/{dispositivo}', [\App\Http\Controllers\DispositivoController::class, 'atualizar'])->name('dispositivos.atualizar');
    Route::post('/dispositivos/{dispositivo}/token', [\App\Http\Controllers\DispositivoController::class, 'novoToken'])->name('dispositivos.token');
    Route::post('/dispositivos/{dispositivo}/ativo', [\App\Http\Controllers\DispositivoController::class, 'ativo'])->name('dispositivos.ativo');
});

// Moradores (só o responsável)
Route::middleware([\App\Http\Middleware\ExigeLogin::class, \App\Http\Middleware\ExigeResponsavel::class])->group(function () {
    Route::post('/moradores', [\App\Http\Controllers\MoradorController::class, 'criar'])->name('moradores.criar');
    Route::post('/moradores/{morador}', [\App\Http\Controllers\MoradorController::class, 'atualizar'])->name('moradores.atualizar');
    Route::post('/moradores/{morador}/acesso', [\App\Http\Controllers\MoradorController::class, 'redefinirAcesso'])->name('moradores.acesso');
    Route::post('/moradores/{morador}/ativo', [\App\Http\Controllers\MoradorController::class, 'ativo'])->name('moradores.ativo');
});

// Primeiro acesso: tela para trocar a senha temporária (qualquer pessoa logada)
Route::get('/trocar-senha', function () {
    return view('trocar-senha');
})->middleware(\App\Http\Middleware\ExigeLogin::class)->name('trocar-senha');

Route::middleware([\App\Http\Middleware\ExigeLogin::class, \App\Http\Middleware\ExigeResponsavel::class])->group(function () {

    Route::post('/avisos/{local}', [\App\Http\Controllers\AvisoController::class, 'salvar'])->name('avisos.salvar');

    Route::get('/historico/pdf', [\App\Http\Controllers\HistoricoPdfController::class, 'gerar'])->name('historico.pdf');
});
