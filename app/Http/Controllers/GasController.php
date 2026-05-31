<?php

namespace App\Http\Controllers;

use App\Models\Gas;
use Illuminate\Http\Request;

class GasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            Gas::with('leituras')->get()
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
            'gas_nome' => 'required|string|max:255',
            'gas_niv_tox' => 'required|in:baixo,médio,alto,extremo'
        ]);

        $gas = Gas::create($dados);

        return response()->json($gas, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $gas = Gas::with('leituras')->findOrFail($id);

        return response()->json($gas);
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
        $gas = Gas::findOrFail($id);

        $dados = $request->validate([
            'gas_nome' => 'sometimes|string|max:255',
            'gas_niv_tox' => 'sometimes|in:baixo,médio,alto,extremo'
        ]);

        $gas->update($dados);

        return response()->json($gas);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gas = Gas::findOrFail($id);

        $gas->delete();

        return response()->json([
            'mensagem' => 'Gás removido com sucesso'
        ]);
    }
}
