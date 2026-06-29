<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InoGas Dashboard</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @vite(['resources/css/app.css'])

    <style>
        @keyframes piscar {
            0%, 50%, 100% {
                opacity: 1;
            }
            25%, 75% {
                opacity: 0.3;
            }
        }
        
        .alerta-ativo {
            animation: piscar 0.8s infinite;
        }
    </style>
</head>
<body class="bg-slate-100">

<div class="flex h-screen">

    <!-- Sidebar -->
    <aside class="w-72 bg-white border-r flex flex-col">

        <div class="p-6 border-b flex items-center">

            <span class="text-3xl">
                🌿
            </span>

            <h1 class="text-4xl font-bold text-emerald-950">
                InoGas
            </h1>

        </div>

        <nav class="flex-1 p-6">

            <ul class="space-y-2">

                <li>
                    <a href=""
                       class="flex items-center gap-3 bg-emerald-950 text-white px-4 py-3 rounded-lg">
                            Painel
                    </a>
                </li>

                <li>
                    <a href="{{ route('historico') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-100">
                            Histórico de alertas
                    </a>
                </li>

                <li>
                    <a href="{{ route('relatorios') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-100">
                            Relatórios
                    </a>
                </li>

            </ul>

        </nav>

        <!--<div class="p-4">

            <button
                class="w-full bg-emerald-950 text-white py-3 rounded-lg hover:bg-emerald-900">
                Exportar Relatório
            </button>

        </div>-->

    </aside>

    <!-- Conteúdo -->
    <main class="flex-1 overflow-auto">

        <!-- Header -->
        <header
            class="bg-white border-b px-8 py-4 flex items-center justify-between">

            <div class="flex items-center gap-3">

                <h1 class="text-3xl font-bold text-emerald-950">
                    Sensor MQ-2
                </h1>

            </div>

            <div class="flex items-center gap-3">

                <span
                    id="alerta-status"
                    class="px-4 py-2 rounded-full bg-blue-100 text-blue-800 text-sm font-medium">
                    AMBIENTE LIMPO
                </span>

            </div>

        </header>

        <div class="p-10">

            <!-- Título -->
            <div class="mb-6">

                <h2 class="text-5xl font-bold text-emerald-950">
                    Painel Principal
                </h2>

            </div>

            <!-- Cards -->
            <div class="grid md:grid-cols-3 gap-6 mb-8">

                <div class="bg-white rounded-xl shadow-sm p-6">

                    <p class="text-gray-500">
                        Valor Atual (PPM)
                    </p>

                    <h3
                        id="valor"
                        class="text-5xl font-bold text-emerald-950 mt-3">
                        --
                    </h3>

                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">

                    <p class="text-gray-500">
                        Status de concentração
                    </p>

                    <h3
                        id="status"
                        class="text-4xl font-bold text-emerald-950 mt-3">
                        Sem dados
                    </h3>

                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">

                    <p class="text-gray-500">
                        Última Atualização
                    </p>

                    <h3
                        id="hora"
                        class="text-2xl mt-3">
                        --
                    </h3>

                </div>

            </div>

            <!-- Gráfico -->
            <div
                class="bg-white rounded-xl shadow-sm p-6">

                <div class="flex justify-between mb-6">

                    <h3 class="text-xl font-semibold">
                        Nível de concentração de gases tóxicos
                    </h3>

                </div>

                <canvas
                    id="grafico"
                    height="110">
                </canvas>

            </div>

        </div>

    </main>

</div>

<script>

const labels = [];
const valores = [];

const chart = new Chart(
    document.getElementById('grafico'),
    {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Concentração de Gás',
                data: valores,
                borderColor: '#22c55e',
                backgroundColor: 'rgba(34,197,94,.15)',
                tension: 0.35,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    }
);

async function atualizarPainel() {

    const resposta =
        await fetch('/api/leitura-atual');

    const leitura =
        await resposta.json();

    document.getElementById('valor')
        .innerText = leitura.valor;

    document.getElementById('status')
        .innerText = leitura.status;

    document.getElementById('hora')
        .innerText = leitura.hora;


    // Atualizar status de alerta
    const alertaSpan = document.getElementById('alerta-status');
    
    if(leitura.valor > 500) {
        alertaSpan.innerText = 'ALERTA DE GÁS';
        alertaSpan.className = 'px-4 py-2 rounded-full bg-red-100 text-red-800 text-sm font-medium alerta-ativo';

    } else if(leitura.valor > 200) {
        alertaSpan.innerText = 'ALERTA DE GÁS';
        alertaSpan.className = 'px-4 py-2 rounded-full bg-yellow-100 text-yellow-800 text-sm font-medium alerta-ativo';
    }
    
    else {
        alertaSpan.innerText = 'AMBIENTE LIMPO';
        alertaSpan.className = 'px-4 py-2 rounded-full bg-blue-100 text-blue-800 text-sm font-medium';
    }
    


    labels.push(leitura.hora);
    valores.push(leitura.valor);

    if(labels.length > 20){

        labels.shift();
        valores.shift();

    }

    chart.update();

}

atualizarPainel();

setInterval(
    atualizarPainel,
    1000
);

</script>

</body>
</html>