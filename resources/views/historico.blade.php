<!DOCTYPE html>

<html lang="pt-BR"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Inogás - Histórico de Alertas</title>
<!-- Load Google Fonts -->
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&amp;display=swap" rel="stylesheet"/>
<!-- Libertinus Serif is not on Google Fonts, using a standard serif fallback but trying to approximate -->
<link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&amp;family=Noto+Serif:ital,wght@0,400..900;1,400..900&amp;display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            brand: {
              dark: '#012D1D',
              green: '#1B4332',
              bg: '#F7F9FB',
              sidebar: '#F2F4F6',
              textPrimary: '#191C1E',
              textSecondary: '#414844',
              border: '#C1C8C2',
              tableBorder: '#E0E3E5',
              alertRed: '#BA1A1A',
              alertRedBg: '#FFDAD6',
              alertRedText: '#93000A',
              infoBlue: '#006399',
              badgeGray: '#E0E3E5'
            }
          },
          fontFamily: {
            serif: ['"Noto Serif"', '"Libre Baskerville"', 'serif'],
            mono: ['"JetBrains Mono"', 'monospace']
          }
        }
      }
    }
  </script>
<style data-purpose="custom-utilities">
    /* Base font setting */
    body {
      font-family: "Noto Serif", serif;
      background-color: #ECEEF0;
    }
    
    /* Custom scrollbar for table if needed */
    .table-container::-webkit-scrollbar {
      width: 8px;
      height: 8px;
    }
    .table-container::-webkit-scrollbar-track {
      background: #f1f1f1; 
    }
    .table-container::-webkit-scrollbar-thumb {
      background: #c1c8c2; 
      border-radius: 4px;
    }
    .table-container::-webkit-scrollbar-thumb:hover {
      background: #a1a8a2; 
    }
  </style>
</head>
<body class="antialiased min-h-screen flex text-brand-textPrimary overflow-hidden">
<!-- BEGIN: Sidebar -->
<aside class="w-[445px] bg-brand-sidebar border-r border-brand-border flex flex-col h-screen flex-shrink-0 z-20 relative">
<!-- Sidebar Header -->
<div class="pt-[52px] px-10 pb-10">
<h1 class="text-5xl font-bold text-brand-dark mb-2 tracking-tight">Sensor MQ2-001</h1>
<p class="text-xl text-brand-textSecondary">Zona A - Setor Norte</p>
</div>
<!-- Sidebar Navigation -->
<nav class="flex-1 px-6 space-y-2">
<!-- Painel -->
<a class="flex items-center gap-4 px-4 py-4 rounded-lg text-brand-textSecondary hover:bg-gray-200 transition-colors" href="#">
<svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
<span class="text-2xl">Painel</span>
</a>
<!-- Matriz de Sensores -->
<a class="flex items-center gap-4 px-4 py-4 rounded-lg text-brand-textSecondary hover:bg-gray-200 transition-colors" href="#">
<svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
<span class="text-2xl">Matriz de Sensores</span>
</a>
<!-- Histórico de Alertas (Active) -->
<a class="flex items-center gap-4 px-4 py-4 rounded-lg bg-brand-dark text-white transition-colors" href="#">
<svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
<span class="text-2xl">Histórico de Alertas</span>
</a>
<!-- Análises -->
<a class="flex items-center gap-4 px-4 py-4 rounded-lg text-brand-textSecondary hover:bg-gray-200 transition-colors" href="#">
<svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
<span class="text-2xl">Análises</span>
</a>
<!-- Sincronização Telegram -->
<a class="flex items-center gap-4 px-4 py-4 rounded-lg text-brand-textSecondary hover:bg-gray-200 transition-colors" href="#">
<svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
<span class="text-2xl">Sincronização<br/>Telegram</span>
</a>
</nav>
<!-- Sidebar Bottom -->
<div class="p-6 pb-10 space-y-6">
<button class="w-full bg-brand-dark text-white text-2xl py-4 rounded-lg font-medium hover:bg-opacity-90 transition-opacity">
        Exportar Relatório
      </button>
<div class="space-y-4 px-2">
<a class="flex items-center gap-3 text-brand-textSecondary hover:text-brand-dark" href="#">
<svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
<span class="text-sm">Saúde do Sistema</span>
</a>
<a class="flex items-center gap-3 text-brand-textSecondary hover:text-brand-dark" href="#">
<svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
<span class="text-sm">Suporte</span>
</a>
</div>
</div>
</aside>
<!-- END: Sidebar -->
<!-- BEGIN: Main Content -->
<main class="flex-1 flex flex-col h-screen bg-brand-bg relative overflow-hidden">
<!-- Top App Bar -->
<header class="h-[81px] bg-brand-bg border-b border-brand-border flex items-center justify-between px-10 flex-shrink-0">
<div class="flex items-center gap-3 text-brand-dark">
<!-- Leaf Icon -->
<svg class="w-8 h-8" fill="currentColor" viewbox="0 0 24 24">
<path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM11 19.93C7.05 19.43 4 16.05 4 12C4 7.95 7.05 4.57 11 4.07V19.93ZM13 4.07C16.95 4.57 20 7.95 20 12C20 16.05 16.95 19.43 13 19.93V4.07Z"></path>
<path d="M12 2C6.48 2 2 6.48 2 12S6.48 22 12 22 22 17.52 22 12 17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z" fill="#012D1D"></path>
<path d="M12 5.5c-3.59 0-6.5 2.91-6.5 6.5s2.91 6.5 6.5 6.5 6.5-2.91 6.5-6.5-2.91-6.5-6.5-6.5zm0 11c-2.48 0-4.5-2.02-4.5-4.5s2.02-4.5 4.5-4.5 4.5 2.02 4.5 4.5-2.02 4.5-4.5 4.5z" fill="#012D1D"></path>
</svg>
<span class="text-5xl font-bold tracking-tight">Inogás</span>
</div>
<div class="flex items-center gap-6 text-brand-textSecondary">
<button class="hover:text-brand-dark transition-colors">
<svg class="w-8 h-8" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
</button>
<button class="hover:text-brand-dark transition-colors">
<svg class="w-8 h-8" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
</button>
</div>
</header>
<!-- Scrollable Content Area -->
<div class="flex-1 overflow-y-auto px-10 py-10 space-y-8">
<!-- Page Header & Main CTA -->
<div class="flex justify-between items-start">
<div>
<h2 class="text-4xl font-bold text-brand-textPrimary mb-2">Histórico de Alertas</h2>
<p class="text-xl text-brand-textSecondary">Monitore e analise anomalias ambientais e acionamentos de sensores.</p>
</div>
<button class="bg-brand-green text-white px-6 py-3 rounded-lg text-2xl flex items-center gap-2 hover:bg-opacity-90 transition-opacity">
<svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
          Baixar CSV
        </button>
</div>
<!-- Stat Cards -->
<div class="grid grid-cols-3 gap-6">
<!-- Card 1 -->
<div class="bg-white rounded-xl shadow-sm border border-brand-border/40 p-6 flex flex-col justify-between h-[180px] relative overflow-hidden">
<div class="absolute top-0 left-0 w-full h-1 bg-brand-alertRed"></div>
<div class="flex justify-between items-start">
<h3 class="text-xl text-brand-textSecondary">Total de Alertas neste Mês</h3>
<svg class="w-6 h-6 text-brand-alertRed" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
</div>
<div>
<div class="text-5xl font-bold text-brand-textPrimary mb-2">142</div>
<div class="flex items-center text-sm text-brand-alertRed gap-1">
<svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
<span>+12% vs mês anterior</span>
</div>
</div>
</div>
<!-- Card 2 -->
<div class="bg-white rounded-xl shadow-sm border border-brand-border/40 p-6 flex flex-col justify-between h-[180px] relative overflow-hidden">
<div class="absolute top-0 left-0 w-full h-1 bg-brand-infoBlue"></div>
<div class="flex justify-between items-start">
<h3 class="text-xl text-brand-textSecondary">Zona Mais Afetada</h3>
<svg class="w-6 h-6 text-brand-infoBlue" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
</div>
<div>
<div class="text-4xl font-bold text-brand-textPrimary mb-1">Zona B</div>
<div class="text-sm text-brand-textSecondary leading-tight">
              Piso de Processamento - 48<br/>Alertas
            </div>
</div>
</div>
<!-- Card 3 -->
<div class="bg-white rounded-xl shadow-sm border border-brand-border/40 p-6 flex flex-col justify-between h-[180px] relative overflow-hidden">
<div class="absolute top-0 left-0 w-full h-1 bg-brand-dark"></div>
<div class="flex justify-between items-start">
<h3 class="text-xl text-brand-textSecondary">Tempo Médio de Resposta</h3>
<svg class="w-6 h-6 text-brand-dark" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
</div>
<div>
<div class="text-4xl font-bold text-brand-textPrimary mb-2">4m 12s</div>
<div class="flex items-center text-sm text-brand-dark gap-1">
<svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
<span>-30s de melhoria</span>
</div>
</div>
</div>
</div>
<!-- Filters & Controls -->
<div class="bg-white rounded-xl shadow-sm border border-brand-border p-4 flex gap-4 items-center">
<!-- Search -->
<div class="relative flex-1">
<div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
<svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
</div>
<input class="block w-full pl-11 pr-4 py-3 bg-brand-bg border border-brand-border rounded-lg text-brand-textSecondary focus:ring-brand-dark focus:border-brand-dark sm:text-lg" placeholder="Buscar ID do sensor ou zona..." type="text"/>
</div>
<!-- Dropdowns -->
<select class="block py-3 pl-4 pr-10 bg-brand-bg border border-brand-border rounded-lg text-brand-textSecondary focus:ring-brand-dark focus:border-brand-dark sm:text-lg appearance-none cursor-pointer">
<option>Últimos 7 Dias</option>
</select>
<select class="block py-3 pl-4 pr-10 bg-brand-bg border border-brand-border rounded-lg text-brand-textSecondary focus:ring-brand-dark focus:border-brand-dark sm:text-lg appearance-none cursor-pointer w-48">
<option>Todos os Gases</option>
</select>
<select class="block py-3 pl-4 pr-10 bg-brand-bg border border-brand-border rounded-lg text-brand-textSecondary focus:ring-brand-dark focus:border-brand-dark sm:text-lg appearance-none cursor-pointer">
<option>Todas as Gravidades</option>
</select>
</div>
<!-- Data Table -->
<div class="bg-white rounded-xl shadow-sm border border-brand-border overflow-hidden flex flex-col">
<div class="overflow-x-auto table-container">
<table class="min-w-full divide-y divide-brand-tableBorder text-left">
<thead class="bg-brand-sidebar">
<tr>
<th class="px-8 py-4 text-xs font-mono font-medium text-brand-textSecondary tracking-widest uppercase" scope="col">Data/Hora</th>
<th class="px-8 py-4 text-xs font-mono font-medium text-brand-textSecondary tracking-widest uppercase" scope="col">Sensor</th>
<th class="px-8 py-4 text-xs font-mono font-medium text-brand-textSecondary tracking-widest uppercase" scope="col">Concentração</th>
<th class="px-8 py-4 text-xs font-mono font-medium text-brand-textSecondary tracking-widest uppercase" scope="col">Status</th>
</tr>
</thead>
<tbody class="divide-y divide-brand-tableBorder bg-white text-lg text-brand-textPrimary">
<!-- Row 1 (Pendente) -->
<tr class="hover:bg-gray-50 transition-colors">
<td class="px-8 py-5 font-mono text-sm">2023-10-27 14:00</td>
<td class="px-8 py-5 font-serif">MQ2-001</td>
<td class="px-8 py-5 font-mono text-sm text-brand-alertRed font-bold">4.8 ppm</td>
<td class="px-8 py-5">
<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold font-mono tracking-widest bg-brand-alertRedBg text-brand-alertRedText">PENDENTE</span>
</td>
</tr>
<!-- Row 2 -->
<tr class="hover:bg-gray-50 transition-colors">
<td class="px-8 py-5 font-mono text-sm">2023-10-27 08:15</td>
<td class="px-8 py-5 font-serif">MQ2-001</td>
<td class="px-8 py-5 font-mono text-sm">2.1 ppm</td>
<td class="px-8 py-5">
<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold font-mono tracking-widest bg-brand-badgeGray text-brand-textSecondary">RESOLVIDO</span>
</td>
</tr>
<!-- Row 3 -->
<tr class="hover:bg-gray-50 transition-colors">
<td class="px-8 py-5 font-mono text-sm">2023-10-26 22:45</td>
<td class="px-8 py-5 font-serif">MQ2-002</td>
<td class="px-8 py-5 font-mono text-sm">1.5 ppm</td>
<td class="px-8 py-5">
<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold font-mono tracking-widest bg-brand-badgeGray text-brand-textSecondary">RESOLVIDO</span>
</td>
</tr>
<!-- Row 4 -->
<tr class="hover:bg-gray-50 transition-colors">
<td class="px-8 py-5 font-mono text-sm">2023-10-26 22:45</td>
<td class="px-8 py-5 font-serif">MQ2-001</td>
<td class="px-8 py-5 font-mono text-sm">1.5 ppm</td>
<td class="px-8 py-5">
<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold font-mono tracking-widest bg-brand-badgeGray text-brand-textSecondary">RESOLVIDO</span>
</td>
</tr>
<!-- Row 5 -->
<tr class="hover:bg-gray-50 transition-colors">
<td class="px-8 py-5 font-mono text-sm">2023-10-26 22:45</td>
<td class="px-8 py-5 font-serif">MQ2-003</td>
<td class="px-8 py-5 font-mono text-sm">1.5 ppm</td>
<td class="px-8 py-5">
<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold font-mono tracking-widest bg-brand-badgeGray text-brand-textSecondary">RESOLVIDO</span>
</td>
</tr>
<!-- Row 6 -->
<tr class="hover:bg-gray-50 transition-colors">
<td class="px-8 py-5 font-mono text-sm">2023-10-26 22:45</td>
<td class="px-8 py-5 font-serif">MQ2-003</td>
<td class="px-8 py-5 font-mono text-sm">1.5 ppm</td>
<td class="px-8 py-5">
<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold font-mono tracking-widest bg-brand-badgeGray text-brand-textSecondary">RESOLVIDO</span>
</td>
</tr>
<!-- Row 7 -->
<tr class="hover:bg-gray-50 transition-colors">
<td class="px-8 py-5 font-mono text-sm">2023-10-26 22:45</td>
<td class="px-8 py-5 font-serif">MQ2-002</td>
<td class="px-8 py-5 font-mono text-sm">1.5 ppm</td>
<td class="px-8 py-5">
<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold font-mono tracking-widest bg-brand-badgeGray text-brand-textSecondary">RESOLVIDO</span>
</td>
</tr>
<!-- Row 8 -->
<tr class="hover:bg-gray-50 transition-colors">
<td class="px-8 py-5 font-mono text-sm">2023-10-26 22:45</td>
<td class="px-8 py-5 font-serif">MQ2-001</td>
<td class="px-8 py-5 font-mono text-sm">1.5 ppm</td>
<td class="px-8 py-5">
<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold font-mono tracking-widest bg-brand-badgeGray text-brand-textSecondary">RESOLVIDO</span>
</td>
</tr>
<!-- Row 9 -->
<tr class="hover:bg-gray-50 transition-colors">
<td class="px-8 py-5 font-mono text-sm">2023-10-26 22:45</td>
<td class="px-8 py-5 font-serif">MQ2-004</td>
<td class="px-8 py-5 font-mono text-sm">1.5 ppm</td>
<td class="px-8 py-5">
<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold font-mono tracking-widest bg-brand-badgeGray text-brand-textSecondary">RESOLVIDO</span>
</td>
</tr>
<!-- Row 10 -->
<tr class="hover:bg-gray-50 transition-colors">
<td class="px-8 py-5 font-mono text-sm">2023-10-26 22:45</td>
<td class="px-8 py-5 font-serif">MQ2-002</td>
<td class="px-8 py-5 font-mono text-sm">1.5 ppm</td>
<td class="px-8 py-5">
<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold font-mono tracking-widest bg-brand-badgeGray text-brand-textSecondary">RESOLVIDO</span>
</td>
</tr>
<!-- Row 11 -->
<tr class="hover:bg-gray-50 transition-colors">
<td class="px-8 py-5 font-mono text-sm">2023-10-26 22:45</td>
<td class="px-8 py-5 font-serif">MQ2-001</td>
<td class="px-8 py-5 font-mono text-sm">1.5 ppm</td>
<td class="px-8 py-5">
<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold font-mono tracking-widest bg-brand-badgeGray text-brand-textSecondary">RESOLVIDO</span>
</td>
</tr>
</tbody>
</table>
</div>
</div>
<!-- Pagination -->
<div class="flex items-center justify-between pb-10">
<div class="text-brand-textSecondary text-sm">
          Mostrando 1 a 11 de 142 registros
        </div>
<div class="flex gap-2">
<button class="px-4 py-2 border border-brand-border rounded-lg text-brand-textSecondary hover:bg-gray-50 transition-colors bg-white">Anterior</button>
<button class="w-10 h-10 border border-brand-dark rounded-lg bg-brand-dark text-white font-medium flex items-center justify-center">1</button>
<button class="w-10 h-10 border border-brand-border rounded-lg text-brand-textSecondary hover:bg-gray-50 transition-colors bg-white flex items-center justify-center">2</button>
<button class="w-10 h-10 border border-brand-border rounded-lg text-brand-textSecondary hover:bg-gray-50 transition-colors bg-white flex items-center justify-center">3</button>
<span class="w-10 h-10 flex items-center justify-center text-brand-textSecondary">...</span>
<button class="px-4 py-2 border border-brand-border rounded-lg text-brand-textSecondary hover:bg-gray-50 transition-colors bg-white">Próximo</button>
</div>
</div>
</div>
</main>
<!-- END: Main Content -->
</body></html>