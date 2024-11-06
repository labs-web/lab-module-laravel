<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
             // Alias pour les vues du module GestionArticle
             View::addNamespace('GestionArticle', base_path('app/Modules/GestionArticle/Views'));

             // Alias pour les vues du module GestionCategories
             View::addNamespace('GestionCategories', base_path('app/Modules/GestionCategories/Views'));
    }
}
