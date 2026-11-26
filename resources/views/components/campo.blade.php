{{-- Campo de formulário com rótulo e mensagem de erro do Laravel. --}}
@props(['nome', 'rotulo', 'tipo' => 'text', 'placeholder' => '', 'autocomplete' => null])
<div>
    <label for="{{ $nome }}" class="mb-1.5 block text-sm font-medium text-ink">{{ $rotulo }}</label>
    <input
        id="{{ $nome }}"
        name="{{ $nome }}"
        type="{{ $tipo }}"
        @if ($tipo !== 'password') value="{{ old($nome) }}" @endif
        placeholder="{{ $placeholder }}"
        @if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif
        @if ($errors->has($nome)) aria-invalid="true" aria-describedby="{{ $nome }}-erro" @endif
        class="w-full rounded-lg border bg-canvas px-3.5 py-2.5 text-sm text-ink placeholder:text-soft/70 {{ $errors->has($nome) ? 'border-risk' : 'border-line' }}"
    >
    @error($nome)
        <p id="{{ $nome }}-erro" class="mt-1.5 text-sm text-risk">{{ $message }}</p>
    @enderror
</div>
