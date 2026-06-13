<!DOCTYPE html>

<html lang="pt-BR"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Sincronização com Telegram - Inogás</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&amp;family=Libertinus+Serif:wght@400;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
<script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            serif: ['"Libertinus Serif"', 'serif'],
            mono: ['"JetBrains Mono"', 'monospace'],
          },
          colors: {
            brand: {
              50: '#F2F4F6',
              100: '#F7F9FB',
              200: '#E4E9E6',
              300: '#C1C8C2',
              400: '#A5D0B9',
              500: '#414844',
              600: '#191C1E',
              700: '#1B4332',
              800: '#012D1D',
            },
            alert: {
              critical: '#BA1A1A',
              warning: '#006399',
            }
          }
        }
      }
    }
  </script>
<style data-purpose="custom-styles">
    body {
      font-family: 'Libertinus Serif', serif;
      background-color: #F7F9FB;
      color: #191C1E;
    }
    .font-mono {
      font-family: 'JetBrains Mono', monospace;
    }
    .toggle-checkbox:checked {
      right: 0;
      border-color: #1B4332;
    }
    .toggle-checkbox:checked + .toggle-label {
      background-color: #1B4332;
    }
    .toggle-checkbox-red:checked {
      border-color: #BA1A1A;
    }
    .toggle-checkbox-red:checked + .toggle-label {
      background-color: #BA1A1A;
    }
    .toggle-checkbox-blue:checked {
      border-color: #006399;
    }
    .toggle-checkbox-blue:checked + .toggle-label {
      background-color: #006399;
    }
  </style>
</head>
<body class="flex h-screen overflow-hidden antialiased">
<!-- BEGIN: Sidebar -->
<aside class="w-[445px] bg-brand-50 border-r border-brand-300 flex flex-col justify-between hidden md:flex shrink-0 h-full">
<div>
<div class="p-8 pb-12">
<h1 class="text-[44px] font-bold text-brand-700 leading-tight">Sensor MQ2-001</h1>
<p class="text-xl text-brand-500 mt-2">Zona A - Setor Norte</p>
</div>
<nav class="flex flex-col gap-2 px-4">
<a class="flex items-center gap-4 px-6 py-4 text-xl text-brand-600 hover:bg-brand-200 rounded-xl transition-colors" href="#">
<i class="fa-solid fa-border-all w-6 text-center"></i> Painel
        </a>
<a class="flex items-center gap-4 px-6 py-4 text-xl text-brand-600 hover:bg-brand-200 rounded-xl transition-colors" href="#">
<i class="fa-solid fa-podcast w-6 text-center"></i> Matriz de Sensores
        </a>
<a class="flex items-center gap-4 px-6 py-4 text-xl text-brand-600 hover:bg-brand-200 rounded-xl transition-colors" href="#">
<i class="fa-solid fa-clock-rotate-left w-6 text-center"></i> Histórico de Alertas
        </a>
<a class="flex items-center gap-4 px-6 py-4 text-xl text-brand-600 hover:bg-brand-200 rounded-xl transition-colors" href="#">
<i class="fa-solid fa-chart-simple w-6 text-center"></i> Análises
        </a>
<a class="flex items-center gap-4 px-6 py-4 text-xl text-white bg-brand-700 rounded-xl font-semibold shadow-md" href="#">
<i class="fa-regular fa-paper-plane w-6 text-center"></i> Sincronização Telegram
        </a>
</nav>
</div>
<div class="p-8 border-t border-brand-300 flex flex-col gap-4">
<button class="w-full bg-brand-700 text-white font-bold text-xl py-4 rounded-xl hover:bg-opacity-90 transition-opacity">
        Exportar Relatório
      </button>
<div class="flex flex-col gap-2 mt-4 text-brand-500 text-sm">
<div class="flex items-center gap-2"><i class="fa-regular fa-circle-check"></i> Saúde do Sistema</div>
<div class="flex items-center gap-2"><i class="fa-regular fa-circle-question"></i> Suporte</div>
</div>
</div>
</aside>
<!-- END: Sidebar -->
<!-- BEGIN: Main Content -->
<main class="flex-1 flex flex-col h-full overflow-hidden bg-brand-100">
<!-- BEGIN: Top Navigation -->
<header class="h-[88px] bg-white border-b border-brand-300 flex items-center justify-between px-12 shrink-0">
<div class="flex items-center gap-3 text-brand-700 font-bold text-[32px]">
<i class="fa-brands fa-envira text-4xl"></i> Inogas
      </div>
<div class="flex items-center gap-6 text-brand-600">
<button class="hover:text-brand-700 transition-colors"><i class="fa-regular fa-user text-2xl"></i></button>
<button class="hover:text-brand-700 transition-colors"><i class="fa-solid fa-gear text-2xl"></i></button>
</div>
</header>
<!-- END: Top Navigation -->
<!-- BEGIN: Page Content Scrollable Area -->
<div class="flex-1 overflow-y-auto p-12 lg:p-16">
<!-- Page Header -->
<div class="max-w-6xl mx-auto mb-12">
<h2 class="text-4xl font-bold text-brand-600 mb-4">Sincronização com Telegram</h2>
<p class="text-xl text-brand-500 max-w-4xl">Gerencie as notificações e sincronização de alertas via Telegram para garantir respostas rápidas a anomalias no ambiente industrial.</p>
</div>
<div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8">
<!-- BEGIN: Bot Configuration Card (Span 8) -->
<div class="lg:col-span-8 bg-white border border-brand-300 rounded-[12px] p-8 shadow-sm">
<div class="flex justify-between items-start mb-8 pb-6 border-b border-brand-300">
<h3 class="text-[28px] font-bold text-brand-600 flex items-center gap-3">
<i class="fa-solid fa-robot text-brand-700"></i> Configuração do Bot
            </h3>
<span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-mono font-bold text-brand-800 bg-[rgba(165,208,185,0.2)] border border-[rgba(165,208,185,0.5)]">
<span class="w-2 h-2 rounded-full bg-brand-700"></span> Conectado
            </span>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
<div>
<label class="block text-brand-600 text-lg mb-2">Token do Bot</label>
<input class="w-full bg-brand-50 border-brand-300 text-brand-600 rounded-[8px] p-4 font-mono text-sm focus:ring-brand-700 focus:border-brand-700" readonly="" type="text" value="123456789:ABCDEFGHIJKLMNOPQRSTUVWXYZ"/>
<p class="text-brand-500 text-sm mt-2">Obtido de @BotFather</p>
</div>
<div>
<label class="block text-brand-600 text-lg mb-2">ID do Chat / ID do Grupo</label>
<input class="w-full bg-brand-50 border-brand-300 text-brand-600 rounded-[8px] p-4 font-mono text-sm focus:ring-brand-700 focus:border-brand-700" type="text" value="-100987654321"/>
<p class="text-brand-500 text-sm mt-2">Canal de destino para alertas</p>
</div>
</div>
<div class="flex justify-end gap-4 mt-12 pt-6">
<button class="px-8 py-3 rounded-[8px] border border-brand-300 text-brand-600 text-lg font-semibold hover:bg-brand-50 transition-colors">Cancelar</button>
<button class="px-8 py-3 rounded-[8px] bg-brand-700 text-white text-lg font-semibold hover:bg-opacity-90 transition-opacity">Salvar Configuração</button>
</div>
</div>
<!-- END: Bot Configuration Card -->
<!-- BEGIN: Connection Test Card (Span 4) -->
<div class="lg:col-span-4 bg-white border border-brand-300 rounded-[12px] p-8 shadow-sm flex flex-col">
<h3 class="text-2xl font-bold text-brand-600 flex items-center gap-3 mb-4">
<i class="fa-solid fa-satellite-dish text-brand-700"></i> Teste de Conexão
          </h3>
<p class="text-brand-500 text-lg mb-6">Verifique a integração enviando um payload de teste para o ID do Chat do Telegram configurado.</p>
<div class="bg-brand-50 border border-brand-300 rounded-[8px] p-6 mb-8 flex-1 flex items-center justify-center">
<code class="font-mono text-brand-600 text-sm">{Mensagem Teste}</code>
</div>
<button class="w-full px-6 py-4 rounded-[8px] bg-brand-700 text-white text-lg font-semibold hover:bg-opacity-90 transition-opacity flex justify-center items-center gap-2">
<i class="fa-regular fa-paper-plane"></i> Enviar Mensagem de Teste
          </button>
</div>
<!-- END: Connection Test Card -->
<!-- BEGIN: Notification Rules Card (Span 12) -->
<div class="lg:col-span-12 bg-white border border-brand-300 rounded-[12px] p-8 shadow-sm mt-4">
<div class="mb-8 pb-6 border-b border-brand-300">
<h3 class="text-[28px] font-bold text-brand-600 flex items-center gap-3">
<i class="fa-solid fa-sliders text-brand-700"></i> Regras de Notificação
            </h3>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
<!-- Rule 1: Critical -->
<div class="border border-brand-200 rounded-[8px] p-6 flex flex-col h-full bg-white relative overflow-hidden group hover:border-alert-critical/50 transition-colors">
<div class="flex items-center justify-between mb-4">
<h4 class="text-2xl font-bold text-brand-600 flex items-center gap-2">
<span class="w-3 h-3 rounded-full bg-alert-critical"></span> Alertas Críticos
                </h4>
<div class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
<input checked="" class="toggle-checkbox toggle-checkbox-red absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer z-10" id="toggle-critical" name="toggle" type="checkbox"/>
<label class="toggle-label block overflow-hidden h-6 rounded-full bg-brand-300 cursor-pointer" for="toggle-critical"></label>
</div>
</div>
<p class="text-brand-500 text-xl leading-relaxed">Transmissão imediata para níveis perigosos de gás (ex., MQ-2 &gt; 800ppm).</p>
</div>
<!-- Rule 2: Warning -->
<div class="border border-brand-200 rounded-[8px] p-6 flex flex-col h-full bg-white relative overflow-hidden group hover:border-alert-warning/50 transition-colors">
<div class="flex items-center justify-between mb-4">
<h4 class="text-2xl font-bold text-brand-600 flex items-center gap-2">
<span class="w-3 h-3 rounded-full bg-alert-warning"></span> Alertas de Aviso
                </h4>
<div class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
<input checked="" class="toggle-checkbox toggle-checkbox-blue absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer z-10" id="toggle-warning" name="toggle" type="checkbox"/>
<label class="toggle-label block overflow-hidden h-6 rounded-full bg-brand-300 cursor-pointer" for="toggle-warning"></label>
</div>
</div>
<p class="text-brand-500 text-xl leading-relaxed">Notificar quando os parâmetros tenderem a limites perigosos.</p>
</div>
<!-- Rule 3: Health -->
<div class="border border-brand-200 rounded-[8px] p-6 flex flex-col h-full bg-white relative overflow-hidden group hover:border-brand-400/50 transition-colors">
<div class="flex items-center justify-between mb-4">
<h4 class="text-2xl font-bold text-brand-600 flex items-center gap-2">
<span class="w-3 h-3 rounded-full bg-brand-400"></span> Saúde do Sistema
                </h4>
<div class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
<input class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer z-10" id="toggle-health" name="toggle" type="checkbox"/>
<label class="toggle-label block overflow-hidden h-6 rounded-full bg-brand-300 cursor-pointer" for="toggle-health"></label>
</div>
</div>
<p class="text-brand-500 text-xl leading-relaxed">Resumos diários e lembretes de calibração de sensores.</p>
</div>
</div>
</div>
<!-- END: Notification Rules Card -->
<!-- BEGIN: Sync Log Table (Span 12) -->
<div class="lg:col-span-12 bg-white border border-brand-300 rounded-[12px] p-8 shadow-sm mt-4 mb-24">
<div class="flex justify-between items-center mb-8 pb-6 border-b border-brand-300">
<h3 class="text-[28px] font-bold text-brand-600 flex items-center gap-3">
<i class="fa-solid fa-clock-rotate-left text-brand-700"></i> Transmissões Recentes
            </h3>
<button class="text-brand-700 font-semibold text-lg flex items-center gap-2 hover:underline">
<i class="fa-solid fa-rotate-right"></i> Atualizar Registro
            </button>
</div>
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-brand-50 text-brand-600 font-bold border-b border-brand-300">
<th class="py-4 px-6 font-mono text-sm uppercase tracking-wider">Data/Hora</th>
<th class="py-4 px-6 font-mono text-sm uppercase tracking-wider">Tipo</th>
<th class="py-4 px-6 font-mono text-sm uppercase tracking-wider">Prévia da Mensagem</th>
<th class="py-4 px-6 font-mono text-sm uppercase tracking-wider">Status</th>
</tr>
</thead>
<tbody class="text-brand-600 text-lg divide-y divide-brand-200">
<!-- Row 1 -->
<tr class="hover:bg-brand-50 transition-colors">
<td class="py-5 px-6 font-mono text-sm">2023-10-27 10:45:02</td>
<td class="py-5 px-6">
<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md text-xs font-mono font-bold bg-gray-200 text-gray-700">
<i class="fa-solid fa-vial-circle-check text-[10px]"></i> Teste
                    </span>
</td>
<td class="py-5 px-6 font-mono text-sm truncate max-w-[300px]" title='{"event": "test_ping", "source": "Inogas_A"}'>
                    {"event": "test_ping", "source": "Inogas_A"}
                  </td>
<td class="py-5 px-6">
<span class="flex items-center gap-2 text-brand-700 text-sm font-semibold">
<i class="fa-regular fa-circle-check"></i> Entregue
                    </span>
</td>
</tr>
<!-- Row 2 -->
<tr class="hover:bg-brand-50 transition-colors">
<td class="py-5 px-6 font-mono text-sm">2023-10-26 14:22:10</td>
<td class="py-5 px-6">
<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md text-xs font-mono font-bold bg-red-100 text-alert-critical">
<span class="w-1.5 h-1.5 rounded-full bg-alert-critical"></span> Crítico
                    </span>
</td>
<td class="py-5 px-6 font-mono text-sm truncate max-w-[400px]" title="🚨 ALTO VOC DETECTADO: 850ppm no Setor B. Inspeção imediata necessária.">
                    🚨 ALTO VOC DETECTADO: 850ppm no Setor B. Inspeção imediata necessária.
                  </td>
<td class="py-5 px-6">
<span class="flex items-center gap-2 text-brand-700 text-sm font-semibold">
<i class="fa-regular fa-circle-check"></i> Entregue
                    </span>
</td>
</tr>
<!-- Row 3 -->
<tr class="hover:bg-brand-50 transition-colors">
<td class="py-5 px-6 font-mono text-sm">2023-10-26 08:00:00</td>
<td class="py-5 px-6">
<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md text-xs font-mono font-bold bg-blue-100 text-alert-warning">
<span class="w-1.5 h-1.5 rounded-full bg-alert-warning"></span> Aviso
                    </span>
</td>
<td class="py-5 px-6 font-mono text-sm truncate max-w-[400px]" title="⚠️ Níveis de PM2.5 subindo lentamente. Atual: 35µg/m³. Monitore a ventilação.">
                    ⚠️ Níveis de PM2.5 subindo lentamente. Atual: 35µg/m³. Monitore a ventilação.
                  </td>
<td class="py-5 px-6">
<span class="flex items-center gap-2 text-brand-700 text-sm font-semibold">
<i class="fa-regular fa-circle-check"></i> Entregue
                    </span>
</td>
</tr>
</tbody>
</table>
</div>
</div>
<!-- END: Sync Log Table -->
</div>
</div>
<!-- END: Page Content Scrollable Area -->
</main>
<!-- END: Main Content -->
</body></html>