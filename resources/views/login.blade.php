<!-- ============================================================================= -->
<!-- ARQUIVO: login.blade.php - Página de Login do Sistema Inogas              -->
<!-- DESCRIÇÃO: Interface de autenticação com design responsivo, utilizando     -->
<!--            Tailwind CSS e fontes serif para uma aparência refinada         -->
<!-- ============================================================================= -->

<!DOCTYPE html>

<html lang="pt-BR">
<head>
  <!-- ===== SEÇÃO: Configuração Meta Tags ===== -->
  <!-- Define o conjunto de caracteres (UTF-8) e viewport para responsividade -->
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>Inogas - Acesso ao Sistema</title>
  
  <!-- ===== SEÇÃO: Importação de Fontes ===== -->
  <!-- Importa a fonte Lora do Google Fonts (alternativa elegante à Libertinus Serif) -->
  <link href="https://fonts.googleapis.com" rel="preconnect"/>
  <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
  <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400&amp;display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

<!-- Configuração do Tailwind CSS para que a paleta de cores, a tipografia e o espaçamento do design correspondam o mais fielmente possível à imagem fornecida. -->
<script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'inogas-dark-green': '#052F20', // Cor combinada da imagem
            'inogas-light-green': '#A5D0B9', // Cor de destaque para texto e elementos secundários
            'inogas-bg': '#3C5C4D', // Aproximação da cor de fundo
            'inogas-text-dark': '#1F2937', // Cor do texto principal
            'inogas-text-light': '#6B7280', // Cor do texto secundário
            'inogas-border': '#D1D5DB', // Cor da borda
            'inogas-input-bg': '#F9FAFB', // Cor de fundo dos campos de entrada
            'inogas-link': '#0284C7', // Azul aproximado para links
          },
          fontFamily: {
            'serif': ['"Libertinus Serif"', 'Lora', 'Georgia', 'serif'],
            'sans': ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'sans-serif'],
          },
          borderRadius: {
            'xl': '24px',
          }
        }
      }
    }
  </script>

 <!-- Estilos personalizados para garantir que a fonte e outros elementos de design específicos correspondam à imagem o mais fielmente possível. -->
<style data-purpose="custom-styles">
    body {
      font-family: 'Lora', 'Libertinus Serif', Georgia, serif; /* Aplica serif globalmente pois parece predominante em cabeçalhos e texto */
    }
    
    /* Estilo do placeholder de entrada para combinar com a fonte da imagem */
    input::placeholder {
      font-family: 'Lora', 'Libertinus Serif', Georgia, serif;
      color: #9CA3AF;
    }
    
    /* Garanta que o texto do formulário também seja serif */
    .form-text {
      font-family: 'Lora', 'Libertinus Serif', Georgia, serif;
    }
  </style>

</head>
<body class="bg-inogas-bg min-h-screen flex items-center justify-center p-4 sm:p-8" style="background-image: url('/images/fundo1.png'); background-size: cover; background-position: center;">
 <div class="absolute inset-0 bg-gradient-to-b from-[#012D1D]/80  to-[#1B4332]/90"></div>
  <!-- INÍCIO: Contêiner Principal de Login -->
<main class="w-full max-w-[1080px] bg-white rounded-[24px] shadow-2xl flex flex-col md:flex-row overflow-hidden relative z-10" style="min-height: 620px;">

<!-- INÍCIO: Painel de Branding à Esquerda -->
<section class="w-full md:w-1/2 relative bg-inogas-dark-green text-white p-12 md:p-16 lg:p-10 flex flex-col justify-between overflow-hidden" style="background-image: url('/images/fundo1.png'); background-size: cover; background-position: center;">

<!-- Sobreposição de Imagem de Fundo do Painel Esquerdo (Simulando o fundo industrial mesclado) -->
<!-- Em um cenário real, você extrairia a parte esquerda da imagem ou usaria uma imagem separada. Aqui usamos uma sobreposição de gradiente CSS para simular a profundidade mostrada no design sobre uma base verde escura. -->
<div class="absolute inset-0 bg-gradient-to-b from-[#012D1D]/90  to-[#1B4332]/95 z-0 pointer-events-none"></div>

<!-- Área do Logo -->
<div class="relative z-10 flex items-center space-x-3 mb-16">

<!-- Logo SVG (Aproximação da folha) -->
<svg class="text-white fill-current" fill="none" height="24" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
<path d="M12 2C8.13401 2 5 5.13401 5 9C5 12.012 6.84834 14.597 9.5 15.603V22H14.5V15.603C17.1517 14.597 19 12.012 19 9C19 5.13401 15.866 2 12 2ZM12 4C14.7614 4 17 6.23858 17 9C17 10.9996 15.8273 12.724 14.125 13.524V10.5H9.875V13.524C8.17269 12.724 7 10.9996 7 9C7 6.23858 9.23858 4 12 4Z"></path>
</svg>
<span class="text-2xl font-bold tracking-wide">Inogas</span>
</div>

<!-- Área de Cabeçalho Principal -->
<div class="relative z-10 mt-auto">
<h1 class="text-4xl md:text-5xl lg:text-[36px] leading-[1.1] font-medium mb-8">
          Inteligência Ambiental Contínua.
        </h1>
<p class="text-[#A5D0B9] text-base md:text-[14px] max-w-md leading-relaxed opacity-90">
          Monitoramento de qualidade do ar em tempo real, calibrado para as exigências da indústria moderna. Dados precisos para decisões sustentáveis.
        </p>
</div>
</section>
<!-- FIM: Painel de Branding à Esquerda -->

<!-- INÍCIO: Painel de Formulário de Login à Direita -->
<section class="w-full md:w-1/2 bg-white p-12 md:p-16 lg:p-4 flex flex-col justify-center">
<div class="max-w-md w-full mx-auto">

<!-- Cabeçalho do Formulário -->
<div class="mb-10">
<h2 class="text-3xl font-medium text-inogas-text-dark mb-2">Acesso ao Sistema</h2>
<p class="text-inogas-text-light text-sm form-text">Insira suas credenciais para visualizar a matriz de sensores.</p>
</div>

<!-- Formulário de Login -->
<form action="#" class="space-y-6" method="POST">

<!-- Campo de Email -->
<div>
<label class="block text-sm font-medium text-inogas-text-dark mb-2 form-text" for="email">E-mail</label>
<div class="relative">
<div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
<svg aria-hidden="true" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
</div>
<input class="block w-full pl-10 pr-3 py-3 border border-inogas-border rounded-md leading-5 bg-inogas-input-bg placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-inogas-dark-green focus:border-inogas-dark-green sm:text-sm form-text transition duration-600 ease-in-out" id="email" name="email" placeholder="gestor@gmail.com" required="" type="email"/>
</div>
</div>

<!-- Campo de Senha -->
<div>
<label class="block text-sm font-medium text-inogas-text-dark mb-2 form-text" for="password">Senha de Acesso</label>
<div class="relative">
<div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
<svg aria-hidden="true" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
</div>
<input class="block w-full pl-10 pr-3 py-3 border border-inogas-border rounded-md leading-5 bg-inogas-input-bg placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-inogas-dark-green focus:border-inogas-dark-green sm:text-sm form-text transition duration-600 ease-in-out" id="password" name="password" placeholder="••••••••" required="" type="password"/>
</div>
</div>

<!-- Lembrar-me e Esqueci a Senha -->
<div class="flex items-center justify-between mt-6 mb-8">
<div class="flex items-center">
<input class="h-4 w-4 text-inogas-dark-green focus:ring-inogas-dark-green border-gray-300 rounded" id="remember-me" name="remember-me" type="checkbox"/>
<label class="ml-2 block text-sm text-inogas-text-light form-text" for="remember-me">
                Lembrar credenciais
              </label>
</div>
<div class="text-sm">
<a class="font-medium text-inogas-link hover:underline form-text" href="#">
                Esqueci minha senha
              </a>
</div>
</div>

<!-- Botão de Envio -->
<div>
<button class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-inogas-dark-green hover:bg-[#031c13] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-inogas-dark-green transition duration-900 ease-in-out form-text" type="submit">
              Acessar Plataforma
              <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
</button>
</div>
</form>

<!-- Divisor -->
<div class="mt-8 relative">
<div aria-hidden="true" class="absolute inset-0 flex items-center">
<div class="w-full border-t border-gray-200"></div>
</div>
<div class="relative flex justify-center">
<span class="px-2 bg-white text-xs text-gray-400 form-text">
              Acesso Restrito
            </span>
</div>
</div>

<!-- Link de Registro -->
<div class="mt-6 text-center">
<p class="text-sm text-inogas-text-light form-text">
            Novo gestor operacional? 
            <a class="font-medium text-inogas-link hover:underline" href="cadastro">
              Cadastre-se Aqui!
            </a>
</p>
</div>
</div>
</section>
<!-- FIM: Painel de Formulário de Login à Direita -->
</main>
<!-- FIM: Contêiner Principal de Login -->
</body></html>