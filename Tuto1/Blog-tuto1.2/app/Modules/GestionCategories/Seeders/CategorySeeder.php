<?php

// app/Modules/GestionCategories/Seeders/CategorySeeder.php

namespace App\Modules\GestionCategories\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Insérer 50 catégories
        foreach (range(1, 50) as $index) {
            DB::table('categories')->insert([
                'name' => $faker->word,
                'description' => $faker->sentence,
            ]);
        }
    }
}
