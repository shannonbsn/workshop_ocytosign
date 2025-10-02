<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

use App\Models\ModelRdv;
use Illuminate\Http\Request;

class ModelRdvController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/rdvs",
     *     summary="Liste tous les RDVs",
     *     tags={"RDV"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des RDVs récupérée avec succès"
     *     )
     * )
     */
    public function index()
    {
        return response()->json(ModelRdv::all());
    }

    /**
     * @OA\Post(
     *     path="/api/rdvs",
     *     summary="Créer un nouveau RDV",
     *     tags={"RDV"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_client","id_medecin","date_debut","date_fin","presentiel"},
     *             @OA\Property(property="id_client", type="integer"),
     *             @OA\Property(property="id_medecin", type="integer"),
     *             @OA\Property(property="id_interprete", type="integer"),
     *             @OA\Property(property="date_debut", type="string", format="date-time"),
     *             @OA\Property(property="date_fin", type="string", format="date-time"),
     *             @OA\Property(property="presentiel", type="boolean")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="RDV créé avec succès"
     *     )
     * )
     */
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


    /**
     * @OA\Get(
     *     path="/api/rdvs/{id}",
     *     summary="Afficher un RDV précis",
     *     tags={"RDV"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="RDV trouvé"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="RDV non trouvé"
     *     )
     * )
     */
    public function show($id)
    {
        $rdv = ModelRdv::findOrFail($id);
        return response()->json($rdv);
    }

    /**
     * @OA\Put(
     *     path="/api/rdvs/{id}",
     *     summary="Mettre à jour un RDV",
     *     tags={"RDV"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="id_client", type="integer"),
     *             @OA\Property(property="id_medecin", type="integer"),
     *             @OA\Property(property="id_interprete", type="integer"),
     *             @OA\Property(property="date_debut", type="string", format="date-time"),
     *             @OA\Property(property="date_fin", type="string", format="date-time"),
     *             @OA\Property(property="presentiel", type="boolean")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="RDV mis à jour avec succès"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $rdv = ModelRdv::findOrFail($id);
        $rdv->update($request->all());
        return response()->json($rdv);
    }

    /**
     * @OA\Delete(
     *     path="/api/rdvs/{id}",
     *     summary="Supprimer un RDV",
     *     tags={"RDV"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="RDV supprimé avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="RDV non trouvé"
     *     )
     * )
     */
    public function destroy($id)
    {
        $rdv = ModelRdv::findOrFail($id);
        $rdv->delete();
        return response()->json(['message' => 'RDV supprimé avec succès']);
    }
}
