<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\Usuario;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;

/**
 * Exporta o Histórico de alertas em PDF (mesmos filtros "inicio" e "fim" da tela).
 * Só o responsável exporta, e só os alertas que ele pode ver. No máximo 500 linhas por arquivo.
 */
class HistoricoPdfController extends Controller
{
    private const LIMITE = 500;

    public function gerar(Request $request)
    {
        $request->validate([
            'inicio' => 'nullable|date',
            'fim' => 'nullable|date',
        ]);

        $usuario = Usuario::findOrFail((int) session('usuario_id'));

        $consulta = Alerta::visiveis();

        if ($request->filled('inicio')) {
            $consulta->whereDate('created_at', '>=', $request->input('inicio'));
        }

        if ($request->filled('fim')) {
            $consulta->whereDate('created_at', '<=', $request->input('fim'));
        }

        $total = (clone $consulta)->count();

        $alertas = $consulta
            ->withCount('confirmacoes')
            ->with(['silenciadoPor:id,name', 'local:id,nome'])
            ->orderByDesc('created_at')
            ->limit(self::LIMITE)
            ->get();

        $linhas = $alertas->map(fn (Alerta $a) => [
            'inicio' => optional($a->iniciado_em ?? $a->created_at)->format('d/m/Y H:i:s'),
            'duracao' => $a->encerrado_em ? $a->duracaoTexto() : 'Em andamento',
            'local' => optional($a->local)->nome ?? '—',
            'pico' => $a->pico_bruto,
            'nivel' => $a->nivel === 'risco' ? 'Risco' : 'Atenção',
            'teste' => (bool) $a->simulado,
            'confirmacoes' => $a->confirmacoes_count,
            'silenciado' => $a->silenciado_em
                ? (optional($a->silenciadoPor)->name ?? 'Conta removida') . ' às ' . $a->silenciado_em->format('H:i')
                : '—',
        ])->all();

        $html = view('pdf.historico', [
            'periodo' => $this->textoDoPeriodo($request->input('inicio'), $request->input('fim')),
            'geradoEm' => now()->format('d/m/Y H:i'),
            'usuario' => $usuario->name,
            'total' => $total,
            'limite' => self::LIMITE,
            'cortado' => $total > self::LIMITE,
            'linhas' => $linhas,
            'unidade' => config('inogas.unidade.calibrado') ? (config('inogas.unidade.sufixo') ?: 'ppm') : 'sinal bruto',
        ])->render();

        $opcoes = new Options();
        $opcoes->set('defaultFont', 'DejaVu Sans');
        $opcoes->set('isRemoteEnabled', false);
        $opcoes->set('isPhpEnabled', false);

        $pdf = new Dompdf($opcoes);
        $pdf->loadHtml($html, 'UTF-8');
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        $nome = 'inogas-alertas-' . now()->format('Y-m-d') . '.pdf';

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $nome . '"',
        ]);
    }

    private function textoDoPeriodo(?string $inicio, ?string $fim): string
    {
        $formatar = fn (string $d) => date('d/m/Y', strtotime($d));

        if ($inicio && $fim) {
            return 'de ' . $formatar($inicio) . ' a ' . $formatar($fim);
        }

        if ($inicio) {
            return 'a partir de ' . $formatar($inicio);
        }

        if ($fim) {
            return 'até ' . $formatar($fim);
        }

        return 'todos os alertas';
    }
}
