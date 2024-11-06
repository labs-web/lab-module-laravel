Voici un guide détaillé pour créer une application Laravel simple de gestion de blog avec une architecture modulaire. Le projet comprend deux modules : **GestionArticle** et **GestionCategories**.

### Étape 1 : Création de l'application Laravel

Créez d'abord l'application Laravel si ce n'est pas encore fait.

```bash
composer create-project --prefer-dist laravel/laravel blog
cd blog
```

### Étape 2 : Configuration de la structure modulaire

Créez les répertoires pour les deux modules sous `app/Modules/` :

```bash
mkdir -p app/Modules/GestionArticle/{Controllers,Models,Migrations,Views,Routes}
mkdir -p app/Modules/GestionCategories/{Controllers,Models,Migrations,Views,Routes}
```

---

### Étape 3 : Création des migrations et des modèles

#### 3.1. Modèle et migration pour `Category`

Créez le modèle et la migration pour la catégorie :

```bash
php artisan make:model Category -m
```

Dans la migration générée (`database/migrations/xxxx_xx_xx_create_categories_table.php`), ajoutez ce code :

```php
// database/migrations/xxxx_xx_xx_create_categories_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
```

#### 3.2. Modèle et migration pour `Article`

Créez le modèle et la migration pour l'article :

```bash
php artisan make:model Article -m
```

Dans la migration générée (`database/migrations/xxxx_xx_xx_create_articles_table.php`), ajoutez ce code :

```php
// database/migrations/xxxx_xx_xx_create_articles_table.php

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

#### 3.3. Appliquer les migrations

Exécutez les migrations pour créer les tables dans la base de données :

```bash
php artisan migrate
```

---

### Étape 4 : Création des contrôleurs et des vues

#### 4.1. Contrôleur pour `Category`

Dans `app/Modules/GestionCategories/Controllers/CategoryController.php`, ajoutez ce code :

```php
// app/Modules/GestionCategories/Controllers/CategoryController.php

namespace App\Modules\GestionCategories\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('modules.GestionCategories.index', compact('categories'));
    }

    public function create()
    {
        return view('modules.GestionCategories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Category::create($request->all());

        return redirect()->route('categories.index');
    }
}
```

#### 4.2. Contrôleur pour `Article`

Dans `app/Modules/GestionArticle/Controllers/ArticleController.php`, ajoutez ce code :

```php
// app/Modules/GestionArticle/Controllers/ArticleController.php

namespace App\Modules\GestionArticle\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with('category');
        
        // Recherche avec Ajax
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
        }

        // Filtrer par catégorie avec Ajax
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $articles = $query->get();
        $categories = Category::all();

        return view('modules.GestionArticle.index', compact('articles', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('modules.GestionArticle.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        Article::create($request->all());

        return redirect()->route('articles.index');
    }
}
```

#### 4.3. Vues

##### Vue pour afficher les articles (`resources/views/modules/GestionArticle/index.blade.php`)

```php
<!-- resources/views/modules/GestionArticle/index.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Articles</h1>

    <form method="GET" action="{{ route('articles.index') }}">
        <input type="text" name="search" placeholder="Rechercher" value="{{ request('search') }}">
        <select name="category_id">
            <option value="">Toutes les catégories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <button type="submit">Filtrer</button>
    </form>

    <ul>
        @foreach($articles as $article)
            <li>
                <h2>{{ $article->title }}</h2>
                <p>{{ $article->content }}</p>
                <p>Catégorie : {{ $article->category->name }}</p>
            </li>
        @endforeach
    </ul>
@endsection
```

##### Vue pour créer un article (`resources/views/modules/GestionArticle/create.blade.php`)

```php
<!-- resources/views/modules/GestionArticle/create.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Créer un nouvel article</h1>

    <form method="POST" action="{{ route('articles.store') }}">
        @csrf
        <div>
            <label for="title">Titre</label>
            <input type="text" name="title" id="title" required>
        </div>
        <div>
            <label for="content">Contenu</label>
            <textarea name="content" id="content" required></textarea>
        </div>
        <div>
            <label for="category_id">Catégorie</label>
            <select name="category_id" id="category_id">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit">Créer</button>
    </form>
@endsection
```

---

### Étape 5 : Routes des modules

#### 5.1. Routes pour `Category`

Dans `app/Modules/GestionCategories/Routes/web.php` :

```php
// app/Modules/GestionCategories/Routes/web.php

use App\Modules\GestionCategories\Controllers\CategoryController;

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
});
```

#### 5.2. Routes pour `Article`

Dans `app/Modules/GestionArticle/Routes/web.php` :

```php
// app/Modules/GestionArticle/Routes/web.php

use App\Modules\GestionArticle\Controllers\ArticleController;

Route::prefix('articles')->group(function () {
    Route::get('/', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/', [ArticleController::class, 'store'])->name('articles.store');
});
```

---

### Étape 6 : Intégration des routes dans `web.php`

Dans le fichier `routes/web.php` principal de l'application, incluez les routes des modules :

```php
// routes/web.php

require app_path('Modules/GestionCategories/Routes/web.php');
require app_path('Modules/GestionArticle/Routes/web.php');
```

---

### Étape 7 : Ajout de la recherche et du filtrage avec Ajax (facultatif)

Pour implémenter la recherche Ajax et le filtrage par catégorie, vous pouvez ajouter des requêtes Ajax dans le contrôleur et mettre à jour les articles sans recharger la page.

