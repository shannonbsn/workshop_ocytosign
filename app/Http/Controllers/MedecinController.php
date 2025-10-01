<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use Illuminate\Http\Request;

class MedecinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // GET /medecins
    public function index()
    {
        return Medecin::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    // POST /medecins
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
        ]);

        return Medecin::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    // GET /medecins/{id}
    public function show($id)
    {
        return Medecin::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    // PUT /medecins/{id}
    public function update(Request $request, $id)
    {
        $medecin = Medecin::findOrFail($id);

        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
        ]);

        $medecin->update($request->all());
        return $medecin;
    }

    /**
     * Remove the specified resource from storage.
     */
    // DELETE /medecins/{id}
    public function destroy($id)
    {
        $medecin = Medecin::findOrFail($id);
        $medecin->delete();

        return response()->json(['message' => 'Supprimé avec succès']);
    }
}
