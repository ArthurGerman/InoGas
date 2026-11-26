{{-- Residência e sensor em uso (vêm dos cadastros de "Minhas casas e sensores"). --}}
@php
    $ehResponsavelSel = session('usuario_papel', 'responsavel') === 'responsavel';
    $usuarioSel = \App\Models\Usuario::find((int) session('usuario_id'));
    $sensorSel = \App\Models\Dispositivo::with('local')->where('ativo', true)
        ->whereIn('local_id', $usuarioSel ? $usuarioSel->locaisVisiveisIds() : [])
        ->orderBy('id')->first();
    $residenciaSel = $sensorSel && $sensorSel->local ? $sensorSel->local->raiz()->nome : null;
@endphp
<x-cartao>
    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label for="sel-residencia" class="mb-1.5 block text-sm font-medium">Residência</label>
            <select id="sel-residencia" disabled class="w-full rounded-lg border border-line bg-canvas px-3.5 py-2.5 text-sm text-soft">
                <option>{{ $residenciaSel ?? 'Nenhuma cadastrada' }}</option>
            </select>
        </div>
        <div>
            <label for="sel-dispositivo" class="mb-1.5 block text-sm font-medium">Sensor</label>
            <select id="sel-dispositivo" disabled class="w-full rounded-lg border border-line bg-canvas px-3.5 py-2.5 text-sm text-soft">
                <option>{{ optional($sensorSel)->nome ?? 'Nenhum cadastrado' }}</option>
            </select>
        </div>
    </div>
    @if (! $sensorSel && $ehResponsavelSel)
        <p class="mt-4 text-sm text-soft">
            Cadastre a sua residência e o sensor em
            <a href="{{ \Illuminate\Support\Facades\Route::has('residencias') ? route('residencias') : '#' }}" class="font-medium text-brand hover:underline">Minhas casas e sensores</a>.
        </p>
    @endif
</x-cartao>
