<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

use App\Models\Medecin;
use Illuminate\Http\Request;

class MedecinController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/medecins",
     *     summary="Liste des médecins",
     *     tags={"Médecins"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des médecins récupérée avec succès"
     *     )
     * )
     */
    public function index()
    {
        return Medecin::all();
    }

    /**
     * @OA\Post(
     *     path="/api/medecins",
     *     summary="Créer un nouveau médecin",
     *     tags={"Médecins"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nom","prenom"},
     *             @OA\Property(property="nom", type="string"),
     *             @OA\Property(property="prenom", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Médecin créé avec succès"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
        ]);

        return Medecin::create($request->all());
    }

    /**
     * @OA\Get(
     *     path="/api/medecins/{id}",
     *     summary="Afficher un médecin",
     *     tags={"Médecins"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Médecin trouvé"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Médecin non trouvé"
     *     )
     * )
     */
    public function show($id)
    {
        return Medecin::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/medecins/{id}",
     *     summary="Mettre à jour un médecin",
     *     tags={"Médecins"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nom","prenom"},
     *             @OA\Property(property="nom", type="string"),
     *             @OA\Property(property="prenom", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Médecin mis à jour avec succès"
     *     )
     * )
     */
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
     * @OA\Delete(
     *     path="/api/medecins/{id}",
     *     summary="Supprimer un médecin",
     *     tags={"Médecins"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Médecin supprimé avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Médecin non trouvé"
     *     )
     * )
     */
    public function destroy($id)
    {
        $medecin = Medecin::findOrFail($id);
        $medecin->delete();

        return response()->json(['message' => 'Supprimé avec succès']);
    }
}
