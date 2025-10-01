<?php

namespace App\Http\Controllers;

use App\Models\ModelRdv;
use Illuminate\Http\Request;

class ModelRdvController extends Controller
{
    // Liste tous les RDVs
    public function index()
    {
        return response()->json(ModelRdv::all());
    }

    // Crée un nouveau RDV
    public function store(Request $request)
    {
        $data = $request->only([
            'id_client',
            'id_medecin',
            'id_interprete',
            'date_debut',
            'date_fin',
            'presentiel'
    ]);

    $rdv = ModelRdv::create($data);
    return response()->json($rdv, 201);
}


    // Affiche un RDV précis
    public function show($id)
    {
        $rdv = ModelRdv::findOrFail($id);
        return response()->json($rdv);
    }

    // Met à jour un RDV
    public function update(Request $request, $id)
    {
        $rdv = ModelRdv::findOrFail($id);
        $rdv->update($request->all());
        return response()->json($rdv);
    }

    // Supprime un RDV
    public function destroy($id)
    {
        $rdv = ModelRdv::findOrFail($id);
        $rdv->delete();
        return response()->json(['message' => 'RDV supprimé avec succès']);
    }
}
