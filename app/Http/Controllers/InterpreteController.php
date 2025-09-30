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
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
        ]);

        return Interprete::create([
            'id_medecin' => $request->id_medecin,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
        ]);
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
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
        ]);

        $interprete->update([
            'id_medecin' => $request->id_medecin,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
        ]);

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
