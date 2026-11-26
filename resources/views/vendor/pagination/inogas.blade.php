{{-- Paginação no tema escuro do InoGas. Uso: {{ $itens->onEachSide(1)->links('vendor.pagination.inogas') }} --}}
@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Paginação" class="flex flex-wrap items-center gap-1 text-sm">
        @if ($paginator->onFirstPage())
            <span aria-disabled="true" class="rounded-lg border border-line px-3 py-1.5 text-soft/50">Anterior</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
               class="rounded-lg border border-line px-3 py-1.5 text-ink transition-colors hover:border-brand/40">Anterior</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-2 text-soft">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page" class="rounded-lg border border-brand/40 bg-brand/10 px-3 py-1.5 font-medium text-brand">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" aria-label="Ir para a página {{ $page }}"
                           class="rounded-lg border border-transparent px-3 py-1.5 text-soft transition-colors hover:border-line hover:text-ink">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
               class="rounded-lg border border-line px-3 py-1.5 text-ink transition-colors hover:border-brand/40">Próxima</a>
        @else
            <span aria-disabled="true" class="rounded-lg border border-line px-3 py-1.5 text-soft/50">Próxima</span>
        @endif
    </nav>
@endif
