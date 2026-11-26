<x-auth-layout titulo="Entrar">
    <p class="text-sm font-medium text-brand">Acesso ao InoGas</p>
    <h2 class="mt-2 text-3xl font-semibold">Entre para acompanhar</h2>
    <p class="mt-2 text-sm text-soft">Use seu e-mail e sua senha para acessar o monitoramento.</p>

    @if (session('erro'))
        <div role="alert" class="mt-6 rounded-lg border border-risk/50 bg-risk/10 px-3.5 py-2.5 text-sm text-risk">
            {{ session('erro') }}
        </div>
    @endif

    @if (session('sucesso'))
        <div role="status" class="mt-6 rounded-lg border border-brand/50 bg-brand/10 px-3.5 py-2.5 text-sm text-brand">
            {{ session('sucesso') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
        @csrf

        <x-campo nome="email" rotulo="E-mail" tipo="email" placeholder="seuemail@exemplo.com" autocomplete="email" />
        <x-campo nome="password" rotulo="Senha" tipo="password" placeholder="Digite sua senha" autocomplete="current-password" />

        <button type="submit"
                class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-brand px-4 py-3 text-sm font-semibold text-brand-ink transition-colors hover:bg-brand/90">
            Entrar <x-icone nome="seta" class="size-4" />
        </button>
    </form>

    <p class="mt-8 text-sm text-soft">
        Ainda não tem conta?
        <a href="{{ route('cadastro') }}" class="font-medium text-brand hover:underline">Criar conta</a>
    </p>
</x-auth-layout>
