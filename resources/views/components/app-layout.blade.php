{{--
    Moldura das telas internas: barra lateral em dois grupos (Monitoramento e Gestão),
    abas no topo no celular, barra superior com o botão "Ver como morador" (só para o responsável) e rodapé. O papel vem da conta (sessão).
    Uso: <x-app-layout titulo="Painel" ativo="painel"> ...conteúdo... </x-app-layout>
--}}
@props(['titulo' => 'InoGas', 'ativo' => 'painel'])
@php
    $monitoramento = [
        ['id' => 'painel', 'rotulo' => 'Painel', 'rota' => 'painel', 'icone' => 'painel'],
        ['id' => 'historico', 'rotulo' => 'Histórico', 'rota' => 'historico', 'icone' => 'historico'],
        ['id' => 'alertas', 'rotulo' => 'Alertas', 'rota' => 'alertas', 'icone' => 'sino'],
    ];
    $gestao = [
        ['id' => 'residencias', 'rotulo' => 'Minhas casas e sensores', 'rota' => 'residencias', 'icone' => 'casa'],
        ['id' => 'moradores', 'rotulo' => 'Moradores', 'rota' => 'moradores', 'icone' => 'usuarios'],
        ['id' => 'configuracoes', 'rotulo' => 'Configurações', 'rota' => 'configuracoes', 'icone' => 'engrenagem'],
    ];
    $idsGestao = array_column($gestao, 'id');
    $url = fn ($rota) => \Illuminate\Support\Facades\Route::has($rota) ? route($rota) : '#';
    $inogasJs = [
        'unidade' => config('inogas.unidade'),
        'limites' => config('inogas.limites'),
        'semSinalApos' => config('inogas.sem_sinal_apos_segundos'),
    ];
    $papel = session('usuario_papel', 'responsavel') === 'morador' ? 'morador' : 'responsavel';
    $ehResponsavel = $papel === 'responsavel';
    $nomeConta = session('usuario_name', 'Minha conta');
    $inicial = mb_strtoupper(mb_substr((string) session('usuario_name', 'U'), 0, 1));
    $classeLink = fn (bool $ativoAgora) => $ativoAgora
        ? 'border-brand/25 bg-brand/10 text-brand'
        : 'border-transparent text-soft hover:bg-panel-2 hover:text-ink';
@endphp
<!DOCTYPE html>
<html lang="pt-BR" data-perfil="{{ $papel }}" data-papel="{{ $papel }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $titulo }} | InoGas</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="48x48">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <meta name="theme-color" content="#0a111c">
    <script>
        window.INOGAS = @json($inogasJs);
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{ $cabecalho ?? '' }}
</head>
<body class="antialiased">
<div class="flex min-h-screen">

    <!-- Barra lateral (desktop) -->
    <aside class="hidden w-64 shrink-0 border-r border-line bg-panel/60 md:block">
        <div class="sticky top-0 flex h-screen flex-col">
            <div class="flex items-center gap-3 px-5 py-5">
                <span class="grid size-9 place-items-center rounded-lg bg-brand/15 text-brand">
                    <x-icone nome="chama" />
                </span>
                <span class="text-lg font-semibold">InoGas</span>
            </div>

            <nav class="flex-1 overflow-y-auto px-3" aria-label="Principal">
                <p class="px-3 pb-1 text-xs font-medium tracking-wide text-soft/80 uppercase">Monitoramento</p>
                <ul class="space-y-1">
                    @foreach ($monitoramento as $item)
                        <li>
                            <a href="{{ $url($item['rota']) }}"
                               @if ($ativo === $item['id']) aria-current="page" @endif
                               class="flex items-center gap-3 rounded-lg border px-3 py-2.5 text-sm font-medium transition-colors {{ $classeLink($ativo === $item['id']) }}">
                                <x-icone :nome="$item['icone']" class="size-[18px] shrink-0" />
                                {{ $item['rotulo'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                @if ($ehResponsavel)
                <div data-so="responsavel" class="mt-6">
                    <p class="px-3 pb-1 text-xs font-medium tracking-wide text-soft/80 uppercase">Gestão</p>
                    <ul class="space-y-1">
                        @foreach ($gestao as $item)
                            <li>
                                <a href="{{ $url($item['rota']) }}"
                                   @if ($ativo === $item['id']) aria-current="page" @endif
                                   class="flex items-center gap-3 rounded-lg border px-3 py-2.5 text-sm font-medium transition-colors {{ $classeLink($ativo === $item['id']) }}">
                                    <x-icone :nome="$item['icone']" class="size-[18px] shrink-0" />
                                    {{ $item['rotulo'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </nav>

            <div class="border-t border-line p-4">
                <div class="rounded-xl border border-line bg-canvas/50 p-2">
                    <a href="{{ $url('configuracoes') }}"
                       @if ($ativo === 'configuracoes') aria-current="page" @endif
                       class="flex items-center gap-3 rounded-lg border p-1.5 transition-colors {{ $classeLink($ativo === 'configuracoes') }}"
                       title="Abrir Configurações">
                        <span class="grid size-10 shrink-0 place-items-center rounded-full bg-brand/15 text-sm font-semibold text-brand" aria-hidden="true" data-inicial-conta>{{ $inicial }}</span>
                        <span class="min-w-0 flex-1">
                            <span class="block truncate text-sm font-medium text-ink" data-nome-conta>{{ $nomeConta }}</span>
                            <span class="block text-xs text-soft">
                                <span data-so="morador">Visão Morador</span>
                                <span data-so="responsavel">Visão Responsável</span>
                            </span>
                        </span>
                        <x-icone nome="engrenagem" class="size-4 shrink-0 text-soft" />
                    </a>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit"
                            class="flex w-full items-center justify-center gap-2 rounded-lg border border-line px-3 py-2 text-sm font-medium text-soft transition-colors hover:border-risk/40 hover:text-ink">
                        <x-icone nome="sair" class="size-4" /> Sair
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div class="flex min-w-0 flex-1 flex-col">

        <!-- Celular: marca e abas no topo -->
        <div class="border-b border-line bg-panel/60 md:hidden">
            <div class="flex items-center justify-between px-4 py-3">
                <div class="flex items-center gap-2.5">
                    <span class="grid size-8 place-items-center rounded-lg bg-brand/15 text-brand">
                        <x-icone nome="chama" class="size-4" />
                    </span>
                    <span class="font-semibold">InoGas</span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-soft hover:text-ink">Sair</button>
                </form>
            </div>

            <nav class="grid grid-cols-4 gap-1 px-2 pb-2" aria-label="Principal">
                @foreach ($monitoramento as $item)
                    <a href="{{ $url($item['rota']) }}"
                       @if ($ativo === $item['id']) aria-current="page" @endif
                       class="flex flex-col items-center gap-1 rounded-lg border px-1 py-2 text-xs font-medium {{ $classeLink($ativo === $item['id']) }}">
                        <x-icone :nome="$item['icone']" class="size-[18px]" />
                        {{ $item['rotulo'] }}
                    </a>
                @endforeach
                <button type="button" id="btn-mais" aria-expanded="false" aria-controls="menu-mais"
                        class="flex flex-col items-center gap-1 rounded-lg border px-1 py-2 text-xs font-medium {{ $classeLink(in_array($ativo, $idsGestao, true)) }}">
                    <x-icone nome="menu" class="size-[18px]" />
                    Mais
                </button>
            </nav>

            <div id="menu-mais" hidden class="border-t border-line px-2 py-2">
                <ul class="space-y-1">
                    @foreach ($gestao as $item)
                        @if ($ehResponsavel || $item['id'] === 'configuracoes')
                        <li @if ($item['id'] !== 'configuracoes') data-so="responsavel" @endif>
                            <a href="{{ $url($item['rota']) }}"
                               @if ($ativo === $item['id']) aria-current="page" @endif
                               class="flex items-center gap-3 rounded-lg border px-3 py-2.5 text-sm font-medium {{ $classeLink($ativo === $item['id']) }}">
                                <x-icone :nome="$item['icone']" class="size-[18px] shrink-0" />
                                {{ $item['rotulo'] }}
                            </a>
                        </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Barra superior -->
        <header class="flex flex-wrap items-center justify-between gap-3 border-b border-line px-4 py-3 md:px-8">
            <p class="text-sm text-soft">InoGas <span aria-hidden="true">/</span> <span class="text-ink">{{ $titulo }}</span></p>

            @if ($ehResponsavel)
                <button type="button" data-preview-btn aria-pressed="false"
                        title="Mostra as telas como um morador as vê. Não muda nada na conta."
                        class="rounded-lg border border-line px-3 py-1.5 text-sm font-medium text-soft transition-colors hover:text-ink aria-pressed:border-brand/40 aria-pressed:bg-brand/10 aria-pressed:text-brand">
                    <span data-so="responsavel">Ver como morador</span>
                    <span data-so="morador">Voltar à visão de responsável</span>
                </button>
            @endif
        </header>

        <main class="mx-auto w-full max-w-6xl flex-1 px-4 py-8 md:px-8">
            @if (session('aviso'))
                <div role="status" class="mb-6 rounded-lg border border-attn/50 bg-attn/10 px-4 py-3 text-sm text-attn">
                    {{ session('aviso') }}
                </div>
            @endif

            {{ $slot }}
        </main>

        <footer class="border-t border-line px-4 py-4 text-xs text-soft md:px-8">
            {{ config('inogas.aviso_rodape') }}
        </footer>
    </div>
</div>

<script>
    (() => {
        const botao = document.getElementById('btn-mais');
        const painel = document.getElementById('menu-mais');
        if (!botao || !painel) return;
        botao.addEventListener('click', () => {
            const aberto = botao.getAttribute('aria-expanded') === 'true';
            botao.setAttribute('aria-expanded', aberto ? 'false' : 'true');
            painel.hidden = aberto;
        });
    })();
</script>
</body>
</html>
