<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leitura;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class HistoricoController extends Controller
{   
    public function historico(Request $request)
    {
        if (!session()->has('usuario_id')) {
        return redirect('/login');
        }

        $query = Leitura::where('valor', '>', 200);

        if ($request->filled('inicio')) {
            $query->whereDate('created_at', '>=', $request->input('inicio'));
        }

        if ($request->filled('fim')) {
            $query->whereDate('created_at', '<=', $request->input('fim'));
        }

        $alertas = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('historico', compact('alertas'));
    }


    public function export(Request $request)
    {
        if (!session()->has('usuario_id')) {
            return redirect('/login');
        }

        $query = Leitura::where('valor', '>', 200);

        if ($request->filled('inicio')) {
            $query->whereDate('created_at', '>=', $request->input('inicio'));
        }
        if ($request->filled('fim')) {
            $query->whereDate('created_at', '<=', $request->input('fim'));
        }

        $alertas = $query->orderBy('created_at', 'desc')->get();

        $pdf = PDF::loadView('historico_pdf', compact('alertas'));
        return $pdf->download('historico_'.now()->format('Ymd_His').'.pdf');
    }
}
