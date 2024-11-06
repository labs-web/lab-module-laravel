<?php

use Illuminate\Support\Facades\Route;
use App\Modules\GestionArticle\Controllers\ArticleController;

// Grouping all routes under the 'articles' prefix
Route::prefix('articles')->group(function () {
    // Route to display the list of articles
    Route::get('/', [ArticleController::class, 'index'])->name('articles.index');
    
    // Route to show the form for creating a new article
    Route::get('/create', [ArticleController::class, 'create'])->name('articles.create');
    
    // Route to store a new article
    Route::post('/', [ArticleController::class, 'store'])->name('articles.store');
    
    // Route to display a single article's details
    Route::get('{id}', [ArticleController::class, 'show'])->name('articles.show');
    
    // Route to show the form to edit an existing article
    Route::get('{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    
    // Route to update an existing article
    Route::put('{id}', [ArticleController::class, 'update'])->name('articles.update');
    
    // Route to delete an article
    Route::delete('{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');
});
