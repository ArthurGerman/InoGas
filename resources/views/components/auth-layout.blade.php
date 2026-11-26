{{-- Moldura das telas de entrada (login e cadastro). --}}
@props(['titulo' => 'Entrar'])
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $titulo }} | InoGas</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="48x48">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <meta name="theme-color" content="#0a111c">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
<div class="grid min-h-screen lg:grid-cols-2">

    <!-- Apresentação -->
    <aside class="hidden flex-col justify-between border-r border-line bg-panel/60 p-12 lg:flex">
        <div class="flex items-center gap-3">
            <span class="grid size-10 place-items-center rounded-lg bg-brand/15 text-brand">
                <x-icone nome="chama" />
            </span>
            <span class="text-xl font-semibold">InoGas</span>
        </div>

        <div class="max-w-md">
            <p class="text-sm font-medium text-brand">Monitoramento residencial</p>
            <h1 class="mt-4 text-4xl leading-tight font-semibold text-balance">
                Mais clareza sobre as leituras da sua residência.
            </h1>
            <p class="mt-4 text-soft">
                Acompanhe o sensor, consulte o histórico e mantenha cada leitura no contexto certo.
            </p>
        </div>

        <p class="max-w-md text-xs text-soft">{{ config('inogas.aviso_rodape') }}</p>
    </aside>

    <!-- Formulário -->
    <main class="flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-sm">
            <div class="mb-8 flex items-center gap-3 lg:hidden">
                <span class="grid size-9 place-items-center rounded-lg bg-brand/15 text-brand">
                    <x-icone nome="chama" class="size-5" />
                </span>
                <span class="text-lg font-semibold">InoGas</span>
            </div>

            {{ $slot }}

            <p class="mt-10 text-xs text-soft lg:hidden">{{ config('inogas.aviso_rodape') }}</p>
        </div>
    </main>
</div>
</body>
</html>
