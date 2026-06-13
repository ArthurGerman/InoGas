<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Inogás - Matriz de Sensores</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=JetBrains+Mono:wght@400;500;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
          darkMode: "class",
          theme: {
            extend: {
              "colors": {
                      "on-secondary-fixed-variant": "#004b74",
                      "on-background": "#191c1e",
                      "surface-variant": "#e0e3e5",
                      "primary-fixed": "#c1ecd4",
                      "on-tertiary-fixed": "#111c2c",
                      "secondary-container": "#67bafd",
                      "on-tertiary-container": "#9ba6bc",
                      "error": "#ba1a1a",
                      "on-error": "#ffffff",
                      "inverse-on-surface": "#eff1f3",
                      "surface-container-high": "#e6e8ea",
                      "background": "#f7f9fb",
                      "secondary-fixed": "#cde5ff",
                      "outline": "#717973",
                      "inverse-surface": "#2d3133",
                      "surface-container": "#eceef0",
                      "secondary-fixed-dim": "#94ccff",
                      "on-surface-variant": "#414844",
                      "inverse-primary": "#a5d0b9",
                      "surface": "#f7f9fb",
                      "on-surface": "#191c1e",
                      "on-primary-container": "#86af99",
                      "surface-container-highest": "#e0e3e5",
                      "surface-tint": "#3f6653",
                      "on-secondary-fixed": "#001d32",
                      "on-primary-fixed": "#002114",
                      "primary-fixed-dim": "#a5d0b9",
                      "error-container": "#ffdad6",
                      "on-primary-fixed-variant": "#274e3d",
                      "tertiary-fixed": "#d8e3fa",
                      "primary-container": "#1b4332",
                      "on-secondary": "#ffffff",
                      "on-error-container": "#93000a",
                      "tertiary-fixed-dim": "#bcc7dd",
                      "on-primary": "#ffffff",
                      "on-tertiary-fixed-variant": "#3c475a",
                      "surface-container-low": "#f2f4f6",
                      "surface-dim": "#d8dadc",
                      "surface-bright": "#f7f9fb",
                      "on-tertiary": "#ffffff",
                      "on-secondary-container": "#004972",
                      "outline-variant": "#c1c8c2",
                      "tertiary-container": "#313c4e",
                      "secondary": "#006399",
                      "primary": "#012d1d",
                      "tertiary": "#1b2637",
                      "surface-container-lowest": "#ffffff"
              },
              "borderRadius": {
                      "DEFAULT": "0.25rem",
                      "lg": "0.5rem",
                      "xl": "0.75rem",
                      "full": "9999px"
              },
              "spacing": {
                      "lg": "40px",
                      "base": "8px",
                      "xl": "64px",
                      "md": "24px",
                      "margin-mobile": "16px",
                      "gutter": "24px",
                      "sm": "12px",
                      "margin-desktop": "48px",
                      "xs": "4px"
              },
              "fontFamily": {
                      "title-md": [
                              "Inter"
                      ],
                      "label-mono": [
                              "JetBrains Mono"
                      ],
                      "headline-lg": [
                              "Inter"
                      ],
                      "display-lg": [
                              "Inter"
                      ],
                      "body-lg": [
                              "Inter"
                      ],
                      "body-sm": [
                              "Inter"
                      ],
                      "headline-lg-mobile": [
                              "Inter"
                      ]
              },
              "fontSize": {
                      "title-md": [
                              "20px",
                              {
                                      "lineHeight": "28px",
                                      "fontWeight": "600"
                              }
                      ],
                      "label-mono": [
                              "12px",
                              {
                                      "lineHeight": "16px",
                                      "letterSpacing": "0.05em",
                                      "fontWeight": "500"
                              }
                      ],
                      "headline-lg": [
                              "32px",
                              {
                                      "lineHeight": "40px",
                                      "letterSpacing": "-0.01em",
                                      "fontWeight": "600"
                              }
                      ],
                      "display-lg": [
                              "48px",
                              {
                                      "lineHeight": "56px",
                                      "letterSpacing": "-0.02em",
                                      "fontWeight": "700"
                              }
                      ],
                      "body-lg": [
                              "16px",
                              {
                                      "lineHeight": "24px",
                                      "fontWeight": "400"
                              }
                      ],
                      "body-sm": [
                              "14px",
                              {
                                      "lineHeight": "20px",
                                      "fontWeight": "400"
                              }
                      ],
                      "headline-lg-mobile": [
                              "24px",
                              {
                                      "lineHeight": "32px",
                                      "fontWeight": "600"
                              }
                      ]
              }
      },
          },
        }
    </script>
</head>
<body class="bg-[#F7F9FB] text-on-surface font-body-lg overflow-x-hidden min-h-screen flex">
<!-- SideNavBar -->
<nav class="bg-[#F2F4F6] text-primary font-body-lg h-screen w-64 fixed left-0 top-0 border-r border-outline-variant flex flex-col p-md gap-base z-20"><div class="mb-lg">
<h1 class="font-display-lg text-[32px] text-primary font-bold tracking-tight">Sensor MQ2-001</h1>
<p class="font-body-sm text-on-surface-variant">Zona A - Setor Norte</p>
</div>
<div class="flex-1 flex flex-col gap-sm">
<a class="flex items-center gap-sm px-sm py-sm text-on-surface-variant hover:bg-surface-container-high transition-all rounded-lg" href="#">
<span class="material-symbols-outlined">grid_view</span>
<span>Painel</span>
</a>
<a class="flex items-center gap-sm px-sm py-sm bg-primary text-on-primary rounded-lg font-semibold transition-all" href="#">
<span class="material-symbols-outlined">sensors</span>
<span>Matriz de Sensores</span>
</a>
<a class="flex items-center gap-sm px-sm py-sm text-on-surface-variant hover:bg-surface-container-high transition-all rounded-lg" href="#">
<span class="material-symbols-outlined">history</span>
<span>Histórico de Alertas</span>
</a>
<a class="flex items-center gap-sm px-sm py-sm text-on-surface-variant hover:bg-surface-container-high transition-all rounded-lg" href="#">
<span class="material-symbols-outlined">analytics</span>
<span>Análises</span>
</a>
<a class="flex items-center gap-sm px-sm py-sm text-on-surface-variant hover:bg-surface-container-high transition-all rounded-lg" href="#">
<span class="material-symbols-outlined">send</span>
<span>Sincronização Telegram</span>
</a>
</div>
<div class="mt-auto flex flex-col gap-sm border-t border-outline-variant pt-md">
<button class="bg-primary text-on-primary py-sm px-md rounded-lg font-medium hover:bg-primary-container transition-colors w-full">Exportar Relatório</button>
<div class="flex flex-col gap-xs mt-sm">
<a class="flex items-center gap-xs text-[12px] text-on-surface-variant" href="#"><span class="material-symbols-outlined text-[16px]">check_circle</span> Saúde do Sistema</a>
<a class="flex items-center gap-xs text-[12px] text-on-surface-variant" href="#"><span class="material-symbols-outlined text-[16px]">help</span> Suporte</a>
</div>
</div></nav>
<!-- Main Content Area -->
<main class="ml-64 flex-1 flex flex-col min-h-screen">
<!-- TopAppBar -->
<header class="h-[81px] bg-surface dark:bg-on-background text-primary dark:text-primary-fixed font-title-md text-title-md w-full top-0 sticky border-b border-outline-variant dark:border-on-surface-variant flex justify-between items-center px-md py-sm max-w-[1280px] mx-auto z-10 w-full">
<div class="font-headline-lg text-headline-lg font-bold text-primary dark:text-primary-fixed">Inogás</div>
<div class="hidden md:flex relative">
<span class="material-symbols-outlined absolute left-sm top-1/2 -translate-y-1/2 text-on-surface-variant" style="font-variation-settings: 'FILL' 0;">search</span>
<input class="w-[360px] h-[40px] pl-[48px] pr-md bg-[#ECE6F0] rounded-[10px] border-none focus:ring-0 text-body-sm text-on-surface placeholder:text-on-surface-variant" placeholder="Search sensors..." type="text"/>
</div>
<div class="flex items-center gap-sm">
<button class="p-sm text-on-surface-variant dark:text-outline-variant hover:bg-surface-container-low dark:hover:bg-tertiary-container transition-colors rounded-full cursor-pointer active:opacity-80">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">account_circle</span>
</button>
<button class="p-sm text-on-surface-variant dark:text-outline-variant hover:bg-surface-container-low dark:hover:bg-tertiary-container transition-colors rounded-full cursor-pointer active:opacity-80">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">settings</span>
</button>
</div>
</header>
<!-- Canvas -->
<div class="flex-1 p-md max-w-[1280px] mx-auto w-full flex flex-col gap-lg">
<div class="flex flex-col gap-xs">
<h2 class="font-display-lg text-[32px] text-on-surface font-bold">Matriz de Sensores</h2>
<p class="text-on-surface-variant text-body-sm">Gerenciamento e monitoramento individual dos módulos MQ-2</p>
</div>
<!-- Summary Section -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-md"><div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-md flex items-center gap-md shadow-[0_4px_12px_rgba(0,0,0,0.05)]"><div class="w-12 h-12 rounded-full bg-[#C1ECD4] flex items-center justify-center"><span class="material-symbols-outlined text-[#012D1D]">sensors</span></div><div><p class="text-on-surface-variant text-body-sm">Sensores Ativos</p><p class="text-display-lg text-[32px] font-bold">3 <span class="text-on-surface-variant text-body-lg">/ 4</span></p></div></div>
<div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-md flex items-center gap-md shadow-[0_4px_12px_rgba(0,0,0,0.05)] border-l-4 border-l-error"><div class="w-12 h-12 rounded-full bg-error-container flex items-center justify-center"><span class="material-symbols-outlined text-error">warning</span></div><div><p class="text-on-surface-variant text-body-sm">Alertas Pendentes</p><p class="text-display-lg text-[32px] font-bold text-on-surface">1</p></div></div>
<div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-md flex items-center gap-md shadow-[0_4px_12px_rgba(0,0,0,0.05)]"><div class="w-12 h-12 rounded-full bg-[#CDE5FF] flex items-center justify-center"><span class="material-symbols-outlined text-[#006399]">waves</span></div><div><p class="text-on-surface-variant text-body-sm">Média de Pureza</p><p class="text-display-lg text-[32px] font-bold">98.4% <span class="material-symbols-outlined text-[16px] text-on-surface-variant">trending_up</span></p></div></div></div>
<!-- Sensor Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-md">
<!-- MQ2-001 -->
<div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-md flex flex-col gap-md shadow-[0_4px_12px_rgba(0,0,0,0.05)] border-t-4 border-t-primary"><div class="flex justify-between items-start mb-sm"><div><h3 class="font-label-mono text-body-lg font-bold">MQ2-001</h3><p class="text-[12px] text-on-surface-variant"><span class="material-symbols-outlined text-[14px]">location_on</span> Zona A - Setor Norte</p></div><span class="px-2 py-1 rounded bg-[#C1ECD4] text-[#012D1D] text-[10px] font-bold uppercase">Online</span></div><div class="flex flex-col gap-xs mb-md"><span class="text-on-surface-variant text-body-sm">Nível dos gases</span><div class="text-[32px] font-bold text-on-surface">12.4 <span class="text-body-sm font-normal text-on-surface-variant">PPM</span></div><div class="h-8 w-full flex items-end"><svg class="w-full h-4" viewbox="0 0 100 20"><path d="M0 15 Q 25 10, 50 15 T 100 10" fill="none" opacity="0.3" stroke="#012D1D" stroke-width="1"></path></svg></div></div><div class="flex gap-sm"><button class="flex-1 py-2 border border-outline-variant rounded text-body-sm font-medium">Conectado</button><button class="flex-1 py-2 border border-outline-variant rounded text-body-sm font-medium">Ver Detalhes</button></div></div>
<!-- MQ2-002 -->
<div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-md flex flex-col gap-md shadow-[0_4px_12px_rgba(0,0,0,0.05)] border-t-4 border-t-[#f59e0b]"><div class="flex justify-between items-start mb-sm"><div><h3 class="font-label-mono text-body-lg font-bold">MQ2-002</h3><p class="text-[12px] text-on-surface-variant"><span class="material-symbols-outlined text-[14px]">location_on</span> Zona A - Sala de Tanques</p></div><span class="px-2 py-1 rounded bg-[#FEF3C7] text-[#B45309] text-[10px] font-bold uppercase">Atenção</span></div><div class="flex flex-col gap-xs mb-md"><span class="text-on-surface-variant text-body-sm">Nível dos gases</span><div class="text-[32px] font-bold text-on-surface">45.8 <span class="text-body-sm font-normal text-on-surface-variant">PPM</span></div><div class="h-8 w-full flex items-end"><svg class="w-full h-4" viewbox="0 0 100 20"><path d="M0 15 Q 25 18, 50 15 T 100 12" fill="none" opacity="0.3" stroke="#F59E0B" stroke-width="1"></path></svg></div></div><div class="flex gap-sm"><button class="flex-1 py-2 bg-[#012D1D] text-on-primary rounded text-body-sm font-medium">Conectar</button><button class="flex-1 py-2 border border-outline-variant rounded text-body-sm font-medium">Ver Detalhes</button></div></div>
<!-- MQ2-003 -->
<div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-md flex flex-col gap-md shadow-[0_4px_12px_rgba(0,0,0,0.05)] border-t-4 border-t-outline-variant"><div class="flex justify-between items-start mb-sm"><div><h3 class="font-label-mono text-body-lg font-bold">MQ2-003</h3><p class="text-[12px] text-on-surface-variant"><span class="material-symbols-outlined text-[14px]">location_on</span> Zona B - Dutos</p></div><span class="px-2 py-1 rounded bg-surface-container-high text-on-surface-variant text-[10px] font-bold uppercase">Offline</span></div><div class="flex flex-col gap-xs mb-md"><span class="text-on-surface-variant text-body-sm">Nível dos gases</span><div class="text-[32px] font-bold text-outline-variant">-- <span class="text-body-sm font-normal text-on-surface-variant">PPM</span></div><div class="h-8 w-full flex items-center justify-end"><span class="material-symbols-outlined text-outline-variant">sensors_off</span></div></div><div class="flex gap-sm mt-auto"><button class="flex-1 py-2 border border-outline-variant rounded text-body-sm font-medium">Ver Detalhes</button></div></div>
<!-- MQ2-004 -->
<div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-md flex flex-col gap-md shadow-[0_4px_12px_rgba(0,0,0,0.05)] border-t-4 border-t-error"><div class="flex justify-between items-start mb-sm"><div><h3 class="font-label-mono text-body-lg font-bold">MQ2-004</h3><p class="text-[12px] text-on-surface-variant"><span class="material-symbols-outlined text-[14px]">location_on</span> Zona A - Compressor</p></div><span class="px-2 py-1 rounded bg-error-container text-error text-[10px] font-bold uppercase">Crítico</span></div><div class="flex flex-col gap-xs mb-md"><span class="text-on-surface-variant text-body-sm">Nível dos gases</span><div class="text-[32px] font-bold text-error">152.0 <span class="text-body-sm font-normal text-on-surface-variant">PPM</span></div><div class="h-8 w-full flex items-end"><svg class="w-full h-4" viewbox="0 0 100 20"><path d="M0 15 Q 25 12, 50 15 T 100 10" fill="none" opacity="0.3" stroke="#BA1A1A" stroke-width="1"></path></svg></div></div><div class="flex gap-sm"><button class="flex-1 py-2 bg-error text-on-error rounded text-body-sm font-medium">Conectar</button><button class="flex-1 py-2 border border-outline-variant rounded text-body-sm font-medium">Ver Detalhes</button></div></div>
</div>
</div>
</main>
<!-- BottomNavBar (Mobile Only) -->
<nav class="md:hidden fixed bottom-0 left-0 w-full flex justify-around items-center px-margin-mobile py-xs bg-surface dark:bg-on-background text-secondary dark:text-secondary-fixed font-label-mono text-label-mono z-50 rounded-t-xl shadow-[0_-4px_12px_rgba(0,0,0,0.05)] border-t border-outline-variant dark:border-none">
<button class="flex flex-col items-center justify-center bg-secondary-container dark:bg-secondary text-on-secondary-container dark:text-on-secondary rounded-full px-4 py-1 active:scale-95 transition-transform">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">waves</span>
<span>Live</span>
</button>
<button class="flex flex-col items-center justify-center text-on-surface-variant dark:text-outline-variant hover:text-primary dark:hover:text-primary-fixed active:scale-95 transition-transform">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">notifications_active</span>
<span>Alerts</span>
</button>
<button class="flex flex-col items-center justify-center text-on-surface-variant dark:text-outline-variant hover:text-primary dark:hover:text-primary-fixed active:scale-95 transition-transform">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">show_chart</span>
<span>Trends</span>
</button>
<button class="flex flex-col items-center justify-center text-on-surface-variant dark:text-outline-variant hover:text-primary dark:hover:text-primary-fixed active:scale-95 transition-transform">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">settings</span>
<span>Settings</span>
</button>
</nav>
</body></html>