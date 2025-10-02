<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

use App\Models\Interprete;
use Illuminate\Http\Request;

class InterpreteController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/interpretres",
     *     summary="Liste des interprètes",
     *     tags={"Interprètes"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste récupérée avec succès"
     *     )
     * )
     */
    public function index()
    {
        return Interprete::all();
    }

    /**
     * @OA\Post(
     *     path="/api/interpretres",
     *     summary="Créer un interprète",
     *     tags={"Interprètes"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_medecin","nom","prenom"},
     *             @OA\Property(property="id_medecin", type="integer"),
     *             @OA\Property(property="nom", type="string"),
     *             @OA\Property(property="prenom", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Interprète créé avec succès"
     *     )
     * )
     */
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
     * @OA\Get(
     *     path="/api/interpretres/{id}",
     *     summary="Afficher un interprète",
     *     tags={"Interprètes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Interprète trouvé"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Interprète non trouvé"
     *     )
     * )
     */
    public function show($id)
    {
        return Interprete::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/interpretres/{id}",
     *     summary="Modifier un interprète",
     *     tags={"Interprètes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_medecin","nom","prenom"},
     *             @OA\Property(property="id_medecin", type="integer"),
     *             @OA\Property(property="nom", type="string"),
     *             @OA\Property(property="prenom", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Interprète mis à jour"
     *     )
     * )
     */
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
     * @OA\Delete(
     *     path="/api/interpretres/{id}",
     *     summary="Supprimer un interprète",
     *     tags={"Interprètes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Interprète supprimé"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Interprète non trouvé"
     *     )
     * )
     */
    public function destroy($id)
    {
        $interprete = Interprete::findOrFail($id);
        $interprete->delete();
        return response()->json(['message' => 'Supprimé avec succès']);
    }
}
