<x-app-layout titulo="Painel" ativo="painel">
    @php
        $ehResponsavel = session('usuario_papel', 'responsavel') === 'responsavel';
        $usuarioAtual = \App\Models\Usuario::find((int) session('usuario_id'));
        $idsLocais = $usuarioAtual ? $usuarioAtual->locaisVisiveisIds() : [];
        $sensorReal = \App\Models\Dispositivo::with('local')->where('ativo', true)
            ->whereIn('local_id', $idsLocais)
            ->orderBy('id')->first();
        $semAcessoMorador = ! $ehResponsavel && ! $sensorReal;
        $ajusteAviso = \App\Models\ConfiguracaoAviso::do(optional($sensorReal)->local_id);
        $nomeSensor = optional($sensorReal)->nome;
        $caminhoSensor = $sensorReal && $sensorReal->local ? $sensorReal->local->caminho() : null;
        $nomeResidencia = $sensorReal && $sensorReal->local ? $sensorReal->local->raiz()->nome : null;
    @endphp
    @if ($semAcessoMorador)
        <div class="mx-auto max-w-xl rounded-xl border border-line bg-panel p-8 text-center">
            <span class="mx-auto grid size-12 place-items-center rounded-lg bg-panel-2 text-soft">
                <x-icone nome="casa" class="size-6" />
            </span>
            <h1 class="mt-4 text-xl font-semibold">Nenhum local liberado para você ainda</h1>
            <p class="mx-auto mt-2 max-w-md text-sm text-soft">
                Quem cuida da sua casa ou do seu prédio precisa liberar o seu acesso. Assim que isso acontecer,
                o Painel, o Histórico e os Alertas do seu local aparecem aqui.
            </p>
        </div>
    @else
    <div class="space-y-6">

        <!-- Título e selo de status do ambiente -->
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h1 class="text-3xl font-semibold">Como está sua casa</h1>
                <p class="mt-1 text-soft">Leituras e contexto do sensor selecionado.</p>
            </div>

            <div class="flex items-stretch gap-3">
                <div id="selo-box" role="status" aria-live="polite"
                     class="flex min-w-64 items-center gap-3 rounded-xl border border-line bg-panel px-4 py-3">
                    <span id="selo-icone" class="grid size-11 place-items-center rounded-lg bg-panel-2 text-soft">
                        <x-icone nome="escudo" class="size-6" />
                    </span>
                    <div>
                        <p class="text-xs text-soft">Status do ambiente</p>
                        <p id="selo-titulo" class="font-semibold">Aguardando leitura</p>
                        <p id="selo-sub" class="text-xs text-soft">Sem classificação</p>
                    </div>
                </div>

                @if (config('inogas.mostrar_pendencias'))
                    <div class="hidden w-28 place-items-center rounded-xl border border-dashed border-line p-2 text-center text-xs text-soft sm:grid">
                        Espaço do mascote
                    </div>
                @endif
            </div>
        </div>

        <!-- Voz: precisa de um toque por aba (regra dos navegadores) -->
        @if ($ajusteAviso['voz_ativa'])
            <div id="area-som" hidden class="flex flex-wrap items-center gap-3">
                <button id="btn-som" type="button" aria-pressed="false"
                        class="rounded-lg border border-line px-4 py-2 text-sm font-medium transition-colors hover:border-brand/40 aria-pressed:border-brand/40 aria-pressed:bg-brand/10 aria-pressed:text-brand">
                    Ativar avisos sonoros
                </button>
                <p class="text-xs text-soft">
                    O navegador só libera o som depois de um toque. Os avisos falados só tocam com o Painel aberto.
                </p>
            </div>
        @endif

        <!-- Alerta ativo: fica no topo e só aparece com leitura em atenção ou risco -->
        <section id="alerta-card" hidden role="alert" class="rounded-xl border border-attn/50 bg-panel p-5">
            <button id="faixa-som" type="button" hidden
                    class="mb-4 w-full rounded-lg border border-attn/60 bg-attn/15 px-4 py-3 text-left text-sm font-medium text-attn">
                Toque aqui para ouvir o aviso por voz
            </button>
            <div class="flex items-start justify-between gap-4">
                <h2 id="alerta-titulo" class="flex items-center gap-2 text-lg font-semibold">
                    <x-icone nome="alerta" class="size-5 text-attn" /> Alerta ativo
                </h2>
                <p id="alerta-hora" class="text-xs text-soft"></p>
            </div>

            <div class="mt-3 grid gap-6 md:grid-cols-2">
                <div>
                    <p id="alerta-texto" class="text-sm">
                        O sensor passou do limite configurado. Se sentir cheiro de gás, saia do local, evite faíscas e chamas e ventile o ambiente.
                    </p>
                    <button id="btn-ciente" type="button"
                            class="mt-4 inline-flex items-center gap-2 rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-brand-ink transition-colors hover:bg-brand/90">
                        Estou ciente
                    </button>
                    <p id="ciente-ok" hidden class="mt-4 inline-flex items-center gap-2 text-sm text-brand">
                        <x-icone nome="check" class="size-4" /> <span id="ciente-texto"></span>
                    </p>
                    <p id="total-confirmacoes" class="mt-3 text-sm text-soft"></p>
                    <p id="alerta-silenciado" hidden class="mt-3 rounded-lg border border-line bg-canvas/40 px-3 py-2 text-xs text-soft"></p>
                    <p id="ciente-erro" role="status" hidden class="mt-3 text-sm text-risk"></p>
                </div>

                <div data-so="responsavel">
                    <p class="text-xs font-medium tracking-wide text-soft uppercase">Confirmações</p>
                    <ul id="lista-confirmacoes" class="mt-2 divide-y divide-line text-sm"></ul>
                    <p id="lista-vazia-conf" class="mt-2 text-xs text-soft">Ninguém confirmou ainda.</p>
                </div>
            </div>
            <div class="mt-5 border-t border-line pt-4">
                <h3 class="mb-3 text-sm font-semibold">Checklist de emergência</h3>
                <x-checklist-emergencia />
            </div>
        </section>


        <!-- Residência e dispositivo -->
        <x-cartao>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label for="residencia" class="mb-1.5 block text-sm font-medium">Residência</label>
                    <select id="residencia" disabled class="w-full rounded-lg border border-line bg-canvas px-3.5 py-2.5 text-sm text-soft">
                        <option>{{ $nomeResidencia ?? 'Nenhuma cadastrada' }}</option>
                    </select>
                </div>
                <div>
                    <label for="dispositivo" class="mb-1.5 block text-sm font-medium">Sensor</label>
                    <select id="dispositivo" disabled class="w-full rounded-lg border border-line bg-canvas px-3.5 py-2.5 text-sm text-soft">
                        <option>{{ $nomeSensor ?? 'Nenhum cadastrado' }}</option>
                    </select>
                </div>
            </div>
            @if (! $sensorReal && $ehResponsavel)
                <p class="mt-4 text-sm text-soft">
                    Cadastre a sua residência e o sensor em
                    <a href="{{ \Illuminate\Support\Facades\Route::has('residencias') ? route('residencias') : '#' }}" class="font-medium text-brand hover:underline">Minhas casas e sensores</a>.
                    As leituras abaixo continuam chegando do sensor, mesmo sem o cadastro.
                </p>
            @endif
        </x-cartao>

        <!-- Leitura e última atualização -->
        <div class="grid gap-6 md:grid-cols-2">

            <x-cartao rotulo="Leitura do sensor" :titulo="config('inogas.unidade.rotulo') . (config('inogas.unidade.nota') ? ', ' . mb_strtolower(config('inogas.unidade.nota')) : '')">
                <div class="flex items-center gap-6">
                    <div class="shrink-0 text-center">
                        <svg viewBox="0 0 100 150" class="h-36 w-auto" role="img" aria-label="Botijão de gás com nível relativo do sinal">
                            <defs>
                                <clipPath id="corpo-botijao"><rect x="12" y="22" width="76" height="112" rx="26" /></clipPath>
                            </defs>
                            <rect x="38" y="4" width="24" height="10" rx="3" fill="none" stroke="currentColor" stroke-width="2" class="text-soft" />
                            <rect x="44" y="14" width="12" height="8" fill="none" stroke="currentColor" stroke-width="2" class="text-soft" />
                            <g clip-path="url(#corpo-botijao)">
                                <rect id="botijao-fill" x="12" y="134" width="76" height="0" fill="currentColor" class="text-soft" />
                            </g>
                            <rect x="12" y="22" width="76" height="112" rx="26" fill="none" stroke="currentColor" stroke-width="2" class="text-soft" />
                            <rect x="26" y="138" width="48" height="6" rx="3" fill="none" stroke="currentColor" stroke-width="2" class="text-soft" />
                        </svg>
                        <p id="botijao-nivel" class="mt-1 text-xs text-soft">Sem leitura</p>
                    </div>

                    <div class="min-w-0">
                        <p id="valor" class="text-6xl leading-none font-semibold tabular-nums">—</p>
                        <p id="valor-legenda" class="mt-3 text-sm text-soft">Aguardando a primeira leitura.</p>
                    </div>
                </div>
                <p class="mt-5 border-t border-line pt-4 text-xs text-soft">
                    O desenho mostra só o nível relativo do sinal do sensor. Ele não indica a quantidade de gás no ambiente.
                </p>
            </x-cartao>

            <x-cartao rotulo="Última atualização" titulo="Recebimento dos dados">
                <div class="flex items-start gap-3">
                    <span id="com-ponto" class="mt-1.5 size-2.5 shrink-0 rounded-full bg-soft"></span>
                    <div>
                        <p id="com-texto" class="font-medium">Aguardando dados</p>
                        <p id="com-sub" class="text-xs text-soft">Nenhuma leitura recebida ainda.</p>
                    </div>
                </div>

                <dl class="mt-5 space-y-3 text-sm">
                    <div class="flex justify-between gap-4"><dt class="text-soft">Hora da leitura</dt><dd id="hora-leitura" class="font-medium">—</dd></div>
                    <div class="flex justify-between gap-4"><dt class="text-soft">Chegou há</dt><dd id="chegou-ha" class="font-medium">—</dd></div>
                    <div class="flex justify-between gap-4"><dt class="text-soft">Status enviado pelo sensor</dt><dd id="status-sensor" class="font-medium">—</dd></div>
                </dl>
                <p class="mt-5 border-t border-line pt-4 text-xs text-soft">
                    Se o sensor ficar {{ config('inogas.sem_sinal_apos_segundos') }} segundos sem enviar uma leitura nova, o painel passa a mostrar “Sem sinal”.
                </p>
            </x-cartao>
        </div>

        <!-- Avisos -->
        <div class="flex items-start gap-3 rounded-xl border border-info/40 bg-info/10 px-4 py-3">
            <x-icone nome="info" class="mt-0.5 size-5 shrink-0 text-info" />
            <div class="text-sm">
                <p class="font-medium text-info">Alertas ainda em ajuste</p>
                <p class="text-soft">
                    @if (config('inogas.unidade.calibrado'))
                        Os limites de atenção e de risco ainda estão sendo validados.
                    @else
                        Sem calibração e critérios definidos, a leitura não permite afirmar que o ambiente está seguro.
                    @endif
                </p>
            </div>
        </div>

        <div id="tendencia" hidden class="flex items-start gap-3 rounded-xl border border-attn/40 bg-attn/10 px-4 py-3" role="status">
            <x-icone nome="tendencia" class="mt-0.5 size-5 shrink-0 text-attn" />
            <div class="text-sm">
                <p class="font-medium text-attn">Nível subindo rápido</p>
                <p class="text-soft">As últimas leituras estão em alta. Fique atento ao próximo aviso.</p>
            </div>
        </div>

        <!-- Evolução e origem (visão do Responsável) -->
        <div class="grid gap-6 lg:grid-cols-3" data-so="responsavel">
            <x-cartao titulo="Evolução das leituras" class="lg:col-span-2">
                <div class="relative h-56">
                    <canvas id="grafico" aria-label="Gráfico das últimas leituras do sensor" role="img"></canvas>
                    <p id="grafico-vazio" class="absolute inset-0 grid place-items-center text-center text-sm text-soft">
                        Ainda não há leituras para exibir.<br>Os pontos aparecem quando o sensor enviar dados.
                    </p>
                </div>
                <div class="mt-4 flex items-center justify-between gap-4 border-t border-line pt-4">
                    <p class="text-xs text-soft">Últimas 20 leituras recebidas nesta tela.</p>
                    <a href="{{ \Illuminate\Support\Facades\Route::has('historico') ? route('historico') : '#' }}"
                       class="rounded-lg border border-line bg-panel-2 px-4 py-2 text-sm font-medium transition-colors hover:border-brand/40">
                        Ver histórico
                    </a>
                </div>
            </x-cartao>

            <x-cartao rotulo="Seu sensor" :titulo="$nomeSensor ?? 'Nenhum sensor cadastrado'">
                @if ($caminhoSensor)
                    <p class="mb-3 text-sm text-soft">{{ $caminhoSensor }}</p>
                @endif
                <p>
                    <span id="origem-com" class="inline-flex items-center gap-1.5 rounded-full border border-soft/40 bg-soft/10 px-2.5 py-1 text-xs font-medium text-soft">
                        Aguardando dados
                    </span>
                </p>
            </x-cartao>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
    (() => {
        const CFG = window.INOGAS;
        const LIM = CFG.limites;
        const SEM_SINAL_MS = CFG.semSinalApos * 1000;
        const TEND = @json(config('inogas.tendencia'));
        const VOZ = @json(['ativa' => $ajusteAviso['voz_ativa'], 'volume' => $ajusteAviso['volume']]);
        const vozSuportada = 'speechSynthesis' in window && typeof SpeechSynthesisUtterance !== 'undefined';
        let somLiberado = false;
        let ultimaFala = 0;
        let ultimoNivelFalado = null;
        const demo = new URLSearchParams(location.search).get('demo'); // ?demo=normal|atencao|risco|subindo|semsinal|aguardando|erro

        const $ = (id) => document.getElementById(id);
        const CORES_TEXTO = ['text-soft', 'text-brand', 'text-attn', 'text-risk'];
        const CORES_BORDA = ['border-line', 'border-brand/40', 'border-attn/50', 'border-risk/50'];

        const ESTADOS = {
            aguardando: { titulo: 'Aguardando leitura', sub: 'Sem classificação', texto: 'text-soft', borda: 'border-line' },
            normal: { titulo: 'Sem alerta no momento', sub: 'Leitura abaixo do limite de atenção', texto: 'text-brand', borda: 'border-brand/40' },
            atencao: { titulo: 'Atenção', sub: 'Leitura acima do limite de atenção', texto: 'text-attn', borda: 'border-attn/50' },
            risco: { titulo: 'Risco', sub: 'Leitura acima do limite de risco', texto: 'text-risk', borda: 'border-risk/50' },
            semsinal: { titulo: 'Sem sinal', sub: 'Estado desconhecido. Isso não significa ambiente seguro.', texto: 'text-soft', borda: 'border-line' },
            erro: { titulo: 'Servidor indisponível', sub: 'Não foi possível buscar a leitura.', texto: 'text-soft', borda: 'border-line' },
        };

        const COMUNICACAO = {
            aguardando: ['Aguardando dados', 'Nenhuma leitura recebida ainda.', 'bg-soft'],
            normal: ['Recebendo dados', 'O sensor está enviando leituras.', 'bg-brand'],
            atencao: ['Recebendo dados', 'O sensor está enviando leituras.', 'bg-brand'],
            risco: ['Recebendo dados', 'O sensor está enviando leituras.', 'bg-brand'],
            semsinal: ['Sem sinal', 'Nenhuma leitura nova chegou a tempo.', 'bg-attn'],
            erro: ['Sem comunicação com o servidor', 'Tentando de novo a cada segundo.', 'bg-attn'],
        };

        // Estado interno
        let ultimaHora = null;
        let ultimaMudanca = Date.now();
        let ultimaLeitura = null;
        let amostras = [];          // {v}
        let estadoAnterior = null;
        let disparoHora = null;
        let cienteTexto = null;
        let alertaServidor = null;   // última resposta de /alertas/ativo
        let buscandoAlerta = false;
        let ultimaBuscaAlerta = 0;
        let demoAlertaMostrado = false;
        let tick = 0;

        // Funções pequenas de tela
        function texto(el, valor) { if (el && el.textContent !== valor) el.textContent = valor; }
        function trocarClasses(el, remover, adicionar) {
            if (!el) return;
            el.classList.remove(...remover);
            el.classList.add(...adicionar.split(' '));
        }
        function estadoPorValor(v) { return v > LIM.risco ? 'risco' : (v > LIM.atencao ? 'atencao' : 'normal'); }
        function formatarValor(v) {
            const s = CFG.unidade.sufixo ? ' ' + CFG.unidade.sufixo : '';
            return String(v) + s;
        }

        // Gráfico
        let grafico = null;
        const rotulosGrafico = [];
        const valoresGrafico = [];
        if (window.Chart && $('grafico')) {
            grafico = new Chart($('grafico'), {
                type: 'line',
                data: { labels: rotulosGrafico, datasets: [{ data: valoresGrafico, borderColor: '#3ddbb5', backgroundColor: 'rgba(61,219,181,.12)', tension: 0.3, fill: true, pointRadius: 2 }] },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { ticks: { color: '#8b9bb0', maxTicksLimit: 6 }, grid: { color: '#1f2d42' } },
                        y: { beginAtZero: true, ticks: { color: '#8b9bb0' }, grid: { color: '#1f2d42' } },
                    },
                },
            });
        }

        function registrar(leitura) {
            const v = Number(leitura.valor);
            amostras.push(v);
            if (amostras.length > 30) amostras.shift();
            rotulosGrafico.push(leitura.hora);
            valoresGrafico.push(v);
            if (rotulosGrafico.length > 20) { rotulosGrafico.shift(); valoresGrafico.shift(); }
            if (grafico) grafico.update();
            const vazio = $('grafico-vazio'); if (vazio) vazio.hidden = true;
        }

        function subindo() {
            if (amostras.length < TEND.amostras) return false;
            const ult = amostras.slice(-TEND.amostras);
            for (let i = 1; i < ult.length; i++) if (ult[i] < ult[i - 1]) return false;
            return ult[ult.length - 1] - ult[0] >= TEND.subida_minima;
        }

        // Botijão: o topo da escala é um pouco acima do limite de risco
        function botijao(valor, estado) {
            const topo = LIM.risco * 1.2;
            const pct = valor == null ? 0 : Math.max(0, Math.min(1, valor / topo));
            const altura = 112 * pct;
            const fill = $('botijao-fill');
            fill.setAttribute('y', String(134 - altura));
            fill.setAttribute('height', String(altura));
            trocarClasses(fill, CORES_TEXTO, ESTADOS[estado].texto);
            let nivel = 'Sem leitura';
            if (valor != null) nivel = valor > LIM.risco ? 'Nível alto' : (valor > LIM.atencao ? 'Nível médio' : 'Nível baixo');
            texto($('botijao-nivel'), nivel);
        }

        // ---------- Voz ----------
        function falar(texto) {
            if (!vozSuportada || !VOZ.ativa || !somLiberado) return false;
            window.speechSynthesis.cancel();
            const fala = new SpeechSynthesisUtterance(texto);
            fala.lang = 'pt-BR';
            fala.volume = Math.max(0, Math.min(1, VOZ.volume / 100));
            window.speechSynthesis.speak(fala);
            ultimaFala = Date.now();
            return true;
        }

        function textoDoAviso(estado) {
            if (estado === 'risco') {
                return 'Risco. O sensor passou do limite de risco. Saia do local agora, evite faíscas e chamas, e ventile o ambiente se for seguro. Depois, ligue para os Bombeiros, um nove três.';
            }
            return 'Atenção. O sensor passou do limite de atenção. Se sentir cheiro de gás, saia do local, evite faíscas e chamas e ventile o ambiente.';
        }

        function avisarPorVoz(estado) {
            if (!vozSuportada || !VOZ.ativa) return;
            const faixa = $('faixa-som');

            if (!somLiberado) {
                if (faixa) faixa.hidden = false;
                return;
            }

            if (faixa) faixa.hidden = true;
            if (alertaServidor && alertaServidor.silenciado_por) return;

            if (ultimoNivelFalado !== estado || Date.now() - ultimaFala > 60000) {
                ultimoNivelFalado = estado;
                falar(textoDoAviso(estado));
            }
        }

        function alternarSom() {
            somLiberado = !somLiberado;
            const botao = $('btn-som');
            if (botao) {
                botao.setAttribute('aria-pressed', somLiberado ? 'true' : 'false');
                botao.textContent = somLiberado ? 'Avisos sonoros: ligados' : 'Ativar avisos sonoros';
            }
            if (somLiberado) {
                falar('Avisos sonoros ligados.');
            } else {
                window.speechSynthesis.cancel();
            }
        }

        if (vozSuportada && VOZ.ativa) {
            const area = $('area-som');
            if (area) area.hidden = false;
            const botaoSom = $('btn-som');
            if (botaoSom) botaoSom.addEventListener('click', alternarSom);
            const faixaSom = $('faixa-som');
            if (faixaSom) {
                faixaSom.addEventListener('click', () => {
                    somLiberado = false;
                    ultimoNivelFalado = null;
                    alternarSom();
                    faixaSom.hidden = true;
                    if (estadoAnterior === 'atencao' || estadoAnterior === 'risco') {
                        ultimoNivelFalado = estadoAnterior;
                        falar(textoDoAviso(estadoAnterior));
                    }
                });
            }
        }

        function desenharAlerta(e) {
            const n = e.confirmacoes_total || 0;
            texto($('total-confirmacoes'), n === 0 ? 'Ninguém confirmou ainda.' : (n === 1 ? '1 pessoa confirmou que está ciente.' : n + ' pessoas confirmaram que estão cientes.'));

            const lista = $('lista-confirmacoes');
            if (Array.isArray(e.confirmacoes)) {
                lista.replaceChildren(...e.confirmacoes.map((c) => {
                    const li = document.createElement('li');
                    li.className = 'flex justify-between py-1.5';
                    const nome = document.createElement('span');
                    nome.textContent = c.nome;
                    const hora = document.createElement('span');
                    hora.className = 'text-soft';
                    hora.textContent = c.hora || '';
                    li.append(nome, hora);
                    return li;
                }));
                $('lista-vazia-conf').hidden = e.confirmacoes.length > 0;
            }

            const silencio = $('alerta-silenciado');
            if (e.silenciado_por) {
                silencio.hidden = false;
                silencio.textContent = 'Silenciado no sistema por ' + e.silenciado_por + ' às ' + e.silenciado_hm + '. O apito do sensor não é desligado por aqui.';
            } else {
                silencio.hidden = true;
            }

            cienteTexto = e.minha_confirmacao_hm ? 'Você confirmou às ' + e.minha_confirmacao_hm + '.' : null;
            $('btn-ciente').hidden = cienteTexto !== null;
            $('ciente-ok').hidden = cienteTexto === null;
            if (cienteTexto) texto($('ciente-texto'), cienteTexto);
        }

        async function atualizarAlertaDoServidor() {
            buscandoAlerta = true;
            ultimaBuscaAlerta = Date.now();
            try {
                const r = await fetch('/alertas/ativo', { headers: { Accept: 'application/json' } });
                if (r.ok) {
                    const e = await r.json();
                    alertaServidor = e.ativo ? e : null;
                    if (alertaServidor) desenharAlerta(alertaServidor);
                }
            } catch (erro) {
                /* tenta de novo no próximo ciclo */
            } finally {
                buscandoAlerta = false;
            }
        }

        function aplicar(estado, leitura) {
            const e = ESTADOS[estado];
            const valor = leitura && !['aguardando', 'erro'].includes(estado) ? Number(leitura.valor) : (estado === 'erro' && ultimaLeitura ? Number(ultimaLeitura.valor) : null);

            // Selo do ambiente
            texto($('selo-titulo'), e.titulo);
            texto($('selo-sub'), e.sub);
            trocarClasses($('selo-box'), CORES_BORDA, e.borda);
            trocarClasses($('selo-icone'), CORES_TEXTO, e.texto);

            // Valor e botijão
            const mostrar = valor != null && estado !== 'aguardando';
            texto($('valor'), mostrar ? formatarValor(valor) : '—');
            $('valor').classList.toggle('opacity-50', estado === 'semsinal' || estado === 'erro');
            let legenda = 'Aguardando a primeira leitura.';
            if (estado === 'semsinal' || estado === 'erro') legenda = 'Última leitura recebida. Pode estar desatualizada.';
            else if (mostrar) legenda = CFG.unidade.nota ? CFG.unidade.rotulo + ' · ' + CFG.unidade.nota : CFG.unidade.rotulo;
            texto($('valor-legenda'), legenda);
            botijao(mostrar ? valor : null, mostrar ? estado : 'aguardando');

            // Comunicação
            const c = COMUNICACAO[estado];
            texto($('com-texto'), c[0]);
            texto($('com-sub'), c[1]);
            trocarClasses($('com-ponto'), ['bg-soft', 'bg-brand', 'bg-attn'], c[2]);
            texto($('origem-com'), c[0]);

            const segundos = Math.max(0, Math.round((Date.now() - ultimaMudanca) / 1000));
            texto($('hora-leitura'), leitura && leitura.hora ? leitura.hora : (ultimaLeitura ? ultimaLeitura.hora : '—'));
            texto($('chegou-ha'), ultimaLeitura && estado !== 'aguardando' ? 'há ' + segundos + ' s' : '—');
            texto($('status-sensor'), ultimaLeitura && estado !== 'aguardando' ? ultimaLeitura.status : '—');

            // Tendência
            const ativo = ['normal', 'atencao', 'risco'].includes(estado);
            $('tendencia').hidden = !(ativo && subindo());

            // Alerta ativo
            const emAlerta = estado === 'atencao' || estado === 'risco';
            if (emAlerta && !['atencao', 'risco'].includes(estadoAnterior)) {
                disparoHora = leitura.hora;
                cienteTexto = null;
                alertaServidor = null;
                demoAlertaMostrado = false;
                ultimaBuscaAlerta = 0;
            }
            if (!emAlerta) alertaServidor = null;
            const card = $('alerta-card');
            card.hidden = !emAlerta;
            if (emAlerta) {
                texto($('alerta-hora'), 'Disparado às ' + (alertaServidor ? alertaServidor.iniciado_hm : disparoHora));
                trocarClasses(card, ['border-attn/50', 'border-risk/50'], estado === 'risco' ? 'border-risk/50' : 'border-attn/50');
                $('btn-ciente').hidden = cienteTexto !== null;
                $('ciente-ok').hidden = cienteTexto === null;
                if (cienteTexto) texto($('ciente-texto'), cienteTexto);

                if (demo && !demoAlertaMostrado) {
                    demoAlertaMostrado = true;
                    desenharAlerta({
                        confirmacoes_total: 3,
                        confirmacoes: [
                            { nome: 'Ana Costa (exemplo)', hora: '14:34' },
                            { nome: 'João Lima (exemplo)', hora: '14:36' },
                            { nome: 'Marina Souza (exemplo)', hora: '14:38' },
                        ],
                        silenciado_por: null,
                        minha_confirmacao_hm: null,
                    });
                }
            }
            if (emAlerta) {
                avisarPorVoz(estado);
            } else {
                ultimoNivelFalado = null;
                const faixa = $('faixa-som');
                if (faixa) faixa.hidden = true;
            }
            estadoAnterior = estado;
        }

        $('btn-ciente').addEventListener('click', async () => {
            const erro = $('ciente-erro');
            erro.hidden = true;

            if (demo) {
                const hm = new Date().toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
                cienteTexto = 'Você confirmou às ' + hm + ' (exemplo).';
                $('btn-ciente').hidden = true;
                $('ciente-ok').hidden = false;
                texto($('ciente-texto'), cienteTexto);
                return;
            }

            try {
                if (!alertaServidor) await atualizarAlertaDoServidor();
                if (!alertaServidor) {
                    erro.textContent = 'Não encontrei o alerta no servidor. Tente de novo em instantes.';
                    erro.hidden = false;
                    return;
                }
                const r = await window.inogasEnviar('/alertas/' + alertaServidor.id + '/ciente');
                if (r.ok) {
                    alertaServidor = r.corpo;
                    desenharAlerta(r.corpo);
                } else {
                    erro.textContent = (r.corpo && (r.corpo.erro || r.corpo.message)) || 'Não foi possível registrar. Tente de novo.';
                    erro.hidden = false;
                }
            } catch (e) {
                erro.textContent = 'Sem conexão com o servidor. Tente de novo.';
                erro.hidden = false;
            }
        });

        // Busca da leitura (ou simulação com ?demo=...)
        async function buscar() {
            if (demo) {
                tick++;
                const agora = new Date().toLocaleTimeString('pt-BR', { hour12: false });
                const valores = { normal: 142, atencao: 310, risco: 560, subindo: 130 + tick * 12 };
                if (demo === 'erro') throw new Error('demo');
                if (demo === 'aguardando') return { valor: 0, status: 'Sem dados', hora: '--:--:--' };
                if (demo === 'semsinal') return { valor: 180, status: 'Normal', hora: '10:00:00' };
                return { valor: valores[demo] ?? 142, status: demo === 'risco' ? 'Alerta' : 'Normal', hora: agora };
            }
            const ctrl = new AbortController();
            const limite = setTimeout(() => ctrl.abort(), 4000);
            try {
                const r = await fetch('/api/leitura-atual', { signal: ctrl.signal, headers: { Accept: 'application/json' } });
                if (!r.ok) throw new Error('HTTP ' + r.status);
                return await r.json();
            } finally {
                clearTimeout(limite);
            }
        }

        async function ciclo() {
            try {
                const leitura = await buscar();
                const semDados = leitura.hora === '--:--:--' || leitura.status === 'Sem dados';
                if (semDados) {
                    aplicar('aguardando', leitura);
                } else {
                    if (leitura.hora !== ultimaHora) {
                        ultimaHora = leitura.hora;
                        ultimaMudanca = Date.now();
                        registrar(leitura);
                    }
                    ultimaLeitura = leitura;
                    if (demo === 'semsinal') ultimaMudanca = Date.now() - SEM_SINAL_MS - 1000;
                    const parado = Date.now() - ultimaMudanca > SEM_SINAL_MS;
                    aplicar(parado ? 'semsinal' : estadoPorValor(Number(leitura.valor)), leitura);
                }
            } catch (erro) {
                aplicar('erro', null);
            }
            if (!demo && ['atencao', 'risco'].includes(estadoAnterior) && !buscandoAlerta && Date.now() - ultimaBuscaAlerta > 3000) {
                atualizarAlertaDoServidor();
            }
            setTimeout(ciclo, 1000);
        }

        ciclo();
    })();
    });
    </script>
    @endif
</x-app-layout>
