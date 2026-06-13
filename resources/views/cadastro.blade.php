<!-- ============================================================================= -->
<!-- ARQUIVO: cadastro.blade.php - Página de Cadastro do Sistema Inogás           -->
<!-- DESCRIÇÃO: Interface de criação de conta com design responsivo,             -->
<!--            utilizando Tailwind CSS e tipografia serif para aparência        -->
<!--            profissional e consistente com a página de login.              -->
<!-- ============================================================================= -->

<!DOCTYPE html>

<html lang="pt-BR">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Inogás - Criar Conta</title>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Libertinus+Serif:wght@400;600;700&amp;display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'inogas-dark': '#012D1D',
            'inogas-bg': '#3C5C4D',
            'inogas-link': '#006399',
            'inogas-text': '#1F2937',
            'inogas-subtext': '#6B7280',
            'inogas-border': '#D1D5DB',
            'inogas-input-bg': '#F9FAFB',
          },
          fontFamily: {
            'serif': ['"Libertinus Serif"', 'serif'],
          },
          borderRadius: {
            'xl': '24px',
          }
        }
      }
    }
  </script>
<style class="" data-purpose="custom-styles">
    body {
      font-family: 'Libertinus Serif', serif; /* Aplica serif consistente na página */
    }
   
    /* Estilo do placeholder de entrada para combinar com a tipografia da página */
    input::placeholder {
      font-family: 'Libertinus Serif', serif;
      color: #9CA3AF;
    }
   
    /* Garante que textos interpretativos usem a mesma família serif */
    .form-text {
      font-family: 'Libertinus Serif', serif;
    }
    .bg-full-overlay {
      background: linear-gradient(135deg, rgba(1, 45, 29, 0.9) 0%, rgba(27, 67, 50, 0.8) 23.08%), url('https://lh3.googleusercontent.com/aida-public/AB6AXuDgCr2nOAly_gPGShjtSZ0dt9djY_DeCeAkNQbhOA4sJtKGkoTcAhQ7qjnZ-QdwSBLBsjAUDndKh_ER7eWb6Sfw9uDWmoOwrzS0qCyk9Av6WojamUQ0SRWHJUGR4r1dLmX1vjWEG2-dx1sI35Pw-XmOcQFPYKGF61J3lJV1otaoVtxilIE_ucu-XNjXK9h4QtTQErnypuTYyfpLGeOFINVJ1j4mBM8y-_g76ttKwbBGs3qNucgx2yAxep04GLfEHsVIhm0tkZwQhZ6p');
      background-size: cover;
      background-position: center;
    }
    .left-panel-bg {
      background-color: #012D1D;
      position: relative;
    }
    .left-panel-bg::before {
      content: '';
      position: absolute;
      inset: 0;
      background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDgCr2nOAly_gPGShjtSZ0dt9djY_DeCeAkNQbhOA4sJtKGkoTcAhQ7qjnZ-QdwSBLBsjAUDndKh_ER7eWb6Sfw9uDWmoOwrzS0qCyk9Av6WojamUQ0SRWHJUGR4r1dLmX1vjWEG2-dx1sI35Pw-XmOcQFPYKGF61J3lJV1otaoVtxilIE_ucu-XNjXK9h4QtTQErnypuTYyfpLGeOFINVJ1j4mBM8y-_g76ttKwbBGs3qNucgx2yAxep04GLfEHsVIhm0tkZwQhZ6p');
      background-size: cover;
      background-position: center;
      opacity: 0.3;
      mix-blend-mode: luminosity;
      z-index: 0;
    }
    .left-panel-content {
      position: relative;
      z-index: 10;
    }
</style>
</head>
<body class="bg-full-overlay min-h-screen flex items-center justify-center p-4 sm:p-8 antialiased">

<!-- INÍCIO: Contêiner Principal de Cadastro -->
<main class="w-full max-w-[1080px] h-[620px] bg-white rounded-[24px] shadow-2xl flex overflow-hidden relative z-10">

<!-- INÍCIO: Painel Esquerdo (Branding e Apresentação) -->
<section class="w-full md:w-1/2 left-panel-bg text-white p-12 md:p-16 lg:p-24 flex flex-col justify-between overflow-hidden">
<div class="left-panel-content flex items-center space-x-3 mb-16">
<!-- Logo SVG -->
<svg class="text-white fill-current" fill="none" height="24" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M12 2C8.13401 2 5 5.13401 5 9C5 12.012 6.84834 14.597 9.5 15.603V22H14.5V15.603C17.1517 14.597 19 12.012 19 9C19 5.13401 15.866 2 12 2ZM12 4C14.7614 4 17 6.23858 17 9C17 10.9996 15.8273 12.724 14.125 13.524V10.5H9.875V13.524C8.17269 12.724 7 10.9996 7 9C7 6.23858 9.23858 4 12 4Z"></path>
</svg>
<span class="text-2xl font-bold tracking-wide">Inogás</span>
</div>
<div class="left-panel-content mt-auto">
<!-- Texto Principal -->
<h1 class="text-4xl md:text-5xl lg:text-[56px] leading-[1.1] font-medium mb-6">Precisão industrial.<br/>Proteção Ambiental.</h1>
<p class="text-[#A5D0B9] text-base md:text-lg max-w-md leading-relaxed opacity-90">
          Utilize nossas redes de sensores avançadas para manter a conformidade regulatória e garantir a segurança operacional.
        </p>
</div>
</section>
<!-- FIM: Painel Esquerdo -->
<!-- INÍCIO: Painel Direito (Formulário de Cadastro) -->
<section class="w-full md:w-1/2 bg-white p-12 md:p-16 lg:p-24 flex flex-col justify-center">
<div class="max-w-md w-full mx-auto">
<!-- Cabeçalho do Formulário -->
<div class="mb-10">
<h2 class="text-3xl font-medium text-inogas-text mb-2">Criar Conta</h2>
<p class="text-inogas-subtext text-sm form-text">
          Registre-se no Inogás para monitoramento ambiental em tempo real.
        </p>
</div>
<!-- Formulário de Cadastro -->
<form action="#" method="POST" class="space-y-6">
<!-- Campo de Nome Completo -->
<div>
<label class="block text-sm font-medium text-inogas-text mb-2 form-text" for="fullName">Nome Completo</label>
<div class="relative">
<div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
<svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
</div>
<input class="block w-full pl-10 pr-3 py-3 border border-inogas-border rounded-md leading-5 bg-inogas-input-bg placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-inogas-dark focus:border-inogas-dark sm:text-sm form-text transition duration-150 ease-in-out" id="fullName" name="fullName" placeholder="João da Silva" type="text"/>
</div>
</div>
<!-- Campo de E-mail -->
<div>
<label class="block text-sm font-medium text-inogas-text mb-2 form-text" for="email">E-mail</label>
<div class="relative">
<div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
<svg aria-hidden="true" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
</div>
<input class="block w-full pl-10 pr-3 py-3 border border-inogas-border rounded-md leading-5 bg-inogas-input-bg placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-inogas-dark focus:border-inogas-dark sm:text-sm form-text transition duration-150 ease-in-out" id="email" name="email" placeholder="gestor@gmail.com" type="email"/>
</div>
</div>
<!-- Campo de Senha -->
<div>
<label class="block text-sm font-medium text-inogas-text mb-2 form-text" for="password">Senha</label>
<div class="relative">
<div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
<svg aria-hidden="true" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
</div>
<input class="block w-full pl-10 pr-12 py-3 border border-inogas-border rounded-md leading-5 bg-inogas-input-bg placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-inogas-dark focus:border-inogas-dark sm:text-sm form-text transition duration-150 ease-in-out" id="password" name="password" placeholder="••••••••" type="password"/>
<button class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600" type="button">
<svg class="h-5 w-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
<path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
<path d="M3 3l18 18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
</button>
</div>
</div>
<!-- Campo de Confirmação de Senha -->
<div>
<label class="block text-sm font-medium text-inogas-text mb-2 form-text" for="confirmPassword">Confirme a senha</label>
<div class="relative">
<div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
<svg aria-hidden="true" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
</div>
<input class="block w-full pl-10 pr-12 py-3 border border-inogas-border rounded-md leading-5 bg-inogas-input-bg placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-inogas-dark focus:border-inogas-dark sm:text-sm form-text transition duration-150 ease-in-out" id="confirmPassword" name="confirmPassword" placeholder="••••••••" type="password"/>
<button class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600" type="button">
<svg class="h-5 w-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
<path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
<path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
<path d="M3 3l18 18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
</button>
</div>
</div>
<!-- Botão de Envio -->
<div class="mt-8">
<button class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-inogas-dark hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-inogas-dark transition duration-150 ease-in-out form-text" type="submit">
          Criar Conta
        </button>
</div>
</form>
<!-- Rodapé do Formulário -->
<div class="mt-8 text-center">
<p class="text-sm text-inogas-subtext form-text">
        Já possui uma conta?
        <a class="font-medium text-inogas-link hover:underline ml-1" href="login">
          Voltar para Login
        </a>
</p>
</div>
</div>
</section>
<!-- FIM: Painel Direito -->
</main>
<!-- FIM: Contêiner Principal de Cadastro -->
</body></html>