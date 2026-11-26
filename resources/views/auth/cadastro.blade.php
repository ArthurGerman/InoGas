<x-auth-layout titulo="Criar conta de responsável">
    <p class="text-sm font-medium text-brand">Novo por aqui</p>
    <h2 class="mt-2 text-3xl font-semibold">Crie sua conta de responsável</h2>
    <p class="mt-2 text-sm text-soft">Preencha os dados para acompanhar o monitoramento.</p>
    <p class="mt-3 rounded-lg border border-line bg-panel px-3.5 py-2.5 text-xs text-soft">
        Contas de morador são criadas pelo responsável, na área Moradores.
    </p>

    <form method="POST" action="{{ route('cadastro') }}" class="mt-8 space-y-5">
        @csrf

        <x-campo nome="name" rotulo="Nome" placeholder="Como você quer ser chamado" autocomplete="name" />
        <x-campo nome="email" rotulo="E-mail" tipo="email" placeholder="seuemail@exemplo.com" autocomplete="email" />
        <x-campo nome="password" rotulo="Senha" tipo="password" placeholder="Crie uma senha" autocomplete="new-password" />
        <x-campo nome="password_confirmation" rotulo="Confirmar senha" tipo="password" placeholder="Repita a senha" autocomplete="new-password" />

        <button type="submit"
                class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-brand px-4 py-3 text-sm font-semibold text-brand-ink transition-colors hover:bg-brand/90">
            Criar conta
        </button>
    </form>

    <p class="mt-8 text-sm text-soft">
        Já tem uma conta?
        <a href="{{ route('login') }}" class="font-medium text-brand hover:underline">Entrar</a>
    </p>
</x-auth-layout>
