<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>InoGas - Histórico de alertas</title>
    <style>
        @page { margin: 28px 30px 40px 30px; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; color: #1b2430; }
        h1 { font-size: 18px; margin: 0 0 4px 0; }
        .sub { color: #5a6678; margin: 0 0 14px 0; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; background: #e9eef5; padding: 6px 7px; border-bottom: 1px solid #b9c3d1; font-size: 9px; }
        td { padding: 6px 7px; border-bottom: 1px solid #dde3ec; vertical-align: top; }
        .num { text-align: right; }
        .teste { color: #8a5a00; }
        .aviso { margin-top: 14px; padding: 8px 10px; border: 1px solid #c9d2df; background: #f6f8fb; color: #3d4a5c; font-size: 9px; }
        .vazio { padding: 22px; text-align: center; color: #5a6678; }
        .rodape { position: fixed; bottom: -22px; left: 0; right: 0; text-align: right; font-size: 8px; color: #7a8698; }
        .rodape:after { content: "Página " counter(page); }
    </style>
</head>
<body>
    <h1>InoGas · Histórico de alertas</h1>
    <p class="sub">
        Período: {{ $periodo }} · Gerado em {{ $geradoEm }} por {{ $usuario }} · {{ $total }} {{ $total === 1 ? 'alerta' : 'alertas' }}@if ($cortado) (mostrando os {{ $limite }} mais recentes)@endif
    </p>

    @if (count($linhas) === 0)
        <div class="vazio">Nenhum alerta registrado neste período.</div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Início</th>
                    <th>Duração</th>
                    <th>Local</th>
                    <th class="num">Pico ({{ $unidade }})</th>
                    <th>Nível</th>
                    <th class="num">Confirmações</th>
                    <th>Silenciado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($linhas as $l)
                    <tr>
                        <td>{{ $l['inicio'] }}</td>
                        <td>{{ $l['duracao'] }}</td>
                        <td>{{ $l['local'] }}</td>
                        <td class="num">{{ $l['pico'] }}</td>
                        <td>@if ($l['teste'])<span class="teste">Teste</span>@else{{ $l['nivel'] }}@endif</td>
                        <td class="num">{{ $l['confirmacoes'] }}</td>
                        <td>{{ $l['silenciado'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="aviso">
        O InoGas é um protótipo de monitoramento e não é um detector certificado. Os valores são do sinal do sensor,
        sem calibração, e este relatório não comprova a segurança de nenhum ambiente.
    </div>

    <div class="rodape"></div>
</body>
</html>
