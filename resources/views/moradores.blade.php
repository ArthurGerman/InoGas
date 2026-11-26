<x-app-layout titulo="Moradores" ativo="moradores">
    @php
        $meuId = (int) session('usuario_id');
        $classeCampo = 'w-full rounded-lg border border-line bg-canvas px-3.5 py-2.5 text-sm text-ink placeholder:text-soft/70';
        $classeBotao = 'rounded-lg border border-line px-3 py-1.5 text-xs font-medium transition-colors hover:border-brand/40';

        $moradores = \App\Models\Usuario::where('responsavel_id', $meuId)
            ->where('papel', 'morador')
            ->with('locais:id,nome,parent_id')
            ->orderBy('name')
            ->get();

        $locais = \App\Models\Local::where('responsavel_id', $meuId)->orderBy('nome')->get();
        $porId = $locais->keyBy('id');

        $caminhoDe = function ($local) use ($porId) {
            $nomes = [$local->nome];
            for ($i = 0; $i < 10 && $local->parent_id && isset($porId[$local->parent_id]); $i++) {
                $local = $porId[$local->parent_id];
                array_unshift($nomes, $local->nome);
            }
            return implode(' › ', $nomes);
        };

        $opcoes = $locais->map(fn ($l) => ['id' => $l->id, 'caminho' => $caminhoDe($l)])->sortBy('caminho')->values();
    @endphp

    <div class="space-y-6" data-so="responsavel">

        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h1 class="text-3xl font-semibold">Moradores</h1>
                <p class="mt-1 max-w-xl text-soft">
                    Quem você adiciona aqui acompanha só os locais que você escolher, e tudo que há dentro deles.
                    Desativar não apaga o histórico.
                </p>
            </div>
            <button id="btn-novo" type="button"
                    class="inline-flex items-center gap-2 rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-brand-ink transition-colors hover:bg-brand/90">
                Adicionar morador
            </button>
        </div>

        <p id="msg-moradores" role="status" hidden class="rounded-lg border px-4 py-2.5 text-sm"></p>

        <!-- Novo morador -->
        <x-cartao id="form-morador" hidden rotulo="Novo morador" titulo="Dados do morador">
            @if ($opcoes->isEmpty())
                <p class="text-sm text-soft">
                    Para liberar um local ao morador, cadastre primeiro um local em
                    <a href="{{ \Illuminate\Support\Facades\Route::has('residencias') ? route('residencias') : '#' }}" class="font-medium text-brand hover:underline">Minhas casas e sensores</a>.
                </p>
            @endif
            <form id="form-novo" class="grid gap-4 md:grid-cols-2">
                <div>
                    <label for="morador-nome" class="mb-1.5 block text-sm font-medium">Nome</label>
                    <input id="morador-nome" type="text" required autocomplete="off" placeholder="Nome do morador" class="{{ $classeCampo }}">
                </div>
                <div>
                    <label for="morador-email" class="mb-1.5 block text-sm font-medium">E-mail</label>
                    <input id="morador-email" type="email" required autocomplete="off" placeholder="morador@exemplo.com" class="{{ $classeCampo }}">
                </div>
                <fieldset class="md:col-span-2">
                    <legend class="mb-1.5 text-sm font-medium">Locais que ele pode ver</legend>
                    <div class="grid gap-2 sm:grid-cols-2">
                        @foreach ($opcoes as $o)
                            <label class="flex items-center gap-2.5 rounded-lg border border-line bg-canvas/40 px-3 py-2 text-sm">
                                <input type="checkbox" name="novo-locais" value="{{ $o['id'] }}" class="size-4 accent-brand">
                                {{ $o['caminho'] }}
                            </label>
                        @endforeach
                    </div>
                    <p class="mt-1.5 text-xs text-soft">Ao liberar um local, tudo que fica dentro dele também é liberado.</p>
                </fieldset>
                <p class="text-xs text-soft md:col-span-2">
                    A conta nasce com uma senha temporária, mostrada uma única vez para você repassar.
                    No primeiro acesso, o morador troca por uma senha própria.
                </p>
                <div class="flex flex-wrap gap-3 md:col-span-2">
                    <button type="submit" class="rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-brand-ink transition-colors hover:bg-brand/90">
                        Criar morador
                    </button>
                    <button id="btn-cancelar" type="button"
                            class="rounded-lg border border-line px-4 py-2.5 text-sm font-medium text-soft transition-colors hover:text-ink">
                        Cancelar
                    </button>
                </div>
            </form>
        </x-cartao>

        <!-- Lista -->
        <x-cartao titulo="Moradores cadastrados">
            @if ($moradores->isEmpty())
                <p class="py-6 text-center text-sm text-soft">Nenhum morador cadastrado ainda.</p>
            @else
                <div class="-mx-5 overflow-x-auto">
                    <table class="w-full min-w-[44rem] text-left text-sm">
                        <thead>
                            <tr class="border-y border-line bg-panel-2/60 text-soft">
                                <th scope="col" class="px-5 py-3 font-medium">Morador</th>
                                <th scope="col" class="px-5 py-3 font-medium">Locais liberados</th>
                                <th scope="col" class="px-5 py-3 font-medium">Situação</th>
                                <th scope="col" class="px-5 py-3 font-medium">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-line">
                            @foreach ($moradores as $m)
                                <tr data-morador="{{ $m->id }}">
                                    <td class="px-5 py-3.5">
                                        <p class="font-medium" data-morador-nome>{{ $m->name }}</p>
                                        <p class="text-xs text-soft">{{ $m->email }}</p>
                                    </td>
                                    <td class="px-5 py-3.5 text-soft">
                                        @forelse ($m->locais as $l)
                                            <span class="block">{{ $caminhoDe($l) }}</span>
                                        @empty
                                            Nenhum local liberado
                                        @endforelse
                                    </td>
                                    <td class="px-5 py-3.5">
                                        @if (! $m->ativo)
                                            <x-selo estado="aguardando">Desativado</x-selo>
                                        @elseif ($m->precisa_trocar_senha)
                                            <x-selo estado="info">Senha temporária</x-selo>
                                        @else
                                            <x-selo estado="normal">Ativo</x-selo>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <div class="flex flex-wrap gap-2">
                                            <button type="button" data-acao="editar" data-id="{{ $m->id }}" class="{{ $classeBotao }}">Editar</button>
                                            <button type="button" data-acao="redefinir" data-id="{{ $m->id }}" class="{{ $classeBotao }}">Redefinir acesso</button>
                                            <button type="button" data-acao="alternar" data-id="{{ $m->id }}" data-ativo="{{ $m->ativo ? '1' : '0' }}" class="{{ $classeBotao }} text-soft hover:border-risk/40 hover:text-ink">
                                                {{ $m->ativo ? 'Desativar' : 'Reativar' }}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr data-morador-form="{{ $m->id }}" hidden>
                                    <td colspan="4" class="bg-canvas/40 px-5 py-4">
                                        <form data-form-edicao="{{ $m->id }}" class="grid gap-4 md:grid-cols-2">
                                            <div>
                                                <label class="mb-1.5 block text-xs font-medium">Nome</label>
                                                <input type="text" name="name" required value="{{ $m->name }}" class="{{ $classeCampo }}">
                                            </div>
                                            <div>
                                                <label class="mb-1.5 block text-xs font-medium">E-mail</label>
                                                <input type="email" name="email" required value="{{ $m->email }}" class="{{ $classeCampo }}">
                                            </div>
                                            <fieldset class="md:col-span-2">
                                                <legend class="mb-1.5 text-xs font-medium">Locais que ele pode ver</legend>
                                                <div class="grid gap-2 sm:grid-cols-2">
                                                    @foreach ($opcoes as $o)
                                                        <label class="flex items-center gap-2.5 rounded-lg border border-line bg-panel px-3 py-2 text-sm">
                                                            <input type="checkbox" name="locais" value="{{ $o['id'] }}" class="size-4 accent-brand" @checked($m->locais->contains('id', $o['id']))>
                                                            {{ $o['caminho'] }}
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </fieldset>
                                            <div class="flex gap-2 md:col-span-2">
                                                <button type="submit" class="rounded-lg bg-brand px-4 py-2 text-sm font-semibold text-brand-ink transition-colors hover:bg-brand/90">Salvar</button>
                                                <button type="button" data-acao="cancelar-edicao" data-id="{{ $m->id }}" class="rounded-lg border border-line px-4 py-2 text-sm font-medium text-soft transition-colors hover:text-ink">Cancelar</button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </x-cartao>
    </div>

    <x-area-restrita />

    <script>
    (() => {
        const $ = (id) => document.getElementById(id);

        function aviso(texto, erro) {
            const el = $('msg-moradores');
            el.hidden = false;
            el.textContent = texto;
            el.className = 'rounded-lg border px-4 py-2.5 text-sm ' + (erro ? 'border-risk/40 bg-risk/10 text-risk' : 'border-brand/40 bg-brand/10 text-brand');
        }

        function textoDoErro(r) {
            const c = r.corpo || {};
            if (c.errors) return Object.values(c.errors)[0][0];
            return c.erro || c.message || 'Não foi possível concluir. Tente de novo.';
        }

        async function chamar(url, dados) {
            try {
                return await window.inogasEnviar(url, dados || {});
            } catch (e) {
                return { ok: false, status: 0, corpo: { erro: 'Sem conexão com o servidor. Tente de novo.' } };
            }
        }

        function marcados(nome, raiz) {
            return Array.from((raiz || document).querySelectorAll('input[name="' + nome + '"]:checked')).map((i) => Number(i.value));
        }

        function mostrarSenha(titulo, texto, senha) {
            return window.inogasAviso({
                titulo,
                texto,
                destaque: senha,
                confirmar: 'Já anotei',
                naoFecharFora: true,
            });
        }

        $('btn-novo').addEventListener('click', () => {
            $('form-morador').hidden = false;
            $('morador-nome').focus();
        });

        $('btn-cancelar').addEventListener('click', () => {
            $('form-morador').hidden = true;
            $('form-novo').reset();
        });

        $('form-novo').addEventListener('submit', async (e) => {
            e.preventDefault();
            const r = await chamar('/moradores', {
                name: $('morador-nome').value,
                email: $('morador-email').value,
                locais: marcados('novo-locais'),
            });
            if (!r.ok) {
                aviso(textoDoErro(r), true);
                return;
            }
            await mostrarSenha('Conta criada', 'Repasse esta senha temporária ao morador. Ela aparece só agora. No primeiro acesso, ele troca por uma senha própria.', r.corpo.senha_temporaria);
            location.reload();
        });

        document.querySelectorAll('[data-acao]').forEach((botao) => {
            botao.addEventListener('click', async () => {
                const id = botao.dataset.id;
                const linha = document.querySelector('[data-morador="' + id + '"]');
                const nome = linha ? linha.querySelector('[data-morador-nome]').textContent.trim() : 'este morador';
                const acao = botao.dataset.acao;

                if (acao === 'editar') { document.querySelector('[data-morador-form="' + id + '"]').hidden = false; return; }
                if (acao === 'cancelar-edicao') { document.querySelector('[data-morador-form="' + id + '"]').hidden = true; return; }

                if (acao === 'redefinir') {
                    const sim = await window.inogasConfirmar({
                        titulo: 'Redefinir o acesso?',
                        texto: 'Vamos gerar uma nova senha temporária para ' + nome + '. A senha atual dele deixa de valer e ele precisará trocar a nova ao entrar.',
                        confirmar: 'Gerar nova senha',
                    });
                    if (!sim) return;
                    const r = await chamar('/moradores/' + id + '/acesso');
                    if (!r.ok) { aviso(textoDoErro(r), true); return; }
                    await mostrarSenha('Nova senha temporária', 'Repasse esta senha a ' + nome + '. Ela aparece só agora.', r.corpo.senha_temporaria);
                    location.reload();
                    return;
                }

                if (acao === 'alternar') {
                    const ativar = botao.dataset.ativo !== '1';
                    if (!ativar) {
                        const sim = await window.inogasConfirmar({
                            titulo: 'Desativar ' + nome + '?',
                            texto: 'Essa pessoa deixa de conseguir entrar no InoGas. O histórico e as confirmações dela continuam guardados, e você pode reativar a conta quando quiser.',
                            confirmar: 'Desativar',
                            perigo: true,
                        });
                        if (!sim) return;
                    }
                    const r = await chamar('/moradores/' + id + '/ativo', { ativo: ativar });
                    if (r.ok) location.reload();
                    else aviso(textoDoErro(r), true);
                }
            });
        });

        document.querySelectorAll('[data-form-edicao]').forEach((form) => {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const dados = new FormData(form);
                const r = await chamar('/moradores/' + form.dataset.formEdicao, {
                    name: dados.get('name'),
                    email: dados.get('email'),
                    locais: marcados('locais', form),
                });
                if (r.ok) location.reload();
                else aviso(textoDoErro(r), true);
            });
        });
    })();
    </script>
</x-app-layout>
