<!DOCTYPE html>

<html lang="pt-BR"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Análise de Dados - Inogas</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
<style>
    /* 
      We cannot reliably import 'Libertinus Serif' from standard web font providers like Google Fonts. 
      Falling back to a generic serif that resembles it closely for demonstration, 
      while applying JetBrains Mono as requested.
    */
    :root {
      --color-primary-dark: #012D1D;
      --color-primary: #1B4332;
      --color-secondary-blue: #006399;
      --color-surface: #F7F9FB;
      --color-sidebar: #F2F4F6;
      --color-border: #C1C8C2;
      --color-text-main: #333333;
      --color-text-muted: #666666;
      --color-danger: #D92D20;
      --color-danger-bg: #FEE4E2;
      --color-success: #027A48;
      --color-success-bg: #D1FADF;
    }

    body {
      font-family: 'Times New Roman', Times, serif; /* Fallback for Libertinus Serif */
      background-color: var(--color-surface);
      color: var(--color-text-main);
      margin: 0;
      padding: 0;
      display: flex;
      height: 100vh;
      overflow: hidden;
    }

    .font-mono {
      font-family: 'JetBrains Mono', monospace;
    }

    .sidebar {
      width: 445px;
      background-color: var(--color-sidebar);
      border-right: 1px solid var(--color-border);
      display: flex;
      flex-direction: column;
      flex-shrink: 0;
    }

    .main-content {
      flex: 1;
      display: flex;
      flex-direction: column;
      overflow-y: auto;
    }

    .top-bar {
      height: 80px;
      background-color: var(--color-surface);
      border-bottom: 1px solid var(--color-border);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 40px;
      flex-shrink: 0;
    }

    .nav-item {
      display: flex;
      align-items: center;
      padding: 16px 24px;
      margin: 4px 16px;
      border-radius: 8px;
      color: var(--color-text-main);
      text-decoration: none;
      font-size: 20px;
      transition: background-color 0.2s;
    }

    .nav-item:hover {
      background-color: rgba(0,0,0,0.05);
    }

    .nav-item.active {
      background-color: var(--color-primary-dark);
      color: white;
    }

    .nav-item svg {
      margin-right: 16px;
      width: 24px;
      height: 24px;
    }

    .card {
      background-color: white;
      border: 1px solid var(--color-border);
      border-radius: 12px;
      padding: 32px;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .table-header {
      font-size: 12px;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      color: var(--color-text-muted);
      border-bottom: 1px solid var(--color-border);
    }

    .badge {
      padding: 4px 12px;
      border-radius: 9999px;
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      font-family: 'JetBrains Mono', monospace;
    }
    
    .badge-success {
      background-color: var(--color-success-bg);
      color: var(--color-success);
    }
    
    .badge-danger {
      background-color: var(--color-danger-bg);
      color: var(--color-danger);
    }

    /* Custom Chart Styles */
    .bar-chart-container {
      height: 300px;
      display: flex;
      align-items: flex-end;
      gap: 16px;
      padding-top: 40px;
      position: relative;
    }

    .chart-bar {
      flex: 1;
      background-color: rgba(1, 45, 29, 0.8); /* Dark green with 80% opacity */
      border-radius: 4px 4px 0 0;
      min-height: 10%;
    }

    .alert-line {
      position: absolute;
      left: 0;
      right: 0;
      top: 50%; /* Approximate position */
      border-top: 1px dashed var(--color-danger);
      z-index: 10;
    }

    .alert-text {
      position: absolute;
      right: 0;
      top: calc(50% - 20px);
      color: var(--color-danger);
      font-size: 12px;
      background: white;
      padding-left: 8px;
    }

    /* Comparison Bar Styles */
    .comp-bar-container {
      height: 24px;
      width: 100%;
      background-color: var(--color-secondary-blue);
      border-radius: 12px;
      overflow: hidden;
      display: flex;
    }

    .comp-bar-inner {
      background-color: var(--color-primary);
      height: 100%;
    }

  </style>
</head>
<body>
<!-- BEGIN: Sidebar -->
<aside class="sidebar py-8 flex flex-col">
<div class="px-8 mb-12">
<h1 class="text-5xl font-bold text-[#012D1D] mb-2">Sensor MQ2-001</h1>
<p class="text-xl text-[#666] font-mono">Zona A - Setor Norte</p>
</div>
<nav class="flex-1">
<a class="nav-item" href="#">
<svg fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        Painel
      </a>
<a class="nav-item" href="#">
<svg fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        Matriz de Sensores
      </a>
<a class="nav-item" href="#">
<svg fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        Histórico de Alertas
      </a>
<a class="nav-item active" href="#">
<svg fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        Análises
      </a>
<a class="nav-item" href="#">
<svg fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        Sincronização Telegram
      </a>
</nav>
<div class="px-8 mt-auto flex flex-col gap-4">
<button class="bg-[#012D1D] text-white py-4 px-6 rounded-lg text-2xl font-bold w-full hover:bg-opacity-90 transition">
        Exportar Relatório
      </button>
<div class="border-t border-[#C1C8C2] pt-4 flex flex-col gap-3">
<a class="flex items-center text-[#666] hover:text-[#333] transition" href="#">
<svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
<span class="text-sm">Saúde do Sistema</span>
</a>
<a class="flex items-center text-[#666] hover:text-[#333] transition" href="#">
<svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
<span class="text-sm">Suporte</span>
</a>
</div>
</div>
</aside>
<!-- END: Sidebar -->
<!-- BEGIN: Main Content -->
<main class="main-content">
<!-- BEGIN: Top Bar -->
<header class="top-bar">
<div class="flex items-center gap-3 text-[#012D1D]">
<svg class="w-8 h-8" fill="currentColor" viewbox="0 0 24 24">
<path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4Z"></path>
<path d="M12 18C8.68629 18 6 15.3137 6 12C6 8.68629 8.68629 6 12 6C15.3137 6 18 8.68629 18 12C18 15.3137 15.3137 18 12 18ZM12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8Z"></path>
</svg>
<span class="text-5xl font-bold">Inogas</span>
</div>
<div class="flex items-center gap-6 text-[#333]">
<button class="hover:text-[#012D1D] transition">
<svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
</button>
<button class="hover:text-[#012D1D] transition">
<svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
</button>
</div>
</header>
<!-- END: Top Bar -->
<div class="p-10 flex-1 overflow-y-auto">
<!-- BEGIN: Page Header -->
<div class="flex justify-between items-end mb-10">
<div>
<h2 class="text-4xl font-bold text-[#333] mb-2">Análise de Dados</h2>
<p class="text-[#666] text-lg">Insights abrangentes de monitoramento ambiental.</p>
</div>
<div>
<button class="bg-white border border-[#C1C8C2] py-2 px-4 rounded-md shadow-sm flex items-center gap-2 hover:bg-gray-50 transition font-mono text-sm">
<svg class="w-4 h-4 text-[#666]" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            Últimos 30 Dias
            <svg class="w-4 h-4 ml-2 text-[#666]" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
</button>
</div>
</div>
<!-- END: Page Header -->
<!-- BEGIN: Bento Grid -->
<div class="flex flex-col gap-6">
<!-- Top Full-Width Card: Global AQI Trends -->
<div class="card">
<div class="flex justify-between items-center mb-6 pb-4 border-b border-[#C1C8C2]">
<h3 class="text-2xl font-bold text-[#333] flex items-center gap-2">
<svg class="w-6 h-6 text-[#666]" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
              Tendências do Índice Global de Qualidade do Ar (AQI)
            </h3>
<button class="text-sm font-mono font-semibold text-[#666] hover:text-[#333] tracking-widest uppercase">
              Ver Detalhes
            </button>
</div>
<div class="bar-chart-container">
<div class="alert-line"></div>
<span class="alert-text font-mono">Limite de Alerta</span>
<!-- Placeholder bars to resemble the chart -->
<div class="chart-bar" style="height: 60%"></div>
<div class="chart-bar" style="height: 62%"></div>
<div class="chart-bar" style="height: 40%"></div>
<div class="chart-bar" style="height: 75%"></div>
<div class="chart-bar" style="height: 65%"></div>
<div class="chart-bar" style="height: 35%"></div>
<div class="chart-bar" style="height: 45%"></div>
<div class="chart-bar" style="height: 38%"></div>
<div class="chart-bar" style="height: 75%"></div>
<div class="chart-bar" style="height: 50%"></div>
<div class="chart-bar" style="height: 55%"></div>
<div class="chart-bar" style="height: 75%"></div>
<div class="chart-bar" style="height: 70%"></div>
<div class="chart-bar" style="height: 45%"></div>
<div class="chart-bar" style="height: 70%"></div>
<div class="chart-bar" style="height: 78%"></div>
<div class="chart-bar" style="height: 35%"></div>
<div class="chart-bar" style="height: 55%"></div>
<div class="chart-bar" style="height: 48%"></div>
<div class="chart-bar" style="height: 52%"></div>
<div class="chart-bar" style="height: 45%"></div>
<div class="chart-bar" style="height: 62%"></div>
<div class="chart-bar" style="height: 55%"></div>
<div class="chart-bar" style="height: 75%"></div>
<div class="chart-bar" style="height: 52%"></div>
<div class="chart-bar" style="height: 65%"></div>
<div class="chart-bar" style="height: 45%"></div>
<div class="chart-bar" style="height: 75%"></div>
</div>
</div>
<!-- Bottom Cards Row -->
<div class="grid grid-cols-2 gap-6">
<!-- Left Bottom Card: Sensor Performance Matrix -->
<div class="card">
<h3 class="text-2xl font-bold text-[#333] mb-6">Matriz de Desempenho dos Sensores</h3>
<table class="w-full text-left border-collapse">
<thead>
<tr class="table-header">
<th class="py-3 font-mono">Módulo</th>
<th class="py-3 font-mono">Tempo de<br/>Atividade</th>
<th class="py-3 font-mono">Confiabilidade</th>
<th class="py-3 font-mono text-right">Status</th>
</tr>
</thead>
<tbody class="divide-y divide-[#C1C8C2]">
<tr>
<td class="py-4 font-mono font-medium text-[#333]">MQ2-Z1</td>
<td class="py-4 font-mono text-[#666]">99.9%</td>
<td class="py-4 text-[#666]">Alta</td>
<td class="py-4 text-right"><span class="badge badge-success">ATIVO</span></td>
</tr>
<tr>
<td class="py-4 font-mono font-medium text-[#333]">MQ2-Z2</td>
<td class="py-4 font-mono text-[#666]">98.5%</td>
<td class="py-4 text-[#666]">Alta</td>
<td class="py-4 text-right"><span class="badge badge-success">ATIVO</span></td>
</tr>
<tr>
<td class="py-4 font-mono font-medium text-[#333]">MQ2-Z3</td>
<td class="py-4 font-mono text-[#D92D20]">82.1%</td>
<td class="py-4 text-[#D92D20]">Degradada</td>
<td class="py-4 text-right"><span class="badge badge-danger">CALIBRAR</span></td>
</tr>
</tbody>
</table>
</div>
<!-- Right Bottom Card: Zone Comparison -->
<div class="card border-t-4 border-t-[#006399]">
<div class="flex justify-between items-center mb-8">
<h3 class="text-2xl font-bold text-[#333]">Comparação de Zonas</h3>
<div class="flex items-center gap-2 bg-[#F2F4F6] rounded-md p-1 font-mono text-xs">
<span class="bg-white shadow-sm rounded px-2 py-1">Zona A</span>
<span class="text-[#666] px-1">vs</span>
<span class="bg-white shadow-sm rounded px-2 py-1">Zona B</span>
</div>
</div>
<div class="flex flex-col gap-8">
<!-- Comparison 1 -->
<div class="flex items-center gap-4">
<span class="w-24 text-right text-sm text-[#666]">AQI Médio</span>
<div class="flex-1">
<div class="comp-bar-container">
<div class="comp-bar-inner" style="width: 55%;"></div>
</div>
</div>
</div>
<!-- Comparison 2 -->
<div class="flex items-center gap-4">
<span class="w-24 text-right text-sm text-[#666]">Pico C4H10</span>
<div class="flex-1">
<div class="comp-bar-container">
<div class="comp-bar-inner" style="width: 80%;"></div>
</div>
</div>
</div>
</div>
<div class="mt-8 flex justify-center gap-6 text-sm font-mono text-[#666]">
<div class="flex items-center gap-2">
<span class="w-3 h-3 bg-[#1B4332] rounded-sm"></span> Zona A
              </div>
<div class="flex items-center gap-2">
<span class="w-3 h-3 bg-[#006399] rounded-sm"></span> Zona B
              </div>
</div>
</div>
</div>
</div>
<!-- END: Bento Grid -->
</div>
</main>
<!-- END: Main Content -->
</body></html>