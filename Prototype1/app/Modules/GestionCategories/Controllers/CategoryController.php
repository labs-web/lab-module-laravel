<?php

namespace App\Modules\GestionCategories\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\GestionCategories\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Afficher la liste des catégories.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupère toutes les catégories
        $categories = Category::all();

        // Retourner la vue avec les catégories
        return view('GestionCategories::index', compact('categories'));
    }

    /**
     * Afficher le formulaire de création d'une catégorie.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Retourner la vue de création de catégorie
        return view('GestionCategories::create');
    }

    /**
     * Enregistrer une nouvelle catégorie dans la base de données.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        // Création de la catégorie
        Category::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? '',
        ]);

        // Rediriger vers la liste des catégories avec un message de succès
        return redirect()->route('categories.index')->with('success', 'Catégorie créée avec succès!');
    }

    /**
     * Afficher le formulaire d'édition d'une catégorie.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Récupérer la catégorie par son ID
        $category = Category::findOrFail($id);

        // Retourner la vue d'édition avec la catégorie
        return view('GestionCategories::edit', compact('category'));
    }

    /**
     * Mettre à jour une catégorie dans la base de données.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validation des données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        // Trouver la catégorie et mettre à jour ses informations
        $category = Category::findOrFail($id);
        $category->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? '',
        ]);

        // Rediriger vers la liste des catégories avec un message de succès
        return redirect()->route('categories.index')->with('success', 'Catégorie mise à jour avec succès!');
    }

    /**
     * Supprimer une catégorie de la base de données.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Trouver la catégorie et la supprimer
        $category = Category::findOrFail($id);
        $category->delete();

        // Rediriger vers la liste des catégories avec un message de succès
        return redirect()->route('categories.index')->with('success', 'Catégorie supprimée avec succès!');
    }
}
