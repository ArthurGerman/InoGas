<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Inogas</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">

    <div
        class="min-h-screen flex items-center justify-center bg-cover bg-center relative"
        style="background-image:url('{{ asset('images/fundo2.png') }}')"
    >

        <div class="absolute inset-0 bg-emerald-950/60"></div>

        <div class="relative z-10 w-full max-w-6xl mx-4">

            <div class="grid lg:grid-cols-2 overflow-hidden rounded-3xl shadow-2xl">

                <!-- Painel esquerdo -->
                <div
                    class="hidden lg:flex flex-col justify-between p-12 bg-emerald-950/80 backdrop-blur-sm text-white"
                >

                    <div>
                        <div class="flex items-center gap-2 text-2xl font-bold">
                            🌿 Inogas
                        </div>
                    </div>

                    <div class="max-w-md">

                        <h1 class="text-5xl font-bold leading-tight">
                            Inteligência Ambiental
                            Contínua.
                        </h1>

                        <p class="mt-6 text-emerald-100 leading-relaxed">
                            Monitoramento da qualidade do ar em tempo real,
                            fornecendo dados precisos para decisões
                            sustentáveis e controle ambiental.
                        </p>

                    </div>

                </div>

                <!-- Painel direito -->
                <div class="bg-white p-8 md:p-14">

                    <div class="max-w-md mx-auto">

                        <h2 class="text-3xl font-bold text-gray-900">
                            Acesso ao Sistema
                        </h2>

                        <p class="mt-2 text-sm text-gray-500">
                            Insira suas credenciais para acessar a plataforma.
                        </p>

                        <form
                            method="POST"
                            action="{{ route('login') }}"
                            class="mt-10 space-y-5"
                        >
                            @csrf

                            <!-- Email -->
                            <div>

                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    E-mail
                                </label>

                                <div class="relative">

                                    <svg
                                        class="w-5 h-5 absolute left-3 top-3.5 text-gray-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M16 12H8m8 0l-8 0m8 0l-8 0"
                                        />
                                    </svg>

                                    <input
                                        type="email"
                                        name="email"
                                        placeholder="gestor@email.com"
                                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-700 focus:border-emerald-700 outline-none"
                                    >

                                </div>

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
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-700 focus:border-emerald-700 outline-none"
                                >

                            </div>

                            <div
                                class="flex items-center justify-between text-sm"
                            >

                                <label class="flex items-center gap-2">

                                    <input
                                        type="checkbox"
                                        class="rounded border-gray-300"
                                    >

                                    <span class="text-gray-600">
                                        Lembrar credenciais
                                    </span>

                                </label>

                                <a
                                    href="#"
                                    class="text-emerald-700 hover:text-emerald-800"
                                >
                                    Esqueci minha senha
                                </a>

                            </div>

                            <button
                                type="submit"
                                class="w-full bg-emerald-900 hover:bg-emerald-800 transition text-white font-semibold py-3 rounded-lg"
                            >
                                Acessar Plataforma →
                            </button>

                        </form>

                        <div class="flex items-center my-8">

                            <div class="flex-1 border-t"></div>

                            <span class="px-4 text-xs text-gray-400">
                                ACESSO RESTRITO
                            </span>

                            <div class="flex-1 border-t"></div>

                        </div>

                        <p class="text-center text-sm text-gray-500">

                            Novo gestor operacional?

                            <a
                                href="{{ route('cadastro') }}"
                                class="text-emerald-700 font-medium"
                            >
                                Cadastre-se aqui
                            </a>

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>
</html>