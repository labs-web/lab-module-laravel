<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\PkgArticles\Database\Seeders\ArticleSeeder;
use Modules\PkgCategories\Database\Seeders\CategorySeeder;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

     public function run(): void
    {
        // User::factory(10)->create();

       
        // // Appelez les seeders des modules
        // // TODO : Ajouter pour chaque module une classe global par module qui va gérer les seeders de module
        // $this->call([
        //     CategorySeeder::class,
        //     ArticleSeeder::class,
        // ]);


        // TODO: utilisation de l'odre de puis le fichier modules.json
        
        // Récupérer tous les dossiers de modules
        $modulesPath = base_path('modules');
        $modules = File::directories($modulesPath);

        // Parcourir tous les modules et exécuter leurs seeders
        foreach ($modules as $module) {
            // Trouver le seeder principal du module en recherchant le fichier de seeder
            $seederFile = $module . '/Database/Seeders/' . Str::studly(basename($module)) . 'Seeder.php';

            // dd( $seederFile );
            // Vérifier si le fichier de seeder existe
            if (File::exists($seederFile)) {
                // Appeler le seeder du module
                $seederClass = 'Modules\\' . Str::studly(basename($module)) . '\\Database\\Seeders\\' . Str::studly(basename($module)) . 'Seeder';
                $this->call($seederClass);
            }
        }

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

    }
}
