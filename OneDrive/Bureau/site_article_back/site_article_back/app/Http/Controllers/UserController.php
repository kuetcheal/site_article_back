<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;  // Utilisation du modèle Utilisateur
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(Utilisateur::all(), 200);  // Utilisation du modèle Utilisateur
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:utilisateur',
            'email' => 'required|string|email|max:255|unique:utilisateur',
            'password' => 'required|string|min:6',
        ]);

        $user = Utilisateur::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json($user, 201);
    }

    
    public function show($id)
    {
        $user = Utilisateur::find($id);

        if ($user) {
            return response()->json($user, 200);
        } else {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }
    }

    
    public function update(Request $request, $id)
    {
        $user = Utilisateur::find($id);

        if ($user) {
            $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'username' => 'sometimes|required|string|max:255|unique:utilisateur,username,'.$id,
                'email' => 'sometimes|required|string|email|max:255|unique:utilisateur,email,'.$id,
                'password' => 'sometimes|nullable|string|min:6',
            ]);

            $user->name = $request->name ?? $user->name;
            $user->username = $request->username ?? $user->username;
            $user->email = $request->email ?? $user->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            return response()->json($user, 200);
        } else {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }
    }

    
    public function destroy($id)
    {
        $user = Utilisateur::find($id);

        if ($user) {
            $user->delete();

            return response()->json(['message' => 'Utilisateur supprimé avec succès'], 200);
        } else {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }
    }
}