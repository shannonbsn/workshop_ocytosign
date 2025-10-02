<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

use App\Models\ModelClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class ModelClientController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/clients",
     *     summary="Liste des clients",
     *     tags={"Clients"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des clients récupérée avec succès"
     *     )
     * )
     */
    public function index()
    {
        return ModelClient::all();
    }

    /**
     * @OA\Post(
     *     path="/api/clients",
     *     summary="Créer un nouveau client",
     *     tags={"Clients"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nom","prenom","email","password"},
     *             @OA\Property(property="nom", type="string"),
     *             @OA\Property(property="prenom", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="tel", type="string"),
     *             @OA\Property(property="password", type="string", format="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Client créé avec succès"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom'    => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email'  => 'required|email|unique:clients,email',
            'tel'    => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
        ]);

        return ModelClient::create($request->all());
    }

    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Créer un nouveau profil client",
     *     tags={"Clients"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nom","prenom","email","password"},
     *             @OA\Property(property="nom", type="string"),
     *             @OA\Property(property="prenom", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="tel", type="string"),
     *             @OA\Property(property="password", type="string", format="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Profil client créé avec succès"
     *     )
     * )
     */
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|unique:clients,email',
            'tel' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
        ]);

        $client = ModelClient::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'tel' => $validated['tel'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        $token = $client->createToken('client-token')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Connexion du client",
     *     tags={"Clients"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string", format="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Connexion réussie, token retourné"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Identifiants invalides"
     *     )
     * )
     */
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $client = ModelClient::where('email', $validated['email'])->first();

        if (!$client || !Hash::check($validated['password'], $client->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $token = $client->createToken('client-token')->plainTextToken;

        return response()->json(['token' => $token]);
    }


    /**
     * @OA\Get(
     *     path="/api/clients/{id}",
     *     summary="Afficher un client",
     *     tags={"Clients"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Client trouvé"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Client non trouvé"
     *     )
     * )
     */
    public function show($id)
    {
        return ModelClient::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/clients",
     *     summary="Modifier un profil client",
     *     tags={"Clients"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nom","prenom","email","password"},
     *             @OA\Property(property="nom", type="string"),
     *             @OA\Property(property="prenom", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="tel", type="string"),
     *             @OA\Property(property="password", type="string", format="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Profil client modifié avec succès"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $client = ModelClient::findOrFail($id);

        $request->validate([
            'nom'    => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email'  => 'required|email|unique:clients,email,' . $id . ',id_client',
            'tel'    => 'nullable|string|max:20',
        ]);

        $client->update($request->all());
        return $client;
    }

    /**
     * @OA\Delete(
     *     path="/api/clients/{id}",
     *     summary="Supprimer un client",
     *     tags={"Clients"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Client supprimé"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Client non trouvé"
     *     )
     * )
     */
    public function destroy($id)
    {
        $client = ModelClient::findOrFail($id);
        $client->delete();

        return response()->json(['message' => 'Client supprimé avec succès']);
    }
}
