<!doctype html>
<html>
<head>
  <meta charset="utf-8"/>
  <style>
    body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; }
    table { width:100%; border-collapse: collapse; }
    th, td { border: 1px solid #ddd; padding:6px; text-align:left; }
    th { background:#f2f2f2; }
    h1 { font-size:18px; margin-bottom:8px; }
  </style>
</head>
<body>
  <h1>Histórico de Alertas</h1>
  <table>
    <thead>
      <tr>
        <th>Data/Hora</th>
        <th>Concentração Máxima (PPM)</th>
        <th>Nível</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach($alertas as $alerta)
        <tr>
          <td>{{ $alerta->created_at->format('d/m/Y H:i:s') }}</td>
          <td>{{ $alerta->valor }}</td>
          <td>Alerta</td>
          <td>{{ $alerta->status }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>