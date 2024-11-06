<?php

namespace App\Modules\GestionArticle\Controllers;

use App\Modules\GestionArticle\Models\Article;
use App\Modules\GestionCategories\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    // Afficher tous les articles
    public function index(Request $request)
    {
        // Récupérer tous les articles avec leur catégorie associée
        $articles = Article::with('category')->paginate(10);

         // Récupérer toutes les catégories
         $categories = Category::all();

        // Retourner la vue avec les articles
        return view('GestionArticle::index', compact('articles','categories'));
    }

    // Afficher le formulaire pour créer un article
    public function create()
    {
        // Récupérer toutes les catégories
        $categories = Category::all();

        // Retourner la vue avec les catégories disponibles pour le formulaire
        return view('GestionArticle::create', compact('categories'));
    }

    // Sauvegarder un nouvel article
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Créer un nouvel article
        Article::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
        ]);

        // Rediriger avec un message de succès
        return redirect()->route('articles.index')->with('success', 'Article ajouté avec succès.');
    }

    // Afficher le formulaire pour éditer un article
    public function edit($id)
    {
        // Trouver l'article à éditer
        $article = Article::findOrFail($id);

        // Récupérer toutes les catégories
        $categories = Category::all();

        // Retourner la vue avec l'article à éditer et les catégories
        return view('GestionArticle::edit', compact('article', 'categories'));
    }

    // Mettre à jour un article existant
    public function update(Request $request, $id)
    {
        // Valider les données du formulaire
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Trouver l'article à mettre à jour
        $article = Article::findOrFail($id);

        // Mettre à jour l'article
        $article->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
        ]);

        // Rediriger avec un message de succès
        return redirect()->route('articles.index')->with('success', 'Article mis à jour avec succès.');
    }

    // Supprimer un article
    public function destroy($id)
    {
        // Trouver l'article à supprimer
        $article = Article::findOrFail($id);

        // Supprimer l'article
        $article->delete();

        // Rediriger avec un message de succès
        return redirect()->route('articles.index')->with('success', 'Article supprimé avec succès.');
    }

    // Recherche des articles par titre ou contenu
    public function search(Request $request)
    {
        $query = $request->get('query');
        $articles = Article::where('title', 'like', '%' . $query . '%')
                           ->orWhere('content', 'like', '%' . $query . '%')
                           ->with('category')
                           ->get();

        // Retourner les articles filtrés en JSON pour l'Ajax
        return response()->json($articles);
    }

    // Filtrer les articles par catégorie
    public function filterByCategory(Request $request)
    {
        $category_id = $request->get('category_id');
        $articles = Article::where('category_id', $category_id)
                           ->with('category')
                           ->get();

        // Retourner les articles filtrés en JSON pour l'Ajax
        return response()->json($articles);
    }
}
