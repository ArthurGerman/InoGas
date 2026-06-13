<!DOCTYPE html>

<html lang="pt-BR"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Inogás Dashboard</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "secondary-fixed": "#cde5ff",
                        "on-primary-fixed": "#002114",
                        "on-primary-container": "#86af99",
                        "error": "#ba1a1a",
                        "tertiary-fixed-dim": "#bcc7dd",
                        "surface-container-lowest": "#ffffff",
                        "on-primary": "#ffffff",
                        "on-error-container": "#93000a",
                        "tertiary": "#1b2637",
                        "primary-fixed": "#c1ecd4",
                        "on-tertiary-fixed-variant": "#3c475a",
                        "inverse-surface": "#2d3133",
                        "outline": "#717973",
                        "outline-variant": "#c1c8c2",
                        "on-secondary-fixed": "#001d32",
                        "on-surface": "#191c1e",
                        "surface-container-high": "#e6e8ea",
                        "on-tertiary": "#ffffff",
                        "secondary-fixed-dim": "#94ccff",
                        "on-background": "#191c1e",
                        "on-secondary": "#ffffff",
                        "inverse-on-surface": "#eff1f3",
                        "background": "#f7f9fb",
                        "surface-dim": "#d8dadc",
                        "primary-fixed-dim": "#a5d0b9",
                        "on-secondary-container": "#004972",
                        "surface-container": "#eceef0",
                        "secondary-container": "#67bafd",
                        "primary": "#012d1d",
                        "tertiary-fixed": "#d8e3fa",
                        "on-surface-variant": "#414844",
                        "on-error": "#ffffff",
                        "surface": "#f7f9fb",
                        "surface-variant": "#e0e3e5",
                        "surface-tint": "#3f6653",
                        "secondary": "#006399",
                        "surface-container-highest": "#e0e3e5",
                        "inverse-primary": "#a5d0b9",
                        "tertiary-container": "#313c4e",
                        "on-tertiary-container": "#9ba6bc",
                        "on-secondary-fixed-variant": "#004b74",
                        "on-tertiary-fixed": "#111c2c",
                        "surface-container-low": "#f2f4f6",
                        "surface-bright": "#f7f9fb",
                        "on-primary-fixed-variant": "#274e3d",
                        "error-container": "#ffdad6",
                        "primary-container": "#1b4332"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "xs": "4px",
                        "gutter": "24px",
                        "margin-desktop": "48px",
                        "margin-mobile": "16px",
                        "base": "8px",
                        "sm": "12px",
                        "md": "24px",
                        "xl": "64px",
                        "lg": "40px"
                    },
                    "fontFamily": {
                        "display-lg": ["Inter"],
                        "headline-lg-mobile": ["Inter"],
                        "headline-lg": ["Inter"],
                        "body-sm": ["Inter"],
                        "label-mono": ["JetBrains Mono"],
                        "title-md": ["Inter"],
                        "body-lg": ["Inter"]
                    },
                    "fontSize": {
                        "display-lg": ["48px", { "lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "headline-lg-mobile": ["24px", { "lineHeight": "32px", "fontWeight": "600" }],
                        "headline-lg": ["32px", { "lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "body-sm": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
                        "label-mono": ["12px", { "lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "500" }],
                        "title-md": ["20px", { "lineHeight": "28px", "fontWeight": "600" }],
                        "body-lg": ["16px", { "lineHeight": "24px", "fontWeight": "400" }]
                    }
                }
            }
        }
    </script>
<style>
        body { font-family: 'Inter', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        .text-shadow-sm { text-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    </style>
</head>
<body class="bg-surface text-on-surface h-screen flex overflow-hidden">
<!-- SideNavBar -->
<aside class="bg-surface-container-low border-r border-outline-variant w-[445px] flex-shrink-0 flex flex-col justify-between hidden md:flex h-full">
<div>
<div class="p-md pb-8">
<h1 class="font-display-lg text-display-lg text-primary mb-2">Sensor MQ2-001</h1>
<p class="font-title-md text-title-md text-on-surface-variant">Zona A - Setor Norte</p>
</div>
<nav class="flex flex-col gap-sm px-4">
<a class="flex items-center gap-4 px-md py-sm rounded-lg bg-primary text-on-primary font-title-md text-title-md" href="#">
<span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                    Painel
                </a>
<a class="flex items-center gap-4 px-md py-sm rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors font-title-md text-title-md" href="#">
<span class="material-symbols-outlined" data-icon="sensors">sensors</span>
                    Matriz de Sensores
                </a>
<a class="flex items-center gap-4 px-md py-sm rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors font-title-md text-title-md" href="#">
<span class="material-symbols-outlined" data-icon="history">history</span>
                    Histórico de Alertas
                </a>
<a class="flex items-center gap-4 px-md py-sm rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors font-title-md text-title-md" href="#">
<span class="material-symbols-outlined" data-icon="leaderboard">leaderboard</span>
                    Análises
                </a>
<a class="flex items-center gap-4 px-md py-sm rounded-lg text-on-surface-variant hover:bg-surface-container-high transition-colors font-title-md text-title-md" href="#">
<span class="material-symbols-outlined" data-icon="send">send</span>
                    Sincronização Telegram
                </a>
</nav>
</div>
<div class="p-md flex flex-col gap-md border-t border-outline-variant">
<button class="w-full bg-primary text-on-primary py-sm rounded-lg font-title-md text-title-md font-bold hover:opacity-90 transition-opacity">
                Exportar Relatório
            </button>
<div class="flex flex-col gap-2">
<a class="flex items-center gap-2 text-on-surface-variant font-body-sm text-body-sm hover:text-primary transition-colors" href="#">
<span class="material-symbols-outlined text-[18px]" data-icon="check_circle">check_circle</span>
                    Saúde do Sistema
                </a>
<a class="flex items-center gap-2 text-on-surface-variant font-body-sm text-body-sm hover:text-primary transition-colors" href="#">
<span class="material-symbols-outlined text-[18px]" data-icon="help">help</span>
                    Suporte
                </a>
</div>
</div>
</aside>
<!-- Main Content -->
<main class="flex-1 flex flex-col h-full overflow-y-auto">
<!-- TopAppBar -->
<header class="bg-surface border-b border-outline-variant w-full top-0 sticky z-10 px-md py-sm flex justify-between items-center">
<div class="flex items-center gap-2 text-primary font-display-lg text-display-lg">
<span class="material-symbols-outlined text-[40px]" data-icon="eco" style="font-variation-settings: 'FILL' 1;">eco</span>
                Inogás
            </div>
<div class="flex items-center gap-4 text-primary">
<button class="hover:bg-surface-container-low p-2 rounded-full transition-colors active:opacity-80">
<span class="material-symbols-outlined" data-icon="account_circle">account_circle</span>
</button>
<button class="hover:bg-surface-container-low p-2 rounded-full transition-colors active:opacity-80">
<span class="material-symbols-outlined" data-icon="settings">settings</span>
</button>
</div>
</header>
<div class="p-xl max-w-[1400px] mx-auto w-full flex flex-col gap-xl">
<!-- Header Section -->
<div class="flex justify-between items-end flex-wrap gap-md">
<div>
<h2 class="font-headline-lg text-headline-lg text-primary mb-1">Painel Principal</h2>
<p class="font-body-lg text-body-lg text-on-surface-variant">Monitoramento Ambiental ao Vivo</p>
</div>
<div class="flex gap-sm">
<span class="bg-primary-fixed text-primary font-label-mono text-label-mono px-3 py-1 rounded-full flex items-center gap-1 border border-primary-fixed-dim">
<span class="material-symbols-outlined text-[14px]">sensors</span> MQ-2 ONLINE
                    </span>
<span class="bg-secondary-fixed text-on-secondary-fixed font-label-mono text-label-mono px-3 py-1 rounded-full flex items-center gap-1 border border-secondary-fixed-dim">
<span class="material-symbols-outlined text-[14px]">health_and_safety</span> SISTEMA SAUDÁVEL
                    </span>
</div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-md">
<!-- Main Metric Card -->
<div class="lg:col-span-1 bg-surface-container-lowest border border-outline-variant rounded-lg p-xl flex flex-col items-center justify-center text-center shadow-[0_4px_12px_rgba(0,0,0,0.05)] border-t-[4px] border-t-primary">
<h3 class="font-title-md text-title-md text-primary mb-2">Nivel dos Gases</h3>
<p class="font-body-sm text-body-sm text-on-surface-variant mb-6">(Metano, Propano, Butano, Amônia)</p>
<div class="font-mono text-[64px] leading-none text-primary font-bold mb-2 tracking-tighter">1.2</div>
<div class="font-label-mono text-label-mono text-on-surface-variant uppercase tracking-widest">PPM / NORMAL</div>
</div>
<!-- Charts Section placeholder for bento layout -->
<div class="lg:col-span-2 bg-surface-container-lowest border border-outline-variant rounded-lg p-md shadow-[0_4px_12px_rgba(0,0,0,0.05)] flex flex-col">
<div class="flex justify-between items-center mb-md">
<h3 class="font-title-md text-title-md text-primary">Tendências de Concentração de Gás (24h)</h3>
<button class="text-secondary font-label-mono text-label-mono flex items-center gap-1 hover:text-primary transition-colors uppercase">
                            Expandir <span class="material-symbols-outlined text-[16px]">open_in_new</span>
</button>
</div>
<div class="flex-1 bg-surface-container-low rounded border border-outline-variant/50 relative overflow-hidden min-h-[300px]">
<!-- Simulated Chart -->
<div class="absolute bottom-0 left-0 w-full h-[60%] bg-gradient-to-t from-secondary/10 to-transparent"></div>
<svg class="absolute bottom-0 w-full h-[80%]" preserveaspectratio="none" viewbox="0 0 100 100">
<path d="M0 100 L0 80 L5 85 L10 70 L15 75 L20 60 L25 50 L30 65 L35 40 L40 50 L45 35 L50 45 L55 20 L60 40 L65 30 L70 50 L75 40 L80 60 L85 45 L90 25 L95 35 L100 10" fill="none" stroke="#006399" stroke-width="0.5" vector-effect="non-scaling-stroke"></path>
<path d="M50 100 L50 85 L55 90 L60 70 L65 80 L70 55 L75 65 L80 40 L85 55 L90 30 L95 45 L100 15" fill="none" stroke="#a5d0b9" stroke-width="0.5" vector-effect="non-scaling-stroke"></path>
</svg>
<div class="absolute inset-0" style="background-image: linear-gradient(to right, rgba(0,0,0,0.05) 1px, transparent 1px), linear-gradient(to bottom, rgba(0,0,0,0.05) 1px, transparent 1px); background-size: 20px 20px;"></div>
</div>
</div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-md">
<!-- Telegram Widget -->
<div class="lg:col-span-1 bg-surface-container-low border border-outline-variant rounded-lg p-md shadow-[0_4px_12px_rgba(0,0,0,0.05)] flex flex-col">
<div class="flex items-center justify-between mb-md bg-surface-container-lowest p-sm rounded border border-outline-variant">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-primary" data-icon="send">send</span>
<span class="font-title-md text-title-md text-primary">Sincronização Telegram</span>
</div>
<span class="bg-secondary-fixed text-on-secondary-fixed font-label-mono text-label-mono px-2 py-0.5 rounded-full text-[10px]">SINCRONIZADO</span>
</div>
<h4 class="font-label-mono text-label-mono text-on-surface-variant mb-2 uppercase">Última Transmissão</h4>
<div class="bg-surface-container-lowest border-l-4 border-l-primary rounded p-sm flex-1 mb-md">
<p class="font-body-sm text-body-sm text-on-surface mb-4">
<strong>[ALERTA]</strong> O Sensor MQ-2 do Setor A relata Butano levemente elevado (4,8 ppm). Recomenda-se que o pessoal monitore a ventilação da Área 3.
                        </p>
<div class="text-right font-label-mono text-[10px] text-on-surface-variant">14:02 Hoje</div>
</div>
<button class="w-full py-2 bg-surface-container-highest hover:bg-surface-variant text-on-surface font-title-md text-[14px] rounded border border-outline-variant transition-colors">
                        Enviar Ping Manual
                    </button>
</div>
<!-- Recent Alerts Table -->
<div class="lg:col-span-2 bg-surface-container-lowest border border-outline-variant rounded-lg flex flex-col shadow-[0_4px_12px_rgba(0,0,0,0.05)] overflow-hidden">
<div class="flex justify-between items-center p-md border-b border-outline-variant">
<h3 class="font-title-md text-title-md text-primary">Alertas Recentes</h3>
<button class="text-on-surface-variant hover:text-primary transition-colors">
<span class="material-symbols-outlined">filter_list</span>
</button>
</div>
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-low border-b border-outline-variant font-label-mono text-label-mono text-on-surface-variant uppercase">
<th class="p-sm font-medium">Data/Hora</th>
<th class="p-sm font-medium">Tipo de Gás</th>
<th class="p-sm font-medium">Concentração</th>
<th class="p-sm font-medium">Status</th>
</tr>
</thead>
<tbody class="font-body-sm text-body-sm">
<tr class="border-b border-outline-variant hover:bg-surface-bright transition-colors">
<td class="p-sm font-mono text-[12px] text-on-surface-variant">2023-10-27 14:00</td>
<td class="p-sm text-on-surface">Butano (C4H10)</td>
<td class="p-sm font-mono text-error">4.8 ppm</td>
<td class="p-sm">
<span class="bg-error-container text-on-error-container px-2 py-0.5 rounded-full font-label-mono text-[10px] border border-error/20">PENDENTE</span>
</td>
</tr>
<tr class="border-b border-outline-variant hover:bg-surface-bright transition-colors">
<td class="p-sm font-mono text-[12px] text-on-surface-variant">2023-10-27 08:15</td>
<td class="p-sm text-on-surface">Metano (CH4)</td>
<td class="p-sm font-mono text-on-surface">2.1 ppm</td>
<td class="p-sm">
<span class="bg-surface-container-high text-on-surface-variant px-2 py-0.5 rounded-full font-label-mono text-[10px] border border-outline-variant">RESOLVIDO</span>
</td>
</tr>
<tr class="hover:bg-surface-bright transition-colors">
<td class="p-sm font-mono text-[12px] text-on-surface-variant">2023-10-26 22:45</td>
<td class="p-sm text-on-surface">Amônia (NH3)</td>
<td class="p-sm font-mono text-on-surface">1.5 ppm</td>
<td class="p-sm">
<span class="bg-surface-container-high text-on-surface-variant px-2 py-0.5 rounded-full font-label-mono text-[10px] border border-outline-variant">RESOLVIDO</span>
</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
</main>
<!-- BottomNavBar (Mobile only, based on spec) -->
<nav class="md:hidden fixed bottom-0 left-0 w-full bg-surface shadow-[0_-4px_12px_rgba(0,0,0,0.05)] border-t border-outline-variant z-50 flex justify-around items-center px-margin-mobile py-xs rounded-t-xl">
<a class="flex flex-col items-center justify-center bg-secondary-container text-on-secondary-container rounded-full px-4 py-1 active:scale-95 transition-transform" href="#">
<span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
<span class="font-label-mono text-label-mono mt-1">Painel</span>
</a>
<a class="flex flex-col items-center justify-center text-on-surface-variant hover:text-primary active:scale-95 transition-transform" href="#">
<span class="material-symbols-outlined" data-icon="sensors">sensors</span>
<span class="font-label-mono text-label-mono mt-1">Sensores</span>
</a>
<a class="flex flex-col items-center justify-center text-on-surface-variant hover:text-primary active:scale-95 transition-transform" href="#">
<span class="material-symbols-outlined" data-icon="history">history</span>
<span class="font-label-mono text-label-mono mt-1">Alertas</span>
</a>
<a class="flex flex-col items-center justify-center text-on-surface-variant hover:text-primary active:scale-95 transition-transform" href="#">
<span class="material-symbols-outlined" data-icon="settings">settings</span>
<span class="font-label-mono text-label-mono mt-1">Ajustes</span>
</a>
</nav>
</body></html>