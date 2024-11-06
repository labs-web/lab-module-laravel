
<!-- Chat gpt : version gratuit -->

Voici un tutoriel détaillé expliquant comment implémenter une architecture modulaire dans une application Laravel monolithique sans utiliser de package externe pour la gestion des modules. Le tutoriel guide étape par étape sur la création d'une application de blog avec deux modules : `GestionArticle` et `GestionCategories`.

### Étape 1 : Créer une application Laravel vide

Ouvrez PowerShell et exécutez les commandes suivantes pour créer une nouvelle application Laravel :

```bash
composer create-project --prefer-dist laravel/laravel blog
cd blog
```

Cette commande crée une nouvelle application Laravel appelée `blog`.

### Étape 2 : Structurer les dossiers pour chaque module

Dans une application monolithique modulaire, chaque module est contenu dans un dossier séparé sous `app/Modules`. Vous allez créer deux modules : `GestionArticle` et `GestionCategories`.

Voici la structure du dossier pour chaque module :

```
app/
└── Modules/
    ├── GestionArticle/
    │   ├── Controllers/
    │   ├── Models/
    │   ├── Migrations/
    │   ├── Routes/
    │   ├── Views/
    │   ├── Seeders/
    └── GestionCategories/
        ├── Controllers/
        ├── Models/
        ├── Migrations/
        ├── Routes/
        ├── Views/
        └── Seeders/
```

### Étape 3 : Créer les modules

1. **Créer les dossiers pour chaque module** :
   
   Dans `app/Modules`, créez deux dossiers : `GestionArticle` et `GestionCategories` :

   ```bash
   mkdir -p app/Modules/GestionArticle/{Controllers,Models,Migrations,Routes,Views,Seeders}
   mkdir -p app/Modules/GestionCategories/{Controllers,Models,Migrations,Routes,Views,Seeders}
   ```

### Étape 4 : Définir les routes des modules

Créez un fichier de routes pour chaque module sous `app/Modules/GestionArticle/Routes/web.php` et `app/Modules/GestionCategories/Routes/web.php`. Ces fichiers définiront les routes du module.

#### Routes pour `GestionArticle`

```php
// app/Modules/GestionArticle/Routes/web.php
use Illuminate\Support\Facades\Route;
use App\Modules\GestionArticle\Controllers\ArticleController;

Route::prefix('articles')->group(function () {
    Route::get('/', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('{id}', [ArticleController::class, 'show'])->name('articles.show');
    Route::get('{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('{id}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');
});
```

#### Routes pour `GestionCategories`

```php
// app/Modules/GestionCategories/Routes/web.php
use Illuminate\Support\Facades\Route;
use App\Modules\GestionCategories\Controllers\CategoryController;

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('{id}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});
```

### Étape 5 : Charger les routes dans le fichier `web.php`

Dans `routes/web.php`, incluez les fichiers de routes de chaque module.

```php
// routes/web.php

// Charger les routes du module GestionArticle
require base_path('app/Modules/GestionArticle/Routes/web.php');

// Charger les routes du module GestionCategories
require base_path('app/Modules/GestionCategories/Routes/web.php');
```

### Étape 6 : Créer les contrôleurs

#### `ArticleController` pour `GestionArticle`

```php
// app/Modules/GestionArticle/Controllers/ArticleController.php
namespace App\Modules\GestionArticle\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\GestionArticle\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::all();
        return view('GestionArticle::index', compact('articles'));
    }

    public function create()
    {
        return view('GestionArticle::create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Article::create($request->all());
        return redirect()->route('articles.index');
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('GestionArticle::show', compact('article'));
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('GestionArticle::edit', compact('article'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $article = Article::findOrFail($id);
        $article->update($request->all());
        return redirect()->route('articles.index');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        return redirect()->route('articles.index');
    }
}
```

#### `CategoryController` pour `GestionCategories`

```php
// app/Modules/GestionCategories/Controllers/CategoryController.php
namespace App\Modules\GestionCategories\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\GestionCategories\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('GestionCategories::index', compact('categories'));
    }

    public function create()
    {
        return view('GestionCategories::create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create($request->all());
        return redirect()->route('categories.index');
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('GestionCategories::show', compact('category'));
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('GestionCategories::edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());
        return redirect()->route('categories.index');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index');
    }
}
```

### Étape 7 : Créer les modèles

#### `Article` Model

```php
// app/Modules/GestionArticle/Models/Article.php
namespace App\Modules\GestionArticle\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'content', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
```

#### `Category` Model

```php
// app/Modules/GestionCategories/Models/Category.php
namespace App\Modules\GestionCategories\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
```

### Étape 8 : Créer les migrations

#### Migration pour `articles` Table

```php
// app/Modules/GestionArticle/Migrations/xxxx_xx_xx_create_articles_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
```

#### Migration pour `categories` Table

```php
// app/Modules/GestionCategories/Migrations/xxxx_xx_xx_create_categories_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function

 up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
```

### Étape 9 : Ajouter des seeders

#### Seeder pour `Category`

```php
// app/Modules/GestionCategories/Seeders/CategorySeeder.php
namespace App\Modules\GestionCategories\Seeders;

use App\Modules\GestionCategories\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create(['name' => 'Technology']);
        Category::create(['name' => 'Health']);
        Category::create(['name' => 'Lifestyle']);
    }
}
```

#### Seeder pour `Article`

```php
// app/Modules/GestionArticle/Seeders/ArticleSeeder.php
namespace App\Modules\GestionArticle\Seeders;

use App\Modules\GestionArticle\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        Article::create(['title' => 'First Article', 'content' => 'This is the first article content.', 'category_id' => 1]);
        Article::create(['title' => 'Second Article', 'content' => 'This is the second article content.', 'category_id' => 2]);
    }
}
```

### Étape 10 : Exécuter les migrations et seeders

Ajoutez les migrations et les seeders dans `DatabaseSeeder.php` :

```php
// database/seeders/DatabaseSeeder.php
public function run()
{
    $this->call([
        \App\Modules\GestionCategories\Seeders\CategorySeeder::class,
        \App\Modules\GestionArticle\Seeders\ArticleSeeder::class,
    ]);
}
```

Exécutez les migrations et les seeders :

```bash
php artisan migrate --seed
```

### Conclusion

Avec ces étapes, vous avez créé une application Laravel modulaire avec deux modules : `GestionArticle` et `GestionCategories`. Vous avez vu comment structurer les dossiers, configurer les routes, les contrôleurs, les modèles, les migrations, et les seeders pour chaque module.