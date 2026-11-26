<x-app-layout titulo="Alertas" ativo="alertas">
    @php $ehResponsavel = session('usuario_papel', 'responsavel') === 'responsavel'; @endphp
    <div class="space-y-6">

        <div>
            <h1 class="text-3xl font-semibold">Alertas</h1>
            <p class="mt-1 text-soft">Como o InoGas vai avisar quando a leitura passar do limite.</p>
        </div>

        <x-pendente recurso="alertas">
            Esta tela mostra exemplos de como os avisos vão funcionar. Nenhum aviso é enviado de verdade.
        </x-pendente>

        <x-seletor-local />

        <!-- Onde ficam os alertas reais -->
        <x-cartao>
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-start gap-4">
                    <span class="grid size-11 shrink-0 place-items-center rounded-lg bg-panel-2 text-soft">
                        <x-icone nome="sino" class="size-6" />
                    </span>
                    <div>
                        <h2 class="text-lg font-semibold">Os alertas reais aparecem no Painel e no Histórico</h2>
                        <p class="mt-1 max-w-xl text-sm text-soft">
                            Quando a leitura passa do limite, o Painel mostra o alerta na hora e o Histórico guarda o pico de cada ocorrência.
                        </p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('painel') }}" class="rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-brand-ink transition-colors hover:bg-brand/90">Ir para o Painel</a>
                    <a href="{{ route('historico') }}" class="rounded-lg border border-line px-4 py-2.5 text-sm font-medium transition-colors hover:border-brand/40">Ver histórico</a>
                </div>
            </div>
        </x-cartao>

        <!-- Linha do tempo do alerta -->
        <x-cartao rotulo="Linha do tempo do alerta" titulo="Como o aviso vai escalar">
            <p class="-mt-2 mb-5 text-sm text-soft">Exemplo. Cada etapa é uma ação prevista, e não um estado ativo.</p>
            <ol class="grid gap-4 md:grid-cols-3">
                <li class="rounded-lg border border-line bg-canvas/40 p-4">
                    <span class="grid size-9 place-items-center rounded-lg bg-panel-2 text-brand"><x-icone nome="monitor" class="size-5" /></span>
                    <p class="mt-3 text-sm font-semibold">1. Aviso na tela</p>
                    <p class="mt-1 text-xs text-soft">O Painel mostra o alerta e o botão “Estou ciente”.</p>
                </li>
                <li class="rounded-lg border border-line bg-canvas/40 p-4">
                    <span class="grid size-9 place-items-center rounded-lg bg-panel-2 text-attn"><x-icone nome="sino" class="size-5" /></span>
                    <p class="mt-3 text-sm font-semibold">2. Alarme sonoro e voz</p>
                    <p class="mt-1 text-xs text-soft">O alarme toca e a voz diz o nível atual.</p>
                </li>
                <li class="rounded-lg border border-line bg-canvas/40 p-4">
                    <span class="grid size-9 place-items-center rounded-lg bg-panel-2 text-risk"><x-icone nome="enviar" class="size-5" /></span>
                    <p class="mt-3 text-sm font-semibold">3. Aviso ao responsável</p>
                    <p class="mt-1 text-xs text-soft">Se ninguém confirmar, uma mensagem vai pelo Telegram.</p>
                </li>
            </ol>
        </x-cartao>

        @if ($ehResponsavel)
        <p data-so="responsavel" class="text-sm text-soft">
            Os ajustes de voz e de Telegram agora ficam em
            <a href="{{ \Illuminate\Support\Facades\Route::has('configuracoes') ? route('configuracoes') : '#' }}" class="font-medium text-brand hover:underline">Configurações</a>.
        </p>
        @endif

        <!-- Checklist -->
        <x-cartao rotulo="Checklist de emergência" titulo="Passos em ordem">
            <p class="-mt-2 mb-4 text-sm text-soft">Marcar os passos serve só para você acompanhar. Nada é enviado.</p>
            <x-checklist-emergencia />
        </x-cartao>

        @if ($ehResponsavel)
        <!-- Silenciar alarme (Responsável) -->
        <div data-so="responsavel">
            <x-cartao rotulo="Silenciamento do alarme" titulo="Silenciar com PIN">
                <p class="-mt-2 mb-4 text-sm text-soft">Silencia o alerta no sistema e registra quem fez e quando. O apito do próprio sensor não é desligado por aqui.</p>
                <button id="btn-silenciar" type="button"
                        class="rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-brand-ink transition-colors hover:bg-brand/90">
                    Silenciar alarme
                </button>

                <div id="area-pin" hidden class="mt-4 max-w-sm">
                    <label for="pin" class="mb-1.5 block text-sm font-medium">PIN de autorização</label>
                    <div class="flex gap-3">
                        <input id="pin" type="password" inputmode="numeric" autocomplete="off" placeholder="Digite seu PIN"
                               class="w-full rounded-lg border border-line bg-canvas px-3.5 py-2.5 text-sm text-ink placeholder:text-soft/70">
                        <button id="btn-pin" type="button"
                                class="rounded-lg border border-line px-4 py-2.5 text-sm font-medium transition-colors hover:border-brand/40">
                            Confirmar
                        </button>
                    </div>
                    <p id="pin-msg" role="status" hidden class="mt-2 text-sm text-brand"></p>
                </div>

                <p class="mt-4 text-xs text-soft">O silenciamento fica registrado com o nome de quem o fez. Ainda não tem PIN? Defina em Configurações.</p>
            </x-cartao>
        </div>
        @endif

        <!-- Rodapé explicativo -->
        <div class="grid gap-6 md:grid-cols-2">
            <x-cartao rotulo="O que está pendente" titulo="Falta ligar ao back">
                <p class="text-sm text-soft">
                    Conversão do sinal em concentração (ppm), limites validados, envio pelo Telegram,
                    confirmação por pessoa e registro de quem silenciou o alarme.
                </p>
            </x-cartao>
            <x-cartao rotulo="Como ler os avisos" titulo="Sem alerta não é garantia">
                <p class="text-sm text-soft">
                    “Sem alerta no momento” não significa que o ambiente está seguro. O InoGas ainda é um protótipo
                    e não é um detector certificado.
                </p>
            </x-cartao>
        </div>
    </div>

    <script>
    (() => {
        const $ = (id) => document.getElementById(id);
        const botao = $('btn-silenciar');
        if (!botao) return;

        const msg = $('pin-msg');
        function mostrar(texto, erro) {
            msg.hidden = false;
            msg.textContent = texto;
            msg.className = 'mt-2 text-sm ' + (erro ? 'text-risk' : 'text-brand');
        }

        botao.addEventListener('click', () => {
            const area = $('area-pin');
            area.hidden = !area.hidden;
            if (!area.hidden) $('pin').focus();
        });

        $('btn-pin').addEventListener('click', async () => {
            const pin = $('pin').value.trim();
            if (!/^\d{4,8}$/.test(pin)) {
                mostrar('Digite o PIN: de 4 a 8 números.', true);
                return;
            }

            $('btn-pin').disabled = true;
            try {
                const resposta = await fetch('/alertas/ativo', { headers: { Accept: 'application/json' } });
                const ativo = resposta.ok ? await resposta.json() : null;
                if (!ativo || !ativo.ativo) {
                    mostrar('Não há alerta ativo agora, então não há o que silenciar.', true);
                    return;
                }

                const r = await window.inogasEnviar('/alertas/' + ativo.id + '/silenciar', { pin });
                if (r.ok) {
                    mostrar('Alarme silenciado no sistema por ' + (r.corpo.silenciado_por || 'você') + ' às ' + (r.corpo.silenciado_hm || '') + '. O apito do sensor não é desligado por aqui.', false);
                    $('pin').value = '';
                } else if (r.status === 429) {
                    mostrar('Muitas tentativas. Espere um minuto e tente de novo.', true);
                } else {
                    const erros = r.corpo && r.corpo.errors ? Object.values(r.corpo.errors)[0][0] : null;
                    mostrar((r.corpo && (r.corpo.erro || erros || r.corpo.message)) || 'Não foi possível silenciar. Tente de novo.', true);
                }
            } catch (e) {
                mostrar('Sem conexão com o servidor. Tente de novo.', true);
            } finally {
                $('btn-pin').disabled = false;
            }
        });
    })();
    </script>
</x-app-layout>
