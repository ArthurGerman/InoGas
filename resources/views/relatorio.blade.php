<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InoGas Dashboard</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
                    <a href="{{ route('painel') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-100">
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
                    <a href=""
                       class="flex items-center gap-3 bg-emerald-950 text-white px-4 py-3 rounded-lg">
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

        </header>

        <div class="p-10">

            <!-- Título -->
            <div class="mb-6">

                <h2 class="text-5xl font-bold text-emerald-950">
                    Painel de Relatórios
                </h2>

                <p class="text-gray-500 mt-2">
                    Acompanhe as tendências de concentração de gases ao longo do tempo.
                </p>

            </div>

            <!-- Gráfico -->
            <div
                class="bg-white rounded-xl shadow-sm p-6">

                <div class="flex justify-between items-center mb-6">

                    <h3 class="text-xl font-semibold">
                        Resumo de concentração de gases tóxicos
                    </h3>

                    <select
                        id="filtro-periodo"
                        class="px-4 py-2 border border-gray-300 rounded-lg font-medium text-emerald-950 focus:outline-none focus:border-emerald-950">
                        <option value="hora">Última Hora (1H)</option>
                        <option value="dia" selected>Últimas 24H</option>
                        <option value="semana">Última Semana</option>
                        <option value="mes">Último Mês</option>
                        <option value="ano">Último Ano</option>
                    </select>

                </div>

                <canvas
                    id="grafico"
                    height="110">
                </canvas>

            </div>

        </div>

    </main>

</div>

</body>
</html>