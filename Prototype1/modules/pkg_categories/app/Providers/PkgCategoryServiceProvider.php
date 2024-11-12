<?php

namespace Modules\PkgCategory\App\Providers;

use Illuminate\Support\ServiceProvider;

class PkgCategoryServiceProvider extends ServiceProvider
{
    /**
     * Enregistrer les services dans l'application.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Effectuer les opérations de démarrage pour le module.
     *
     * @return void
     */
    public function boot()
    {
        // Charger les migrations du module
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        // Charger les routes du module
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');

        // Charger les vues du module
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'pkg_categories');
    }
}
