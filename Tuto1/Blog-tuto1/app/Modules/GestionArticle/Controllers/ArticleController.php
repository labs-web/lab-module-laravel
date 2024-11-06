<?php

namespace App\Modules\GestionArticle\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\GestionArticle\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Affiche la liste des articles.
     */
    public function index()
    {
        $articles = Article::all(); // Récupère tous les articles
        return view('GestionArticle::index', compact('articles'));
    }

    /**
     * Affiche le formulaire de création d'un nouvel article.
     */
    public function create()
    {
        return view('GestionArticle::create');
    }

    /**
     * Enregistre un nouvel article dans la base de données.
     */
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Création de l'article
        Article::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);

        // Redirection avec un message de succès
        return redirect()->route('articles.index')->with('success', 'Article créé avec succès.');
    }

    /**
     * Affiche les détails d'un article spécifique.
     */
    public function show($id)
    {
        $article = Article::findOrFail($id); // Récupère l'article ou renvoie une erreur 404
        return view('GestionArticle::show', compact('article'));
    }

    /**
     * Affiche le formulaire d'édition d'un article existant.
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id); // Récupère l'article ou renvoie une erreur 404
        return view('GestionArticle::edit', compact('article'));
    }

    /**
     * Met à jour un article existant dans la base de données.
     */
    public function update(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Mise à jour de l'article
        $article = Article::findOrFail($id);
        $article->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);

        // Redirection avec un message de succès
        return redirect()->route('articles.index')->with('success', 'Article mis à jour avec succès.');
    }

    /**
     * Supprime un article de la base de données.
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id); // Récupère l'article ou renvoie une erreur 404
        $article->delete();

        // Redirection avec un message de succès
        return redirect()->route('articles.index')->with('success', 'Article supprimé avec succès.');
    }
}
