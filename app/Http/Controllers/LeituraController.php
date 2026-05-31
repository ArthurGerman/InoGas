<?php

namespace App\Http\Controllers;

use App\Models\Leitura;
use Illuminate\Http\Request;

class LeituraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            Leitura::with('gas')->get()
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
            'gas_id' => 'required|exists:gases,id',
            'valor' => 'required|numeric',
            'status' => 'required|string|max:100'
        ]);

        $leitura = Leitura::create($dados);

        return response()->json($leitura, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $leitura = Leitura::with('gas')->findOrFail($id);

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
    public function update(Request $request, string $id)
    {
        $leitura = Leitura::findOrFail($id);

        $dados = $request->validate([
            'gas_id' => 'sometimes|exists:gases,id',
            'valor' => 'sometimes|numeric',
            'status' => 'sometimes|string|max:100'
        ]);

        $leitura->update($dados);

        return response()->json($leitura);
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
}
