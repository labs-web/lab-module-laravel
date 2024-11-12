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
        // Alias pour les vues 
        View::addNamespace('GestionArticle', base_path('modules/GestionArticle/Views'));
        View::addNamespace('GestionCategories', base_path('modules/GestionCategories/Views'));

        // charger les migrations de chaque module
        $this->loadMigrationsFrom(base_path('modules/GestionCategories/Migrations'));
        $this->loadMigrationsFrom(base_path('modules/GestionArticle/Migrations'));
    }
}
