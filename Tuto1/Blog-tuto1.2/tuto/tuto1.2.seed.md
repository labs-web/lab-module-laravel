Pour implémenter les seeders dans le cadre d'une architecture modulaire (où chaque module est autonome), vous devez organiser vos seeders dans les modules `GestionArticle` et `GestionCategories`. Voici comment procéder étape par étape pour créer et exécuter les seeders dans les modules.

### 1. Créer un Seeder pour `GestionCategories`

Dans le module `GestionCategories`, vous allez créer un seeder pour insérer 50 catégories.

#### Étapes :

1. **Créer le Seeder** dans le module `GestionCategories` :

```bash
php artisan make:seeder Modules/GestionCategories/CategorySeeder
```

2. **Modifier le Seeder** pour insérer des données factices dans la table `categories` :

```php
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
```

### 2. Créer un Seeder pour `GestionArticle`

Dans le module `GestionArticle`, vous allez créer un seeder pour insérer 100 articles avec des catégories aléatoires.

#### Étapes :

1. **Créer le Seeder** pour les articles :

```bash
php artisan make:seeder Modules/GestionArticle/ArticleSeeder
```

2. **Modifier le Seeder** pour insérer des articles dans la table `articles` :

```php
// app/Modules/GestionArticle/Seeders/ArticleSeeder.php

namespace App\Modules\GestionArticle\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\Category;  // Importer le modèle Category

class ArticleSeeder extends Seeder
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
                'category_id' => Category::inRandomOrder()->first()->id, // Attribution d'une catégorie aléatoire
            ]);
        }
    }
}
```

### 3. Ajouter les Seeders dans le `DatabaseSeeder` Principal

Maintenant, vous devez ajouter les seeders dans le fichier principal `DatabaseSeeder.php`, situé dans le répertoire `database/seeders`.

1. **Ouvrir le fichier `DatabaseSeeder.php`** et ajouter l'appel aux seeders de chaque module :

```php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Appelez les seeders des modules
        $this->call([
            \App\Modules\GestionCategories\Seeders\CategorySeeder::class,
            \App\Modules\GestionArticle\Seeders\ArticleSeeder::class,
        ]);
    }
}
```

### 4. Exécuter les Seeders

Enfin, vous pouvez exécuter les seeders pour insérer les 50 catégories et 100 articles dans la base de données.

1. **Exécuter la commande pour remplir la base de données** :

```bash
php artisan db:seed
```

Cela exécutera les seeders définis dans `DatabaseSeeder.php`, insérant ainsi les catégories et les articles dans les tables `categories` et `articles`.

### 5. Réinitialiser et Re-seeder (optionnel)

Si vous souhaitez réinitialiser et remplir la base de données depuis zéro avec les nouvelles données, vous pouvez utiliser la commande suivante pour réinitialiser les migrations et réexécuter les seeders :

```bash
php artisan migrate:fresh --seed
```

### Résumé des fichiers et chemins :

- **Seeder des catégories** : `app/Modules/GestionCategories/Seeders/CategorySeeder.php`
- **Seeder des articles** : `app/Modules/GestionArticle/Seeders/ArticleSeeder.php`
- **DatabaseSeeder** : `database/seeders/DatabaseSeeder.php`

Cela vous permet de structurer vos seeders dans chaque module et de les exécuter de manière modulaire dans le cadre d'une architecture Laravel monolithique.