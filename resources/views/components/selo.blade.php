{{--
    Selo de estado: cor + ícone + texto (nunca só cor).
    Uso: <x-selo estado="atencao">Atenção</x-selo>
    Estados: aguardando, normal, atencao, risco, info
--}}
@props(['estado' => 'aguardando'])
@php
    $estados = [
        'aguardando' => ['text-soft border-soft/40 bg-soft/10', 'bolinha'],
        'normal' => ['text-brand border-brand/50 bg-brand/15', 'bolinha'],
        'atencao' => ['text-attn border-attn/50 bg-attn/15', 'triangulo'],
        'risco' => ['text-risk border-risk/50 bg-risk/15', 'quadrado'],
        'info' => ['text-info border-info/50 bg-info/15', 'bolinha'],
    ];
    [$cores, $forma] = $estados[$estado] ?? $estados['aguardando'];
@endphp
<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 rounded-full border px-2.5 py-1 text-xs font-medium $cores"]) }}>
    @if ($forma === 'triangulo')
        <svg viewBox="0 0 10 9" class="h-[9px] w-2.5" aria-hidden="true"><polygon points="5,0 10,9 0,9" fill="currentColor" /></svg>
    @elseif ($forma === 'quadrado')
        <svg viewBox="0 0 8 8" class="size-2" aria-hidden="true"><rect width="8" height="8" rx="1" fill="currentColor" /></svg>
    @else
        <svg viewBox="0 0 8 8" class="size-2" aria-hidden="true"><circle cx="4" cy="4" r="4" fill="currentColor" /></svg>
    @endif
    {{ $slot }}
</span>
