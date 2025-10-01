<?php

namespace App\Http\Controllers;

use App\Models\ModelClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;

class ModelClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // GET /clients
    public function index()
    {
        return ModelClient::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    // POST /clients
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
     * Registers a new user and returns an access token for API access.
     */
    //Route: POST /register
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
     * Display the specified resource.
     */
    // GET /clients/{id_client}
    public function show($id)
    {
        return ModelClient::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    // PUT /clients/{id_client}
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
     * Remove the specified resource from storage.
     */
    // DELETE /clients/{id_client}
    public function destroy($id)
    {
        $client = ModelClient::findOrFail($id);
        $client->delete();

        return response()->json(['message' => 'Client supprimé avec succès']);
    }
}
