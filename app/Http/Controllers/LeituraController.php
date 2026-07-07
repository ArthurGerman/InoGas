<?php

namespace App\Http\Controllers;

use App\Models\Leitura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LeituraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            Leitura::all()
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'valor' => 'required|numeric',
            'status' => 'required|string|max:100'
        ]);

        if ($dados['valor'] <= 200) {
            return response()->json(['mensagem' => 'Sem alerta de gás'], 204);
        }

        $leitura = Leitura::create($dados);

        return response()->json($leitura, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $leitura = Leitura::findOrFail($id);

        return response()->json($leitura);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $leitura = Leitura::findOrFail($id);

        $leitura->delete();

        return response()->json([
            'mensagem' => 'Leitura removida com sucesso'
        ]);
    }

    /**
     * Get aggregated report data by period
     */
    public function relatorio(Request $request)
    {
        $periodo = $request->query('periodo', 'dia');
        $query = Leitura::query();
        
        $formato_data = '%H:%i'; // padrão: hora:minuto
        $label_periodo = '';

        switch ($periodo) {
            case 'hora':
                // Últimas 60 minutos, agrupadas por minuto
                $query->where('created_at', '>=', Carbon::now()->subHours(1));
                $formato_data = '%H:%i';
                $label_periodo = 'Minuto';
                break;

            case 'dia':
                // Últimas 24 horas, agrupadas por hora
                $query->where('created_at', '>=', Carbon::now()->subHours(24));
                $formato_data = '%d/%m %H:%i';
                $label_periodo = 'Hora';
                break;

            case 'semana':
                // Última semana, agrupadas por dia
                $query->where('created_at', '>=', Carbon::now()->subDays(7));
                $formato_data = '%d/%m';
                $label_periodo = 'Dia';
                break;

            case 'mes':
                // Último mês, agrupadas por dia
                $query->where('created_at', '>=', Carbon::now()->subDays(30));
                $formato_data = '%d/%m';
                $label_periodo = 'Dia';
                break;

            case 'ano':
                // Último ano, agrupadas por mês
                $query->where('created_at', '>=', Carbon::now()->subYear());
                $formato_data = '%m/%Y';
                $label_periodo = 'Mês';
                break;

            default:
                $query->where('created_at', '>=', Carbon::now()->subHours(24));
                $formato_data = '%d/%m %H:%i';
                $label_periodo = 'Hora';
        }

        // Agrupar dados e calcular média
        $dados = $query
            ->selectRaw("DATE_FORMAT(created_at, '$formato_data') as periodo")
            ->selectRaw('AVG(valor) as valor')
            ->selectRaw('MIN(created_at) as min_created')
            ->groupByRaw("DATE_FORMAT(created_at, '$formato_data')")
            ->orderBy('min_created', 'asc')
            ->get()
            ->toArray();
            /*
            ->selectRaw("DATE_FORMAT(created_at, ?) as periodo", [$formato_data])
            ->selectRaw('AVG(valor) as valor')
            ->groupByRaw("DATE_FORMAT(created_at, ?)", [$formato_data])
            ->orderBy('created_at', 'asc')
            ->get()
            ->toArray();
            */

        return response()->json($dados);
    }
}

