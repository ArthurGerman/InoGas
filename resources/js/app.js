import Chart from 'chart.js/auto';

window.Chart = Chart;

// Perfil de visualização.
// O papel (responsável ou morador) vem da CONTA e chega pelo atributo data-papel da tag <html>.
// O responsável pode PRÉ-VISUALIZAR como morador com o botão "Ver como morador". Isso só esconde
// blocos na tela, vale só nesta aba e não muda nada na conta.
// Blocos marcados com data-so="responsavel" ou data-so="morador" aparecem só para aquela visão
// (a regra está em resources/css/app.css).
const CHAVE_PREVIEW = 'inogas:preview-morador';

function papelDaConta() {
    return document.documentElement.dataset.papel === 'morador' ? 'morador' : 'responsavel';
}

function lerPreview() {
    try {
        return sessionStorage.getItem(CHAVE_PREVIEW) === '1';
    } catch (e) {
        return false;
    }
}

function aplicar() {
    const papel = papelDaConta();
    const preview = papel === 'responsavel' && lerPreview();
    document.documentElement.dataset.perfil = papel === 'morador' || preview ? 'morador' : 'responsavel';
    document.querySelectorAll('[data-preview-btn]').forEach((botao) => {
        botao.setAttribute('aria-pressed', preview ? 'true' : 'false');
    });
}

// Limpezas: ao abrir login ou cadastro, apaga a pré-visualização; e apaga a chave antiga do seletor provisório.
try {
    const caminho = location.pathname.replace(/\/+$/, '');
    if (['/login', '/cadastro'].includes(caminho)) sessionStorage.removeItem(CHAVE_PREVIEW);
    localStorage.removeItem('inogas:perfil');
} catch (e) {
    /* sem armazenamento: nada a apagar */
}

aplicar();

document.addEventListener('DOMContentLoaded', () => {
    aplicar();

    document.querySelectorAll('[data-preview-btn]').forEach((botao) => {
        botao.addEventListener('click', () => {
            try {
                if (lerPreview()) sessionStorage.removeItem(CHAVE_PREVIEW);
                else sessionStorage.setItem(CHAVE_PREVIEW, '1');
            } catch (e) {
                /* sem armazenamento: a pré-visualização não dura */
            }
            aplicar();
        });
    });
});

// Ajudante para as telas enviarem dados ao servidor (POST em JSON, com o token CSRF do Laravel).
// Devolve { ok, status, corpo }. Nunca lança erro por resposta 4xx ou 5xx.
window.inogasEnviar = async function (url, dados = {}) {
    const meta = document.querySelector('meta[name="csrf-token"]');
    const resposta = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': meta ? meta.content : '',
        },
        body: JSON.stringify(dados),
    });
    let corpo = null;
    try {
        corpo = await resposta.json();
    } catch (e) {
        /* resposta sem JSON */
    }
    return { ok: resposta.ok, status: resposta.status, corpo };
};

// ---------------------------------------------------------------------------
// Janelas do InoGas (no lugar dos pop-ups feios do navegador).
//
//   await window.inogasConfirmar({ titulo, texto, confirmar, cancelar, perigo })   -> true ou false
//   await window.inogasPerguntar({ titulo, texto, rotulo, valor, confirmar })      -> texto digitado ou null
//   await window.inogasAviso({ titulo, texto, destaque, confirmar, naoFecharFora }) -> quando a pessoa fecha
//
// "destaque" mostra um texto em caixa própria, com botão Copiar (ex.: senha temporária ou token).
// "naoFecharFora" impede fechar com Esc ou clicando fora (para coisas que aparecem uma única vez).
// Usa o elemento nativo <dialog>: o foco fica preso na janela e o Esc fecha.
// ---------------------------------------------------------------------------
function criarJanela(opcoes) {
    const {
        titulo = '',
        texto = '',
        rotulo = '',
        valor = '',
        destaque = '',
        confirmar = 'OK',
        cancelar = 'Cancelar',
        perigo = false,
        comCampo = false,
        comCancelar = true,
        naoFecharFora = false,
    } = opcoes;

    return new Promise((resolve) => {
        const idTitulo = 'janela-titulo-' + Math.random().toString(36).slice(2);
        const dialogo = document.createElement('dialog');
        dialogo.className = 'm-auto rounded-xl border border-line bg-panel p-0 text-ink shadow-2xl backdrop:bg-black/60';
        dialogo.setAttribute('aria-labelledby', idTitulo);

        const caixa = document.createElement('form');
        caixa.method = 'dialog';
        caixa.className = 'w-[min(28rem,calc(100vw-2rem))] p-6';

        const h = document.createElement('h2');
        h.id = idTitulo;
        h.className = 'text-lg font-semibold';
        h.textContent = titulo;
        caixa.append(h);

        if (texto) {
            const p = document.createElement('p');
            p.className = 'mt-2 text-sm text-soft';
            p.textContent = texto;
            caixa.append(p);
        }

        let campo = null;
        if (comCampo) {
            const r = document.createElement('label');
            r.className = 'mt-4 block text-sm font-medium';
            r.textContent = rotulo;
            campo = document.createElement('input');
            campo.type = 'text';
            campo.value = valor;
            campo.autocomplete = 'off';
            campo.className = 'mt-1.5 w-full rounded-lg border border-line bg-canvas px-3.5 py-2.5 text-sm text-ink';
            r.append(campo);
            caixa.append(r);
        }

        if (destaque) {
            const linha = document.createElement('div');
            linha.className = 'mt-4 flex items-center gap-2';
            const caixaTexto = document.createElement('code');
            caixaTexto.className = 'min-w-0 flex-1 rounded-lg border border-line bg-canvas px-3 py-2.5 text-sm break-all select-all';
            caixaTexto.textContent = destaque;
            const copiar = document.createElement('button');
            copiar.type = 'button';
            copiar.className = 'shrink-0 rounded-lg border border-line px-3 py-2 text-xs font-medium transition-colors hover:border-brand/40';
            copiar.textContent = 'Copiar';
            copiar.addEventListener('click', async () => {
                try {
                    await navigator.clipboard.writeText(destaque);
                    copiar.textContent = 'Copiado';
                } catch (e) {
                    const faixa = document.createRange();
                    faixa.selectNodeContents(caixaTexto);
                    const selecao = window.getSelection();
                    selecao.removeAllRanges();
                    selecao.addRange(faixa);
                }
            });
            linha.append(caixaTexto, copiar);
            caixa.append(linha);
        }

        const rodape = document.createElement('div');
        rodape.className = 'mt-6 flex flex-wrap justify-end gap-3';

        let botaoCancelar = null;
        if (comCancelar) {
            botaoCancelar = document.createElement('button');
            botaoCancelar.type = 'button';
            botaoCancelar.className = 'rounded-lg border border-line px-4 py-2.5 text-sm font-medium text-soft transition-colors hover:text-ink';
            botaoCancelar.textContent = cancelar;
            rodape.append(botaoCancelar);
        }

        const botaoConfirmar = document.createElement('button');
        botaoConfirmar.type = 'submit';
        botaoConfirmar.className = perigo
            ? 'rounded-lg bg-risk px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-risk/90'
            : 'rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-brand-ink transition-colors hover:bg-brand/90';
        botaoConfirmar.textContent = confirmar;
        rodape.append(botaoConfirmar);

        caixa.append(rodape);
        dialogo.append(caixa);

        let resultado = null;
        const fechar = (v) => {
            resultado = v;
            dialogo.close();
        };

        caixa.addEventListener('submit', (e) => {
            e.preventDefault();
            fechar(comCampo ? campo.value : true);
        });
        if (botaoCancelar) botaoCancelar.addEventListener('click', () => fechar(null));

        dialogo.addEventListener('cancel', (e) => {
            if (naoFecharFora) e.preventDefault();
        });
        dialogo.addEventListener('click', (e) => {
            if (e.target === dialogo && !naoFecharFora) fechar(null);
        });
        dialogo.addEventListener('close', () => {
            dialogo.remove();
            resolve(resultado);
        });

        document.body.append(dialogo);
        dialogo.showModal();

        // Foco: em ações perigosas começa no "Cancelar", para um Enter sem querer não apagar nada.
        if (campo) {
            campo.focus();
            campo.select();
        } else if (perigo && botaoCancelar) {
            botaoCancelar.focus();
        } else {
            botaoConfirmar.focus();
        }
    });
}

window.inogasConfirmar = async (opcoes) => (await criarJanela({ ...opcoes })) === true;
window.inogasPerguntar = (opcoes) => criarJanela({ ...opcoes, comCampo: true });
window.inogasAviso = (opcoes) => criarJanela({ ...opcoes, comCancelar: false });
