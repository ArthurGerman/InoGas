{{-- Interruptor liga/desliga acessível. Uso: <x-alternador id="voz" rotulo="Alerta por voz" :marcado="true" /> --}}
@props(['id', 'rotulo', 'marcado' => false])
<label for="{{ $id }}" class="inline-flex cursor-pointer items-center gap-3">
    <input id="{{ $id }}" type="checkbox" role="switch" @checked($marcado) class="peer sr-only">
    <span aria-hidden="true"
          class="relative h-6 w-11 shrink-0 rounded-full bg-line transition-colors peer-checked:bg-brand peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-brand after:absolute after:top-0.5 after:left-0.5 after:size-5 after:rounded-full after:bg-ink after:transition-transform peer-checked:after:translate-x-5"></span>
    <span class="text-sm font-medium">{{ $rotulo }}</span>
</label>
