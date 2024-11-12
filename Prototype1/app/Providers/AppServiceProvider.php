<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        // Enregistrement des ServiceProviders pour les modules pkg_articles et pkg_categories
        $this->app->register(\Modules\PkgArticles\Providers\ArticleServiceProvider::class);
        $this->app->register(\Modules\PkgCategories\Providers\CategoryServiceProvider::class);
    }
    

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Alias pour les vues 
        View::addNamespace('pkg_articles', base_path('modules/pkg_articles/Views'));
        View::addNamespace('GestionCategories', base_path('modules/GestionCategories/Views'));

        // charger les migrations de chaque module
        $this->loadMigrationsFrom(base_path('modules/GestionCategories/Migrations'));
        $this->loadMigrationsFrom(base_path('modules/pkg_articles/Migrations'));
    }
}
