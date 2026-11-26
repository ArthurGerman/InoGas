<?php

/*
 * Configurações do front do InoGas.
 * Tudo que muda com o tempo (unidade, limites, tempo sem sinal, o que já está
 * ligado ao back) fica aqui, para não precisar caçar nas telas.
 */
return [

    // Rótulo da leitura. Quando o back passar a entregar ppm calibrado,
    // troque 'rotulo' para 'Concentração', 'sufixo' para 'ppm' e 'calibrado' para true.
    'unidade' => [
        'rotulo' => 'Sinal bruto',
        'sufixo' => '',
        'nota' => 'Sem calibração',
        'calibrado' => false,
    ],

    // Limites usados nos estados Normal / Atenção / Risco.
    // Hoje valem para o número bruto do sensor (comportamento do protótipo).
    'limites' => [
        'atencao' => 200,
        'risco' => 500,
    ],

    // Segundos sem leitura nova para o painel mostrar "Sem sinal".
    'sem_sinal_apos_segundos' => 30,

    // Amostras de leitura: o sensor envia uma por segundo, mas só uma por intervalo é gravada.
    // As amostras mais antigas que "guardar_dias" são apagadas por: php artisan inogas:limpar-amostras
    // (os alertas nunca são apagados).
    'amostras' => [
        'intervalo_segundos' => 60,
        'guardar_dias' => 30,
    ],

    // Nas telas de gestão (Minhas casas e sensores): segundos sem leitura para o sensor aparecer
    // como "Sem comunicação recente". O Painel usa o tempo de cima (30 s), porque lê a leitura direto.
    'sensores_comunicacao_segundos' => 120,

    // Aviso "Nível subindo rápido": olha as últimas N leituras e avisa quando a
    // subida total for maior ou igual ao mínimo (no mesmo número do sensor).
    'tendencia' => [
        'amostras' => 6,
        'subida_minima' => 40,
    ],

    // Mostra a faixa "Back não implementado" nas telas que ainda usam dados de exemplo.
    // Por padrão só aparece com APP_DEBUG=true. Para forçar: INOGAS_MOSTRAR_PENDENCIAS=true/false no .env.
    'mostrar_pendencias' => env('INOGAS_MOSTRAR_PENDENCIAS', env('APP_DEBUG', false)),

    // O que já está ligado ao back. Quando um recurso ficar pronto, troque para true
    // e a faixa de aviso dele some sozinha.
    'conectado' => [
        'painel_leitura' => true,
        'historico' => true,
        'periodo' => true,
        'residencias' => true,
        'planta' => false,
        'alertas' => false,
        'ciente' => true,
        'exportar_pdf' => true,
        'perfis' => true,
        'moradores' => true,
        'conta' => true,
        'silenciar' => true,
        'teste' => true,
        'avisos' => false,
    ],

    'aviso_rodape' => 'O InoGas é um protótipo de monitoramento e não é um detector certificado.',
];
