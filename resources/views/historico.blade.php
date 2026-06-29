<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Histórico de Alertas</title>

    @vite(['resources/css/app.css'])
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
                    <a href=""
                       class="flex items-center gap-3 bg-emerald-950 text-white px-4 py-3 rounded-lg">
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

            <h2 class="text-5xl font-bold text-emerald-950">
                Histórico de Alertas
            </h2>

            <p class="text-gray-500 mt-2">
                Consulte todas as medições críticas registradas pelo sensor.
            </p>

            <!-- Filtros -->

            <div class="bg-white rounded-2xl shadow mt-8 p-6">

                <h3 class="text-xl font-semibold mb-6">
                    Filtrar período
                </h3>

                <form
                    method="GET"
                    class="grid grid-cols-1 md:grid-cols-4 gap-4">

                    <div>

                        <label class="text-sm text-gray-500">
                            Data Inicial
                        </label>

                        <input
                            type="date"
                            name="inicio"
                            value="{{ request('inicio') }}"
                            class="mt-2 w-full border rounded-lg p-3">

                    </div>

                    <div>

                        <label class="text-sm text-gray-500">
                            Data Final
                        </label>

                        <input
                            type="date"
                            name="fim"
                            value="{{ request('fim') }}"
                            class="mt-2 w-full border rounded-lg p-3">

                    </div>

                    <div class="flex items-end">

                        <button
                            class="w-full bg-emerald-950 text-white rounded-lg p-3 hover:bg-emerald-900">

                            Filtrar

                        </button>

                    </div>

                    <div class="flex items-end">

                        <a
                            href="{{ route('historico') }}"
                            class="w-full text-center border rounded-lg p-3 hover:bg-gray-100">

                            Limpar

                        </a>

                    </div>

                </form>

            </div>

            <!-- Tabela -->

            <div class="bg-white rounded-2xl shadow mt-8 overflow-hidden">

                <div class="flex justify-between items-center px-6 py-5 border-b">

                    <h3 class="text-xl font-semibold">

                        Alertas Registrados

                    </h3>

                    <button
                        class="border px-5 py-2 rounded-lg hover:bg-gray-100">

                        Exportar PDF

                    </button>

                </div>

                <table class="w-full">

                    <thead class="bg-gray-50">

                    <tr>

                        <th class="text-left p-4">
                            Data/Hora
                        </th>

                        <th class="text-left p-4">
                            Concentração Máxima (PPM)
                        </th>

                        <th class="text-left p-4">
                            Nível
                        </th>

                        <th class="text-left p-4">
                            Status
                        </th>

                    </tr>

                    </thead>

                    <tbody>

                    @forelse($alertas as $alerta)
                        <tr class="border-t">
                            <td class="p-4">{{ $alerta->created_at->format('d/m/Y H:i:s') }}</td>
                            <td class="p-4 font-semibold">{{ $alerta->valor }}</td>
                            <td class="p-4">
                                <span class="px-3 py-1 rounded-full text-sm bg-red-100 text-red-700">
                                    Alerta
                                </span>
                            </td>
                            <td class="p-4">{{ $alerta->status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-500">
                                Nenhum alerta de gás registrado.
                            </td>
                        </tr>
                    @endforelse

                    </tbody>

                </table>

                <div class="flex justify-between items-center px-6 py-5 border-t">

                    <span class="text-gray-500">

                        Mostrando {{ $alertas->firstItem() }}–{{ $alertas->lastItem() }} de {{ $alertas->total() }} registros

                    </span>

                    <div class="mt-6">
                        {{ $alertas->onEachSide(1)->links() }}
                    </div>

                </div>

            </div>

        </div>

    </main>

</div>

</body>
</html>