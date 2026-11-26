{{-- Checklist de emergência. Marcar os passos é só para acompanhar: nada é enviado. --}}
@php
    $passos = ['Sair do local', 'Ventilar o ambiente', 'Fechar o registro do gás', 'Evitar faíscas e chamas', 'Avisar o responsável'];
@endphp
<ol class="space-y-2">
    @foreach ($passos as $i => $passo)
        <li>
            <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-line bg-canvas/40 px-4 py-3 text-sm has-[:checked]:border-brand/40 has-[:checked]:text-soft has-[:checked]:line-through">
                <input type="checkbox" class="size-4 accent-brand">
                <span class="grid size-6 shrink-0 place-items-center rounded-full bg-panel-2 text-xs font-semibold">{{ $i + 1 }}</span>
                {{ $passo }}
            </label>
        </li>
    @endforeach
</ol>
<p class="mt-4 text-xs text-soft">
    Ventile e feche o registro somente se der para fazer sem se expor ao risco, e não volte ao local para executar ações.
    Depois de sair, se o cheiro de gás continuar, ligue para os Bombeiros (193).
</p>
