<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Afficher une liste de tous les articles.
     */
    public function index()
    {
        // Récupérer tous les articles
        $articles = Articles::all();

        return response()->json($articles, 200);
    }

    /**
     * Créer un nouvel article.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric',
            'imagearticle' => 'required|image|max:2048', // Assurez-vous que l'image est bien un fichier image
        ]);

        try {
            // Gestion du fichier image
            if ($request->hasFile('imagearticle')) {
                $imagePath = $request->file('imagearticle')->store('uploads', 'public');
            }

            // Création d'un nouvel article
            $article = Articles::create([
                'nom' => $request->nom,
                'description' => $request->description,
                'prix' => $request->prix,
                'imagearticle' => $imagePath,
            ]);

            return response()->json($article, 201);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création de l\'article: '.$e->getMessage());

            return response()->json(['error' => 'Erreur interne du serveur'], 500);
        }
    }

    /**
     * Afficher les détails d'un article spécifique.
     */
    public function show($id)
    {
        $article = Articles::find($id);

        if ($article) {
            return response()->json($article, 200);
        } else {
            return response()->json(['message' => 'Article non trouvé'], 404);
        }
    }

    /**
     * Mettre à jour un article spécifique.
     */
    public function update(Request $request, $id)
    {
        $article = Articles::find($id);

        if ($article) {
            $request->validate([
                'nom' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|required|string',
                'prix' => 'sometimes|required|numeric',
                'imagearticle' => 'sometimes|required|string|max:255',
            ]);

            // Mettre à jour les champs
            $article->nom = $request->nom ?? $article->nom;
            $article->description = $request->description ?? $article->description;
            $article->prix = $request->prix ?? $article->prix;
            $article->imagearticle = $request->imagearticle ?? $article->imagearticle;

            $article->save();

            return response()->json($article, 200);
        } else {
            return response()->json(['message' => 'Article non trouvé'], 404);
        }
    }

    /**
     * Supprimer un article spécifique.
     */
    public function destroy($id)
    {
        $article = Articles::find($id);

        if ($article) {
            $article->delete();

            return response()->json(['message' => 'Article supprimé avec succès'], 200);
        } else {
            return response()->json(['message' => 'Article non trouvé'], 404);
        }
    }
}