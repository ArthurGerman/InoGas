<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta | Inogas</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<div
    class="min-h-screen flex items-center justify-center bg-cover bg-center relative"
    style="background-image:url('{{ asset('images/fundo2.png') }}')"
>

    <!-- Overlay -->
    <div class="absolute inset-0 bg-emerald-950/60"></div>

    <!-- Card -->
    <div class="relative z-10 w-full max-w-5xl mx-4">

        <div class="grid lg:grid-cols-2 overflow-hidden rounded-3xl shadow-2xl">

            <!-- Painel esquerdo -->
            <div
                class="hidden lg:flex flex-col justify-between bg-emerald-950/75 backdrop-blur-sm p-10 text-white"
            >

                <div class="flex items-center gap-2">
                    <span class="text-2xl">🌿</span>
                    <span class="font-bold text-2xl">
                        Inogas
                    </span>
                </div>

                <div class="max-w-md">

                    <h1 class="text-5xl font-bold leading-tight">
                        Precisão industrial.
                        <br>
                        Proteção Ambiental.
                    </h1>

                    <p class="mt-6 text-emerald-100 text-sm leading-relaxed">
                        Utilize nossa rede de sensores avançados para
                        manter a conformidade regulatória e garantir
                        a segurança operacional.
                    </p>

                </div>

            </div>

            <!-- Painel direito -->
            <div class="bg-white p-8 lg:p-14">

                <div class="max-w-md mx-auto">

                    <h2 class="text-3xl font-bold text-gray-900">
                        Criar Conta
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Registre-se no Inogás para monitoramento
                        ambiental em tempo real.
                    </p>

                    <form
                        method="POST"
                        action="{{ route('cadastro') }}"
                        class="mt-8 space-y-5"
                    >
                        @csrf

                        <!-- Nome -->
                        <div>

                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Nome Completo
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="João da Silva"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-800 focus:border-emerald-800"
                            >

                            @error('name')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        <!-- Email -->
                        <div>

                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                E-mail
                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="gestor@gmail.com"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-800 focus:border-emerald-800"
                            >

                            @error('email')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        <!-- Senha -->
                        <div>

                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Senha
                            </label>

                            <input
                                type="password"
                                name="password"
                                placeholder="********"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-800 focus:border-emerald-800"
                            >

                            @error('password')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        <!-- Confirmar senha -->
                        <div>

                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Confirme a senha
                            </label>

                            <input
                                type="password"
                                name="password_confirmation"
                                placeholder="********"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-800 focus:border-emerald-800"
                            >

                        </div>

                        <!-- Botão -->
                        <button
                            type="submit"
                            class="w-full bg-emerald-950 hover:bg-emerald-900 text-white font-semibold py-3 rounded-lg transition-all duration-300"
                        >
                            Criar Conta
                        </button>

                        <!-- Login -->
                        <p class="text-center text-sm text-gray-500 mt-6">

                            Já possui uma conta?

                            <a
                                href="{{ route('login') }}"
                                class="text-emerald-800 font-medium hover:underline"
                            >
                                Voltar para Login
                            </a>

                        </p>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>