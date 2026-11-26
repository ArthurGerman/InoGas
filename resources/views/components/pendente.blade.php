{{--
    Faixa "Back não implementado". Some sozinha quando o recurso é marcado como conectado
    em config/inogas.php, e só aparece em desenvolvimento (APP_DEBUG=true).
    Uso: <x-pendente recurso="alertas">Alertas e checklist ainda usam dados de exemplo.</x-pendente>
--}}
@props(['recurso'])
@if (config('inogas.mostrar_pendencias') && ! config("inogas.conectado.$recurso"))
    <div role="note" {{ $attributes->merge(['class' => 'rounded-lg border border-dashed border-attn/50 bg-attn/10 px-3 py-2 text-xs text-attn']) }}>
        <strong class="font-semibold">Back não implementado.</strong> {{ $slot }}
    </div>
@endif
