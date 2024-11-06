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
        View::addNamespace('GestionArticle', base_path('app/Modules/GestionArticle/Views'));
        View::addNamespace('GestionCategories', base_path('app/Modules/GestionCategories/Views'));

        // Ajoutez cette ligne pour charger les migrations de chaque module
        $this->loadMigrationsFrom(app_path('Modules/GestionCategories/Migrations'));
        $this->loadMigrationsFrom(app_path('Modules/GestionArticle/Migrations'));
    }
}
