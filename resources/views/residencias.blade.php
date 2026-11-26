<x-app-layout titulo="Minhas casas e sensores" ativo="residencias">
    @php
        $usuarioId = (int) session('usuario_id');
        $classeCampo = 'w-full rounded-lg border border-line bg-canvas px-3.5 py-2.5 text-sm text-ink placeholder:text-soft/70';
        $classeBotao = 'rounded-lg border border-line px-3 py-1.5 text-xs font-medium transition-colors hover:border-brand/40';

        $todos = \App\Models\Local::where('responsavel_id', $usuarioId)
            ->withCount(['filhos', 'dispositivos'])
            ->orderBy('nome')
            ->get();
        $porId = $todos->keyBy('id');
        $porPai = $todos->groupBy(fn ($l) => $l->parent_id ?? 0);

        // Caminho de cada local ("Prédio Sol › Andar 2 › Apto 201"), sem consultar o banco de novo
        $caminhoDe = function ($local) use ($porId) {
            $nomes = [$local->nome];
            for ($i = 0; $i < 10 && $local->parent_id && isset($porId[$local->parent_id]); $i++) {
                $local = $porId[$local->parent_id];
                array_unshift($nomes, $local->nome);
            }
            return implode(' › ', $nomes);
        };

        // Árvore em lista, com o nível de cada local
        $arvore = [];
        $subir = function ($paiId, $nivel) use (&$subir, $porPai, &$arvore) {
            foreach ($porPai->get($paiId, collect()) as $l) {
                $arvore[] = ['local' => $l, 'nivel' => $nivel];
                $subir($l->id, $nivel + 1);
            }
        };
        $subir(0, 0);

        $sensores = \App\Models\Dispositivo::whereIn('local_id', $todos->pluck('id'))->orderBy('nome')->get();

        $infoLocais = collect($arvore)->map(fn ($i) => [
            'id' => $i['local']->id,
            'tipo' => $i['local']->tipo,
            'caminho' => $caminhoDe($i['local']),
        ])->values();
    @endphp

    <div class="space-y-6" data-so="responsavel">

        <div>
            <h1 class="text-3xl font-semibold">Minhas casas e sensores</h1>
            <p class="mt-1 text-soft">Cadastre onde o sensor está, para cada leitura e cada alerta ficarem no lugar certo.</p>
        </div>

        <p id="msg-pagina" role="status" hidden class="rounded-lg border border-brand/40 bg-brand/10 px-4 py-2.5 text-sm text-brand"></p>

        <!-- Locais -->
        <x-cartao rotulo="Locais" titulo="Onde você monitora">
            @if (count($arvore) === 0)
                <p class="text-sm text-soft">
                    Você ainda não cadastrou nenhum local. Comece criando a sua residência ou o seu prédio.
                </p>
            @else
                <ul class="divide-y divide-line rounded-lg border border-line">
                    @foreach ($arvore as $item)
                        @php
                            $l = $item['local'];
                        @endphp
                        <li class="flex flex-wrap items-center justify-between gap-3 px-4 py-3" data-local-linha="{{ $l->id }}" style="padding-left: {{ 1 + $item['nivel'] * 1.5 }}rem">
                            <div class="min-w-0">
                                <p class="text-xs text-soft">{{ $l->rotuloTipo() }}</p>
                                <p class="font-medium" data-local-nome>{{ $l->nome }}</p>
                                <p class="text-xs text-soft">
                                    {{ $l->dispositivos_count }} {{ $l->dispositivos_count === 1 ? 'sensor' : 'sensores' }}
                                    · {{ $l->filhos_count }} {{ $l->filhos_count === 1 ? 'local dentro' : 'locais dentro' }}
                                </p>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <button type="button" data-local-acao="renomear" data-id="{{ $l->id }}" class="{{ $classeBotao }}">Renomear</button>
                                <button type="button" data-local-acao="apagar" data-id="{{ $l->id }}" class="{{ $classeBotao }} text-soft hover:border-risk/40 hover:text-ink">Apagar</button>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif

            <form id="form-local" class="mt-6 grid gap-4 border-t border-line pt-6 md:grid-cols-3">
                <div>
                    <label for="local-nome" class="mb-1.5 block text-sm font-medium">Nome do local</label>
                    <input id="local-nome" type="text" required autocomplete="off" placeholder="Ex.: Casa Aurora" class="{{ $classeCampo }}">
                </div>
                <div>
                    <label for="local-tipo" class="mb-1.5 block text-sm font-medium">Tipo</label>
                    <select id="local-tipo" class="{{ $classeCampo }}">
                        @foreach (\App\Models\Local::TIPOS as $valor => $rotulo)
                            <option value="{{ $valor }}">{{ $rotulo }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="local-pai" class="mb-1.5 block text-sm font-medium">Dentro de</label>
                    <select id="local-pai" class="{{ $classeCampo }}"></select>
                </div>
                <div class="md:col-span-3">
                    <button type="submit" class="rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-brand-ink transition-colors hover:bg-brand/90">
                        Adicionar local
                    </button>
                    <p id="msg-local" role="status" hidden class="mt-3 text-sm"></p>
                </div>
            </form>
        </x-cartao>

        <!-- Sensores -->
        <x-cartao rotulo="Sensores" titulo="Seus sensores">
            @if ($sensores->isEmpty())
                <p class="text-sm text-soft">
                    Nenhum sensor cadastrado.
                    @if (count($arvore) === 0)
                        Crie um local primeiro, e depois cadastre o sensor nele.
                    @else
                        Cadastre o sensor em um dos seus locais, no formulário abaixo.
                    @endif
                </p>
            @else
                <div class="space-y-4">
                    @foreach ($sensores as $d)
                        <div class="rounded-lg border border-line bg-canvas/40 p-4" data-sensor="{{ $d->id }}">
                            <div class="flex flex-wrap items-start justify-between gap-3">
                                <div>
                                    <p class="font-semibold">{{ $d->nome }}</p>
                                    <p class="text-sm text-soft">{{ isset($porId[$d->local_id]) ? $caminhoDe($porId[$d->local_id]) : '—' }}</p>
                                </div>
                                <div data-sensor-estado="{{ $d->id }}">
                                    <span data-estado="recebendo" @if ($d->comunicacao() !== 'recebendo') hidden @endif>
                                        <x-selo estado="normal">Recebendo dados</x-selo>
                                    </span>
                                    <span data-estado="sem" @if ($d->comunicacao() === 'recebendo') hidden @endif>
                                        <x-selo estado="aguardando">Sem comunicação recente · estado desconhecido</x-selo>
                                    </span>
                                </div>
                            </div>

                            <dl class="mt-3 grid gap-2 text-sm sm:grid-cols-3">
                                <div>
                                    <dt class="text-xs text-soft">Último envio</dt>
                                    <dd data-sensor-hora="{{ $d->id }}">{{ $d->ultimo_envio_em ? $d->ultimo_envio_em->format('d/m/Y H:i:s') : 'Nunca' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs text-soft">Última calibração</dt>
                                    <dd>{{ $d->ultima_calibracao_em ? $d->ultima_calibracao_em->format('d/m/Y') : 'Não informada' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs text-soft">Situação</dt>
                                    <dd>{{ $d->ativo ? 'Ativo' : 'Desativado' }}</dd>
                                </div>
                            </dl>

                            <div class="mt-4 flex flex-wrap gap-2">
                                <button type="button" data-sensor-acao="editar" data-id="{{ $d->id }}" class="{{ $classeBotao }}">Editar</button>
                                <button type="button" data-sensor-acao="token" data-id="{{ $d->id }}" class="{{ $classeBotao }}">Gerar novo token</button>
                                <button type="button" data-sensor-acao="alternar" data-id="{{ $d->id }}" data-ativo="{{ $d->ativo ? '1' : '0' }}" class="{{ $classeBotao }} text-soft hover:border-risk/40 hover:text-ink">
                                    {{ $d->ativo ? 'Desativar' : 'Ativar' }}
                                </button>
                            </div>

                            <form data-sensor-form="{{ $d->id }}" hidden class="mt-4 grid gap-3 border-t border-line pt-4 md:grid-cols-3">
                                <div>
                                    <label class="mb-1.5 block text-xs font-medium">Nome</label>
                                    <input type="text" name="nome" required value="{{ $d->nome }}" class="{{ $classeCampo }}">
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-xs font-medium">Local</label>
                                    <select name="local_id" class="{{ $classeCampo }}">
                                        @foreach ($infoLocais as $info)
                                            <option value="{{ $info['id'] }}" @selected($info['id'] === $d->local_id)>{{ $info['caminho'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-xs font-medium">Última calibração</label>
                                    <input type="date" name="ultima_calibracao_em" max="{{ now()->format('Y-m-d') }}" value="{{ optional($d->ultima_calibracao_em)->format('Y-m-d') }}" class="{{ $classeCampo }}">
                                </div>
                                <div class="flex gap-2 md:col-span-3">
                                    <button type="submit" class="rounded-lg bg-brand px-4 py-2 text-sm font-semibold text-brand-ink transition-colors hover:bg-brand/90">Salvar</button>
                                    <button type="button" data-sensor-acao="cancelar" data-id="{{ $d->id }}" class="rounded-lg border border-line px-4 py-2 text-sm font-medium text-soft transition-colors hover:text-ink">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif

            <p class="mt-4 text-xs text-soft">
                Enquanto o sensor não enviar o token, o InoGas liga as leituras ao único sensor ativo cadastrado.
                Com mais de um sensor ativo, cada um precisa enviar o seu token.
            </p>

            @if (count($arvore) > 0)
                <form id="form-sensor" class="mt-6 grid gap-4 border-t border-line pt-6 md:grid-cols-3">
                    <div>
                        <label for="sensor-nome" class="mb-1.5 block text-sm font-medium">Nome do sensor</label>
                        <input id="sensor-nome" type="text" required autocomplete="off" placeholder="Ex.: Sensor da cozinha" class="{{ $classeCampo }}">
                    </div>
                    <div>
                        <label for="sensor-local" class="mb-1.5 block text-sm font-medium">Local</label>
                        <select id="sensor-local" class="{{ $classeCampo }}">
                            @foreach ($infoLocais as $info)
                                <option value="{{ $info['id'] }}">{{ $info['caminho'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="sensor-calibracao" class="mb-1.5 block text-sm font-medium">Última calibração (opcional)</label>
                        <input id="sensor-calibracao" type="date" max="{{ now()->format('Y-m-d') }}" class="{{ $classeCampo }}">
                    </div>
                    <div class="md:col-span-3">
                        <button type="submit" class="rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-brand-ink transition-colors hover:bg-brand/90">
                            Cadastrar sensor
                        </button>
                        <p id="msg-sensor" role="status" hidden class="mt-3 text-sm"></p>
                    </div>
                </form>
            @endif
        </x-cartao>

        <!-- Modo de teste -->
        <x-cartao rotulo="Modo de teste" titulo="Testar o registro de alertas">
            <p class="-mt-2 text-sm text-soft">
                Grava um alerta de teste no Histórico, marcado como Teste. Nenhum aviso real é enviado a ninguém.
            </p>
            <button id="btn-teste" type="button"
                    class="mt-4 rounded-lg border border-line px-4 py-2.5 text-sm font-medium transition-colors hover:border-brand/40">
                Registrar alerta de teste
            </button>
            <div id="aviso-teste" hidden role="alert" class="mt-4 flex items-start justify-between gap-4 rounded-lg border border-attn/50 bg-attn/10 px-4 py-3 text-sm">
                <p id="aviso-teste-texto" class="text-attn"></p>
                <button id="btn-parar-teste" type="button" class="shrink-0 text-xs font-medium underline">Fechar</button>
            </div>
        </x-cartao>

        <!-- Planta de exemplo -->
        <x-cartao rotulo="Planta · exemplo" titulo="Onde está o sensor">
            <x-pendente recurso="planta" class="mb-4">
                A planta é só um desenho de exemplo. A planta de verdade, desenhada por você, ainda não existe.
            </x-pendente>
            <svg viewBox="0 0 672 220" class="w-full rounded-lg bg-canvas" role="img" aria-label="Planta de exemplo de uma casa, com um cômodo destacado">
                @php
                    $comodos = [
                        ['Cozinha', 16, 16, 220, 120],
                        ['Sala', 244, 16, 260, 120],
                        ['Quarto', 512, 16, 144, 120],
                        ['Área de serviço', 16, 144, 220, 60],
                        ['Banheiro', 244, 144, 120, 60],
                        ['Quarto 2', 372, 144, 284, 60],
                    ];
                @endphp
                @foreach ($comodos as [$nome, $x, $y, $w, $h])
                    <g class="{{ $nome === 'Cozinha' ? 'text-brand' : 'text-soft' }}">
                        <rect x="{{ $x }}" y="{{ $y }}" width="{{ $w }}" height="{{ $h }}" rx="6" fill="currentColor" fill-opacity="{{ $nome === 'Cozinha' ? '0.12' : '0.05' }}" stroke="currentColor" stroke-opacity="{{ $nome === 'Cozinha' ? '0.7' : '0.35' }}" />
                        <text x="{{ $x + 10 }}" y="{{ $y + 20 }}" font-size="12" fill="currentColor">{{ $nome }}</text>
                    </g>
                @endforeach
                <g class="text-brand">
                    <circle cx="60" cy="76" r="6" fill="currentColor" />
                    <text x="48" y="98" font-size="11" fill="currentColor">Sensor</text>
                </g>
            </svg>
        </x-cartao>
    </div>

    <x-area-restrita />

    <script>
    (() => {
        const $ = (id) => document.getElementById(id);
        const LOCAIS = @json($infoLocais);
        const PAIS = @json(\App\Models\Local::PAIS_PERMITIDOS);
        const TIPOS = @json(\App\Models\Local::TIPOS);

        function mostrar(id, texto, erro) {
            const el = $(id);
            if (!el) return;
            el.hidden = false;
            el.textContent = texto;
            el.className = (id === 'msg-pagina' ? 'rounded-lg border px-4 py-2.5 text-sm ' + (erro ? 'border-risk/40 bg-risk/10 text-risk' : 'border-brand/40 bg-brand/10 text-brand') : 'mt-3 text-sm ' + (erro ? 'text-risk' : 'text-brand'));
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

        // ---------- Locais ----------
        function atualizarOpcoesDePai() {
            const tipo = $('local-tipo').value;
            const permitidos = PAIS[tipo] || [null];
            const seletor = $('local-pai');
            seletor.replaceChildren();

            if (permitidos.includes(null)) {
                const o = document.createElement('option');
                o.value = '';
                o.textContent = 'Nenhum (fica no topo)';
                seletor.append(o);
                seletor.disabled = true;
                return;
            }

            seletor.disabled = false;
            const candidatos = LOCAIS.filter((l) => permitidos.includes(l.tipo));
            if (candidatos.length === 0) {
                const o = document.createElement('option');
                o.value = '';
                o.textContent = 'Crie antes: ' + permitidos.map((t) => TIPOS[t].toLowerCase()).join(' ou ');
                seletor.append(o);
                return;
            }
            candidatos.forEach((l) => {
                const o = document.createElement('option');
                o.value = String(l.id);
                o.textContent = l.caminho;
                seletor.append(o);
            });
        }

        $('local-tipo').addEventListener('change', atualizarOpcoesDePai);
        atualizarOpcoesDePai();

        $('form-local').addEventListener('submit', async (e) => {
            e.preventDefault();
            const r = await chamar('/locais', {
                nome: $('local-nome').value,
                tipo: $('local-tipo').value,
                parent_id: $('local-pai').value || null,
            });
            if (r.ok) {
                location.reload();
            } else {
                mostrar('msg-local', textoDoErro(r), true);
            }
        });

        document.querySelectorAll('[data-local-acao]').forEach((botao) => {
            botao.addEventListener('click', async () => {
                const id = botao.dataset.id;
                if (botao.dataset.localAcao === 'renomear') {
                    const linha = document.querySelector('[data-local-linha="' + id + '"] [data-local-nome]');
                    const novo = await window.inogasPerguntar({
                        titulo: 'Renomear local',
                        rotulo: 'Novo nome',
                        valor: linha.textContent.trim(),
                        confirmar: 'Salvar',
                    });
                    if (novo === null || novo.trim() === '') return;
                    const r = await chamar('/locais/' + id, { nome: novo.trim() });
                    if (r.ok) location.reload();
                    else mostrar('msg-pagina', textoDoErro(r), true);
                } else {
                    const linha = document.querySelector('[data-local-linha="' + id + '"] [data-local-nome]');
                    const sim = await window.inogasConfirmar({
                        titulo: 'Apagar este local?',
                        texto: 'O local "' + linha.textContent.trim() + '" será apagado. Isso não pode ser desfeito.',
                        confirmar: 'Apagar',
                        perigo: true,
                    });
                    if (!sim) return;
                    const r = await chamar('/locais/' + id + '/apagar');
                    if (r.ok) location.reload();
                    else mostrar('msg-pagina', textoDoErro(r), true);
                }
            });
        });

        // ---------- Sensores ----------
        function mostrarToken(token) {
            return window.inogasAviso({
                titulo: 'Guarde este token agora',
                texto: 'Ele aparece só desta vez. O firmware do sensor poderá enviá-lo para se identificar.',
                destaque: token,
                confirmar: 'Já guardei',
                naoFecharFora: true,
            });
        }

        if ($('form-sensor')) {
            $('form-sensor').addEventListener('submit', async (e) => {
                e.preventDefault();
                const r = await chamar('/dispositivos', {
                    nome: $('sensor-nome').value,
                    local_id: $('sensor-local').value,
                    ultima_calibracao_em: $('sensor-calibracao').value || null,
                });
                if (r.ok) {
                    await mostrarToken(r.corpo.token);
                    location.reload();
                } else {
                    mostrar('msg-sensor', textoDoErro(r), true);
                }
            });
        }

        document.querySelectorAll('[data-sensor-acao]').forEach((botao) => {
            botao.addEventListener('click', async () => {
                const id = botao.dataset.id;
                const acao = botao.dataset.sensorAcao;
                const form = document.querySelector('[data-sensor-form="' + id + '"]');

                if (acao === 'editar') { form.hidden = false; return; }
                if (acao === 'cancelar') { form.hidden = true; return; }

                if (acao === 'token') {
                    const sim = await window.inogasConfirmar({
                        titulo: 'Gerar um novo token?',
                        texto: 'O token antigo deixa de valer. Se o sensor já usa o token antigo, ele precisará do novo.',
                        confirmar: 'Gerar novo token',
                    });
                    if (!sim) return;
                    const r = await chamar('/dispositivos/' + id + '/token');
                    if (r.ok) {
                        await mostrarToken(r.corpo.token);
                        location.reload();
                    } else {
                        mostrar('msg-pagina', textoDoErro(r), true);
                    }
                    return;
                }

                if (acao === 'alternar') {
                    const ativar = botao.dataset.ativo !== '1';
                    const r = await chamar('/dispositivos/' + id + '/ativo', { ativo: ativar });
                    if (r.ok) location.reload();
                    else mostrar('msg-pagina', textoDoErro(r), true);
                }
            });
        });

        document.querySelectorAll('[data-sensor-form]').forEach((form) => {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const dados = new FormData(form);
                const r = await chamar('/dispositivos/' + form.dataset.sensorForm, {
                    nome: dados.get('nome'),
                    local_id: dados.get('local_id'),
                    ultima_calibracao_em: dados.get('ultima_calibracao_em') || null,
                });
                if (r.ok) location.reload();
                else mostrar('msg-pagina', textoDoErro(r), true);
            });
        });

        // Estado de comunicação ao vivo (a cada 10 segundos)
        async function atualizarEstado() {
            try {
                const r = await fetch('/dispositivos/estado', { headers: { Accept: 'application/json' } });
                if (!r.ok) return;
                const lista = await r.json();
                lista.forEach((s) => {
                    const caixa = document.querySelector('[data-sensor-estado="' + s.id + '"]');
                    if (caixa) {
                        caixa.querySelector('[data-estado="recebendo"]').hidden = s.comunicacao !== 'recebendo';
                        caixa.querySelector('[data-estado="sem"]').hidden = s.comunicacao === 'recebendo';
                    }
                });
            } catch (e) {
                /* tenta de novo no próximo ciclo */
            }
        }
        setInterval(atualizarEstado, 10000);

        // ---------- Modo de teste ----------
        $('btn-teste').addEventListener('click', async () => {
            const botao = $('btn-teste');
            botao.disabled = true;
            const r = await chamar('/alertas/teste');
            $('aviso-teste').hidden = false;
            $('aviso-teste-texto').textContent = r.ok
                ? ((r.corpo && r.corpo.mensagem) || 'Teste registrado no Histórico.')
                : textoDoErro(r);
            botao.disabled = false;
        });
        $('btn-parar-teste').addEventListener('click', () => { $('aviso-teste').hidden = true; });
    })();
    </script>
</x-app-layout>
