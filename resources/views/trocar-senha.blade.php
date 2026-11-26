<x-auth-layout titulo="Trocar a senha">
    <p class="text-sm font-medium text-brand">Primeiro acesso</p>
    <h2 class="mt-2 text-3xl font-semibold">Troque a sua senha</h2>
    <p class="mt-2 text-sm text-soft">
        Você entrou com uma senha temporária. Escolha uma senha só sua para continuar.
    </p>

    <form id="form-troca" class="mt-8 space-y-5">
        <div>
            <label for="senha-atual" class="mb-1.5 block text-sm font-medium text-ink">Senha temporária</label>
            <input id="senha-atual" type="password" autocomplete="current-password" required
                   class="w-full rounded-lg border border-line bg-canvas px-3.5 py-2.5 text-sm text-ink">
        </div>
        <div>
            <label for="senha-nova" class="mb-1.5 block text-sm font-medium text-ink">Nova senha</label>
            <input id="senha-nova" type="password" autocomplete="new-password" required minlength="8"
                   class="w-full rounded-lg border border-line bg-canvas px-3.5 py-2.5 text-sm text-ink">
            <p class="mt-1.5 text-xs text-soft">No mínimo 8 caracteres, e diferente da senha temporária.</p>
        </div>
        <div>
            <label for="senha-confirmacao" class="mb-1.5 block text-sm font-medium text-ink">Confirmar nova senha</label>
            <input id="senha-confirmacao" type="password" autocomplete="new-password" required
                   class="w-full rounded-lg border border-line bg-canvas px-3.5 py-2.5 text-sm text-ink">
        </div>

        <p id="msg-troca" role="alert" hidden class="rounded-lg border border-risk/50 bg-risk/10 px-3.5 py-2.5 text-sm text-risk"></p>

        <button id="btn-troca" type="submit"
                class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-brand px-4 py-3 text-sm font-semibold text-brand-ink transition-colors hover:bg-brand/90">
            Salvar e continuar
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="mt-6">
        @csrf
        <button type="submit" class="text-sm text-soft hover:text-ink">Sair</button>
    </form>

    <script>
    (() => {
        const $ = (id) => document.getElementById(id);

        $('form-troca').addEventListener('submit', async (e) => {
            e.preventDefault();
            const msg = $('msg-troca');
            msg.hidden = true;
            $('btn-troca').disabled = true;

            try {
                const r = await window.inogasEnviar('/conta/senha', {
                    senha_atual: $('senha-atual').value,
                    senha_nova: $('senha-nova').value,
                    senha_nova_confirmation: $('senha-confirmacao').value,
                });

                if (r.ok) {
                    window.location.href = '/painel';
                    return;
                }

                const c = r.corpo || {};
                msg.textContent = c.errors ? Object.values(c.errors)[0][0] : (c.erro || c.message || 'Não foi possível trocar a senha. Tente de novo.');
                msg.hidden = false;
            } catch (erro) {
                msg.textContent = 'Sem conexão com o servidor. Tente de novo.';
                msg.hidden = false;
            } finally {
                $('btn-troca').disabled = false;
            }
        });
    })();
    </script>
</x-auth-layout>
