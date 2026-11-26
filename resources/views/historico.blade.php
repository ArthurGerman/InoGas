<x-app-layout titulo="Histórico" ativo="historico">
    @php
        $alertas->load('local:id,nome');
        $limiteRisco = config('inogas.limites.risco');
        $sufixo = config('inogas.unidade.sufixo');
    @endphp

    <div class="space-y-6">

        <div>
            <h1 class="text-3xl font-semibold">Histórico de alertas</h1>
            <p class="mt-1 text-soft">
                Cada linha é um alerta: do momento em que a leitura passou do limite até voltar ao normal.
            </p>
        </div>

        <!-- Filtro por datas -->
        <x-cartao>
            <form method="GET" action="{{ route('historico') }}" class="grid gap-4 md:grid-cols-[1fr_1fr_auto_auto] md:items-end">
                <div>
                    <label for="inicio" class="mb-1.5 block text-sm font-medium">Data inicial</label>
                    <input id="inicio" type="date" name="inicio" value="{{ request('inicio') }}"
                           class="w-full rounded-lg border border-line bg-canvas px-3.5 py-2.5 text-sm text-ink">
                </div>
                <div>
                    <label for="fim" class="mb-1.5 block text-sm font-medium">Data final</label>
                    <input id="fim" type="date" name="fim" value="{{ request('fim') }}"
                           class="w-full rounded-lg border border-line bg-canvas px-3.5 py-2.5 text-sm text-ink">
                </div>
                <button type="submit"
                        class="rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-brand-ink transition-colors hover:bg-brand/90">
                    Aplicar período
                </button>
                <a href="{{ route('historico') }}"
                   class="rounded-lg border border-line px-4 py-2.5 text-center text-sm font-medium text-soft transition-colors hover:text-ink">
                    Limpar
                </a>
            </form>
        </x-cartao>

        <!-- Tabela de alertas -->
        <x-cartao titulo="Alertas registrados">
            <div class="-mt-2 mb-4 flex flex-wrap items-center justify-between gap-3">
                <p class="text-sm text-soft">
                    @if ($alertas->total() > 0)
                        Mostrando {{ $alertas->firstItem() }} a {{ $alertas->lastItem() }} de {{ $alertas->total() }} alertas
                    @else
                        Nenhum alerta neste período
                    @endif
                </p>
                @if ($alertas->total() > 0)
                    <a href="{{ \Illuminate\Support\Facades\Route::has('historico.pdf') ? route('historico.pdf', array_filter(['inicio' => request('inicio'), 'fim' => request('fim')])) : '#' }}"
                       data-so="responsavel"
                       class="rounded-lg border border-line px-4 py-2 text-sm font-medium transition-colors hover:border-brand/40">
                        Exportar PDF
                    </a>
                @endif
            </div>

            <div class="-mx-5 overflow-x-auto">
                <table class="w-full min-w-[52rem] text-left text-sm">
                    <thead>
                        <tr class="border-y border-line bg-panel-2/60 text-soft">
                            <th scope="col" class="px-5 py-3 font-medium">Início</th>
                            <th scope="col" class="px-5 py-3 font-medium">Duração</th>
                            <th scope="col" class="px-5 py-3 font-medium">Local</th>
                            <th scope="col" class="px-5 py-3 font-medium">Pico{{ config('inogas.unidade.calibrado') ? '' : ' (sinal bruto)' }}</th>
                            <th scope="col" class="px-5 py-3 font-medium">Nível</th>
                            <th scope="col" class="px-5 py-3 font-medium">Confirmações</th>
                            <th scope="col" class="px-5 py-3 font-medium">Silenciado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line">
                        @forelse ($alertas as $alerta)
                            @php $nivel = $alerta->nivel === 'risco' ? 'risco' : 'atencao'; @endphp
                            <tr>
                                <td class="px-5 py-3.5 whitespace-nowrap">{{ optional($alerta->iniciado_em ?? $alerta->created_at)->format('d/m/Y H:i:s') }}</td>
                                <td class="px-5 py-3.5 whitespace-nowrap text-soft">{{ $alerta->encerrado_em ? $alerta->duracaoTexto() : 'Em andamento' }}</td>
                                <td class="px-5 py-3.5 text-soft">{{ optional($alerta->local)->nome ?? '—' }}</td>
                                <td class="px-5 py-3.5 font-semibold tabular-nums">{{ $alerta->pico_bruto }}{{ $sufixo ? ' ' . $sufixo : '' }}</td>
                                <td class="px-5 py-3.5">
                                    @if ($alerta->simulado)
                                        <x-selo estado="info">Teste</x-selo>
                                    @else
                                        <x-selo :estado="$nivel">{{ $nivel === 'risco' ? 'Risco' : 'Atenção' }}</x-selo>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-soft">{{ $alerta->confirmacoes_count }}</td>
                                <td class="px-5 py-3.5 text-soft">{{ $alerta->silenciado_em ? optional($alerta->silenciadoPor)->name . ' às ' . $alerta->silenciado_em->format('H:i') : '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-10 text-center text-soft">
                                    Nenhum alerta registrado neste período.<br>
                                    <span class="text-xs">Escolha outras datas ou toque em Limpar para ver todos.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($alertas->hasPages())
                <div class="mt-5 border-t border-line pt-4">
                    {{ $alertas->onEachSide(1)->links('vendor.pagination.inogas') }}
                </div>
            @endif
        </x-cartao>

        <!-- Resumo por período (antigo "Relatórios") -->
        <x-cartao titulo="Alertas por período" data-so="responsavel">
            <div class="-mt-2 mb-4 flex flex-wrap items-center justify-between gap-3">
                <p class="max-w-xl text-sm text-soft">
                    Média das leituras do sensor em cada intervalo (o sistema guarda uma leitura por minuto, por {{ config('inogas.amostras.guardar_dias', 30) }} dias). O valor é o sinal bruto, sem calibração.
                </p>

                <div class="inline-flex rounded-lg border border-line bg-canvas p-1 text-sm" role="group" aria-label="Período do gráfico">
                    <button type="button" data-periodo="hora" aria-pressed="false" class="rounded-md px-3 py-1 font-medium text-soft aria-pressed:bg-brand/15 aria-pressed:text-brand">1 hora</button>
                    <button type="button" data-periodo="dia" aria-pressed="true" class="rounded-md px-3 py-1 font-medium text-soft aria-pressed:bg-brand/15 aria-pressed:text-brand">24 horas</button>
                    <button type="button" data-periodo="semana" aria-pressed="false" class="rounded-md px-3 py-1 font-medium text-soft aria-pressed:bg-brand/15 aria-pressed:text-brand">7 dias</button>
                    <button type="button" data-periodo="mes" aria-pressed="false" class="rounded-md px-3 py-1 font-medium text-soft aria-pressed:bg-brand/15 aria-pressed:text-brand">30 dias</button>
                    <button type="button" data-periodo="ano" aria-pressed="false" class="rounded-md px-3 py-1 font-medium text-soft aria-pressed:bg-brand/15 aria-pressed:text-brand">12 meses</button>
                </div>
            </div>

            <div class="relative h-64">
                <canvas id="grafico-periodo" role="img" aria-label="Gráfico da média dos picos de alerta por período"></canvas>
                <p id="grafico-msg" role="status" class="absolute inset-0 grid place-items-center text-center text-sm text-soft">Carregando...</p>
            </div>

            <div class="mt-4 flex flex-wrap gap-2 border-t border-line pt-4">
                <x-selo estado="normal">Até o limite de atenção</x-selo>
                <x-selo estado="atencao">Atenção</x-selo>
                <x-selo estado="risco">Risco</x-selo>
            </div>
        </x-cartao>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
    (() => {
        const CFG = window.INOGAS;
        const LIM = CFG.limites;
        const $ = (id) => document.getElementById(id);

        let periodo = 'dia';
        let grafico = null;
        let pedido = 0;

        function cor(v) { return v > LIM.risco ? '#f26b6b' : (v > LIM.atencao ? '#f2b84b' : '#3ddbb5'); }

        function mensagem(texto) {
            const m = $('grafico-msg');
            m.textContent = texto;
            m.hidden = texto === null;
        }

        function desenhar(rotulos, valores) {
            if (grafico) grafico.destroy();
            if (!window.Chart) { mensagem('Não foi possível carregar o gráfico.'); return; }
            grafico = new Chart($('grafico-periodo'), {
                type: 'bar',
                data: {
                    labels: rotulos,
                    datasets: [{
                        data: valores,
                        backgroundColor: valores.map(cor),
                        borderRadius: 6,
                        borderSkipped: false,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { callbacks: { label: (c) => 'Média das leituras: ' + Math.round(c.parsed.y) } },
                    },
                    scales: {
                        x: { ticks: { color: '#8b9bb0', maxTicksLimit: 8 }, grid: { display: false } },
                        y: { beginAtZero: true, suggestedMax: LIM.risco * 1.2, ticks: { color: '#8b9bb0' }, grid: { color: '#1f2d42' } },
                    },
                },
            });
        }

        async function carregar() {
            const id = ++pedido;
            mensagem('Carregando...');
            try {
                const r = await fetch('/api/relatorio?periodo=' + periodo, { headers: { Accept: 'application/json' } });
                if (!r.ok) throw new Error('HTTP ' + r.status);
                const dados = await r.json();
                if (id !== pedido) return;
                if (!Array.isArray(dados) || dados.length === 0) {
                    if (grafico) { grafico.destroy(); grafico = null; }
                    mensagem('Sem alertas neste período.');
                    return;
                }
                mensagem(null);
                desenhar(dados.map((d) => d.periodo), dados.map((d) => Number(d.valor)));
            } catch (e) {
                if (id !== pedido) return;
                if (grafico) { grafico.destroy(); grafico = null; }
                mensagem('Não foi possível carregar o gráfico. Tente de novo em instantes.');
            }
        }

        document.querySelectorAll('[data-periodo]').forEach((botao) => {
            botao.addEventListener('click', () => {
                periodo = botao.dataset.periodo;
                document.querySelectorAll('[data-periodo]').forEach((b) => b.setAttribute('aria-pressed', b === botao ? 'true' : 'false'));
                carregar();
            });
        });

        carregar();
    })();
    });
    </script>
</x-app-layout>
