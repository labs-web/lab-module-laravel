<?php

namespace App\Modules\GestionCategories\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Logique pour afficher la liste des catégories
        return view('GestionCategories::index');
    }

    public function create()
    {
        return view('GestionCategories::create');
    }

    public function store(Request $request)
    {
        // Logique pour enregistrer une nouvelle catégorie
    }
}