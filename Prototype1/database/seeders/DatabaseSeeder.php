<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Appelez les seeders des modules
        // TODO : Ajouter pour chaque module une classe global par module qui va gérer les seeders de module
        $this->call([
            \App\Modules\GestionCategories\Seeders\CategorySeeder::class,
            \App\Modules\GestionArticle\Seeders\ArticleSeeder::class,
        ]);


    }
}
