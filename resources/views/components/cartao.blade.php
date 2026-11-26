{{-- Cartão padrão. Uso: <x-cartao rotulo="Leitura do sensor" titulo="Como está agora"> ... </x-cartao> --}}
@props(['rotulo' => null, 'titulo' => null])
<section {{ $attributes->merge(['class' => 'rounded-xl border border-line bg-panel p-5']) }}>
    @if ($rotulo)
        <p class="text-xs font-medium tracking-wide text-soft uppercase">{{ $rotulo }}</p>
    @endif
    @if ($titulo)
        <h2 class="{{ $rotulo ? 'mt-2' : '' }} text-lg font-semibold text-ink">{{ $titulo }}</h2>
    @endif
    <div class="{{ $rotulo || $titulo ? 'mt-4' : '' }}">
        {{ $slot }}
    </div>
</section>
