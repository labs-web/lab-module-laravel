<?php

// app/Modules/pkg_articles/Seeders/ArticleSeeder.php

namespace Modules\PkgArticles\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

use Modules\PkgCategories\Models\Category as ModelsCategory;  // Importer le modèle Category

class PkgArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Insérer 100 articles
        foreach (range(1, 100) as $index) {
            DB::table('articles')->insert([
                'title' => $faker->sentence,
                'content' => $faker->paragraph,
                'category_id' => ModelsCategory::inRandomOrder()->first()->id, // Attribution d'une catégorie aléatoire
            ]);
        }
    }
}
