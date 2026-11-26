{{--
    Aviso para quem está na visão Morador e abriu uma tela de gestão.
    ATENÇÃO: isto só esconde na tela. A proteção de verdade (no servidor) entra
    depois que o banco novo tiver os papéis.
    Uso: <x-area-restrita /> (junto do conteúdo marcado com data-so="responsavel")
--}}
<div data-so="morador" class="rounded-xl border border-line bg-panel p-8 text-center">
    <span class="mx-auto grid size-12 place-items-center rounded-lg bg-panel-2 text-soft">
        <x-icone nome="escudo" class="size-6" />
    </span>
    <h2 class="mt-4 text-lg font-semibold">Esta área é do responsável</h2>
    <p class="mx-auto mt-1 max-w-md text-sm text-soft">
        Quem cuida da casa ou do prédio faz esses ajustes. Você continua com o Painel, o Histórico e os Alertas.
    </p>
    <a href="{{ \Illuminate\Support\Facades\Route::has('painel') ? route('painel') : '#' }}"
       class="mt-5 inline-flex rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-brand-ink transition-colors hover:bg-brand/90">
        Voltar ao Painel
    </a>
</div>
