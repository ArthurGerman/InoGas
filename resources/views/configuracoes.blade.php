<x-app-layout titulo="Configurações" ativo="configuracoes">
    @php
        $classeCampo = 'w-full rounded-lg border border-line bg-canvas px-3.5 py-2.5 text-sm text-ink placeholder:text-soft/70';
        $ehResponsavel = session('usuario_papel', 'responsavel') === 'responsavel';
        $usuario = \App\Models\Usuario::find(session('usuario_id'));
        $temPin = ! empty(optional($usuario)->pin_hash);

        // Locais do responsável e os ajustes de aviso de cada um (para a seção "Avisos")
        $locaisAviso = $ehResponsavel
            ? \App\Models\Local::where('responsavel_id', (int) session('usuario_id'))->orderBy('nome')->get()
            : collect();
        $porIdAviso = $locaisAviso->keyBy('id');
        $caminhoAviso = function ($local) use ($porIdAviso) {
            $nomes = [$local->nome];
            for ($i = 0; $i < 10 && $local->parent_id && isset($porIdAviso[$local->parent_id]); $i++) {
                $local = $porIdAviso[$local->parent_id];
                array_unshift($nomes, $local->nome);
            }
            return implode(' › ', $nomes);
        };
        $ajustesAviso = [];
        foreach ($locaisAviso as $l) {
            $ajustesAviso[$l->id] = \App\Models\ConfiguracaoAviso::do($l->id);
        }
    @endphp

    <div class="space-y-6">

        <div>
            <h1 class="text-3xl font-semibold">Configurações</h1>
            <p class="mt-1 text-soft">Sua conta e os ajustes do InoGas.</p>
        </div>

        <!-- Minha conta (Morador e Responsável) -->
        <x-cartao rotulo="Minha conta" titulo="Seus dados">
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label for="conta-nome" class="mb-1.5 block text-sm font-medium">Nome</label>
                    <input id="conta-nome" type="text" autocomplete="name" value="{{ session('usuario_name') }}" class="{{ $classeCampo }}">
                </div>
                <div>
                    <label for="conta-email" class="mb-1.5 block text-sm font-medium">E-mail</label>
                    <input id="conta-email" type="email" autocomplete="email" value="{{ optional($usuario)->email }}" placeholder="seuemail@exemplo.com" class="{{ $classeCampo }}">
                </div>
            </div>
            <div class="mt-5 flex flex-wrap items-center gap-4">
                <button id="btn-salvar-conta" type="button"
                        class="rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-brand-ink transition-colors hover:bg-brand/90">
                    Salvar alterações
                </button>
                <p id="msg-conta" role="status" hidden class="text-sm text-brand"></p>
            </div>
        </x-cartao>

        <x-cartao rotulo="Segurança" titulo="Trocar senha">
            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <label for="senha-atual" class="mb-1.5 block text-sm font-medium">Senha atual</label>
                    <input id="senha-atual" type="password" autocomplete="current-password" class="{{ $classeCampo }}">
                </div>
                <div>
                    <label for="senha-nova" class="mb-1.5 block text-sm font-medium">Nova senha</label>
                    <input id="senha-nova" type="password" autocomplete="new-password" class="{{ $classeCampo }}">
                </div>
                <div>
                    <label for="senha-confirmacao" class="mb-1.5 block text-sm font-medium">Confirmar nova senha</label>
                    <input id="senha-confirmacao" type="password" autocomplete="new-password" class="{{ $classeCampo }}">
                </div>
            </div>
            <div class="mt-5 flex flex-wrap items-center gap-4">
                <button id="btn-trocar-senha" type="button"
                        class="rounded-lg border border-line px-4 py-2.5 text-sm font-medium transition-colors hover:border-brand/40">
                    Trocar senha
                </button>
                <p id="msg-senha" role="status" hidden class="text-sm text-brand"></p>
            </div>
        </x-cartao>

        <!-- Só do Responsável (o servidor nem envia isto ao morador) -->
        @if ($ehResponsavel)
        <div data-so="responsavel" class="space-y-6">

            <x-cartao rotulo="Avisos" titulo="Como o InoGas avisa">
                <div class="space-y-6">
                    @if ($locaisAviso->isEmpty())
                        <p class="text-sm text-soft">
                            Cadastre um local em
                            <a href="{{ \Illuminate\Support\Facades\Route::has('residencias') ? route('residencias') : '#' }}" class="font-medium text-brand hover:underline">Minhas casas e sensores</a>
                            para ajustar os avisos dele.
                        </p>
                    @else
                        <x-pendente recurso="avisos">
                            A voz já funciona no Painel. O Telegram e os minutos para escalar ainda só guardam a escolha: o envio de verdade ainda não existe.
                        </x-pendente>

                        <div>
                            <label for="aviso-local" class="mb-1.5 block text-sm font-medium">Local</label>
                            <select id="aviso-local" class="{{ $classeCampo }}">
                                @foreach ($locaisAviso as $l)
                                    <option value="{{ $l->id }}">{{ $caminhoAviso($l) }}</option>
                                @endforeach
                            </select>
                            <p class="mt-1.5 text-xs text-soft">Cada local tem os seus próprios ajustes.</p>
                        </div>

                        <div>
                            <div class="flex flex-wrap items-center justify-between gap-4">
                                <x-alternador id="aviso-voz" rotulo="Alerta por voz no Painel" :marcado="true" />
                                <div class="flex items-center gap-3">
                                    <label for="volume-voz" class="text-sm text-soft">Volume</label>
                                    <input id="volume-voz" type="range" min="0" max="100" value="60" class="w-40 accent-brand">
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-soft">
                                Com a voz ligada, o Painel fala o nível quando houver alerta. A pessoa precisa tocar em
                                "Ativar avisos sonoros" uma vez ao abrir o Painel, porque os navegadores bloqueiam som automático.
                            </p>
                        </div>

                        <div class="border-t border-line pt-6">
                            <x-alternador id="aviso-telegram" rotulo="Mensagem no Telegram" :marcado="false" />
                            <div class="mt-4 max-w-xs">
                                <label for="aviso-minutos" class="mb-1.5 block text-sm font-medium">Minutos sem ninguém confirmar até avisar o responsável</label>
                                <input id="aviso-minutos" type="number" min="1" max="120" value="5" class="{{ $classeCampo }}">
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-4">
                            <button id="btn-salvar-avisos" type="button"
                                    class="rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-brand-ink transition-colors hover:bg-brand/90">
                                Salvar ajustes de aviso
                            </button>
                            <p id="msg-avisos" role="status" hidden class="text-sm"></p>
                        </div>
                    @endif

                    <div class="border-t border-line pt-6">
                        <label for="pin-config" class="mb-1.5 block text-sm font-medium">PIN para silenciar o alarme</label>
                        <div class="flex max-w-sm gap-3">
                            <input id="pin-config" type="password" inputmode="numeric" autocomplete="off" placeholder="Escolha um PIN" class="{{ $classeCampo }}">
                            <button id="btn-definir-pin" type="button"
                                    class="shrink-0 rounded-lg border border-line px-4 py-2.5 text-sm font-medium transition-colors hover:border-brand/40">
                                Definir PIN
                            </button>
                        </div>
                        <p id="msg-pin" role="status" hidden class="mt-2 text-sm text-brand"></p>
                        <p id="pin-estado" class="mt-2 text-xs {{ $temPin ? 'text-brand' : 'text-soft' }}">{{ $temPin ? 'PIN definido. Digite um novo para trocar.' : 'Você ainda não definiu um PIN.' }}</p>
                        <p class="mt-2 text-xs text-soft">É o PIN pedido na tela Alertas ao silenciar o alarme.</p>
                    </div>
                </div>
            </x-cartao>

            <x-cartao rotulo="Moradores" titulo="Quem acompanha a sua casa">
                <p class="-mt-2 text-sm text-soft">
                    Crie contas para os moradores, escolha o local de cada um e desative quem não mora mais lá.
                </p>
                <a href="{{ \Illuminate\Support\Facades\Route::has('moradores') ? route('moradores') : '#' }}"
                   class="mt-4 inline-flex items-center gap-2 rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-brand-ink transition-colors hover:bg-brand/90">
                    Gerenciar moradores <x-icone nome="seta" class="size-4" />
                </a>
            </x-cartao>
        </div>
        @endif
    </div>

    <script>
    (() => {
        const $ = (id) => document.getElementById(id);

        function mostrar(idMsg, texto, erro) {
            const el = $(idMsg);
            if (!el) return;
            el.hidden = false;
            el.textContent = texto;
            el.className = (idMsg === 'msg-pin' ? 'mt-2 ' : '') + 'text-sm ' + (erro ? 'text-risk' : 'text-brand');
        }

        function textoDoErro(r) {
            const c = r.corpo || {};
            if (r.status === 429) return 'Muitas tentativas. Espere um minuto e tente de novo.';
            if (c.errors) return Object.values(c.errors)[0][0];
            return c.erro || c.message || 'Não foi possível salvar. Tente de novo.';
        }

        async function enviar(botao, idMsg, url, dados, aoDarCerto) {
            botao.disabled = true;
            try {
                const r = await window.inogasEnviar(url, dados);
                if (r.ok) {
                    mostrar(idMsg, (r.corpo && r.corpo.mensagem) || 'Salvo.', false);
                    if (aoDarCerto) aoDarCerto(r.corpo);
                } else {
                    mostrar(idMsg, textoDoErro(r), true);
                }
            } catch (e) {
                mostrar(idMsg, 'Sem conexão com o servidor. Tente de novo.', true);
            } finally {
                botao.disabled = false;
            }
        }

        $('btn-salvar-conta').addEventListener('click', () => {
            enviar($('btn-salvar-conta'), 'msg-conta', '/conta', { name: $('conta-nome').value, email: $('conta-email').value }, (corpo) => {
                if (corpo && corpo.name) {
                    document.querySelectorAll('[data-nome-conta]').forEach((el) => { el.textContent = corpo.name; });
                    document.querySelectorAll('[data-inicial-conta]').forEach((el) => { el.textContent = corpo.name.charAt(0).toUpperCase(); });
                }
            });
        });

        $('btn-trocar-senha').addEventListener('click', () => {
            enviar($('btn-trocar-senha'), 'msg-senha', '/conta/senha', {
                senha_atual: $('senha-atual').value,
                senha_nova: $('senha-nova').value,
                senha_nova_confirmation: $('senha-confirmacao').value,
            }, () => {
                ['senha-atual', 'senha-nova', 'senha-confirmacao'].forEach((id) => { $(id).value = ''; });
            });
        });

        const seletorAviso = $('aviso-local');
        if (seletorAviso) {
            const AJUSTES = @json($ajustesAviso);

            function preencherAvisos() {
                const a = AJUSTES[seletorAviso.value];
                if (!a) return;
                $('aviso-voz').checked = !!a.voz_ativa;
                $('volume-voz').value = a.volume;
                $('aviso-telegram').checked = !!a.telegram_ativo;
                $('aviso-minutos').value = a.minutos_para_escalar;
                const msg = $('msg-avisos');
                if (msg) msg.hidden = true;
            }

            seletorAviso.addEventListener('change', preencherAvisos);
            preencherAvisos();

            $('btn-salvar-avisos').addEventListener('click', () => {
                const dados = {
                    voz_ativa: $('aviso-voz').checked,
                    volume: Number($('volume-voz').value),
                    telegram_ativo: $('aviso-telegram').checked,
                    minutos_para_escalar: Number($('aviso-minutos').value),
                };
                enviar($('btn-salvar-avisos'), 'msg-avisos', '/avisos/' + seletorAviso.value, dados, () => {
                    AJUSTES[seletorAviso.value] = dados;
                });
            });
        }

        const botaoPin = $('btn-definir-pin');
        if (botaoPin) {
            botaoPin.addEventListener('click', () => {
                enviar(botaoPin, 'msg-pin', '/conta/pin', { pin: $('pin-config').value }, () => {
                    $('pin-config').value = '';
                    const estado = $('pin-estado');
                    estado.textContent = 'PIN definido. Digite um novo para trocar.';
                    estado.className = 'mt-2 text-xs text-brand';
                });
            });
        }
    })();
    </script>
</x-app-layout>
