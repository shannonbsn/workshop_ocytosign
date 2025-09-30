<?php

namespace App\Http\Controllers;

use App\Models\Interprete;
use Illuminate\Http\Request;

class InterpreteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // GET /api/interpretres
    public function index()
    {
        return Interprete::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    // POST /api/interpretres
    public function store(Request $request)
    {
        $request->validate([
            'id_medecin' => 'required|exists:medecins,id_medecin',
        ]);

        return Interprete::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    // GET /api/interpretres/{id}
    public function show($id)
    {
        return Interprete::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    // PUT /api/interpretres/{id}
    public function update(Request $request, $id)
    {
        $interprete = Interprete::findOrFail($id);
        $request->validate([
            'id_medecin' => 'required|exists:medecins,id_medecin',
        ]);

        $interprete->update($request->all());
        return $interprete;
    }

    /**
     * Remove the specified resource from storage.
     */
    // DELETE /api/interpretres/{id}
    public function destroy($id)
    {
        $interprete = Interprete::findOrFail($id);
        $interprete->delete();
        return response()->json(['message' => 'Supprimé avec succès']);
    }
}
