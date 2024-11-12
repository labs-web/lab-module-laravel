# Tutoriel : Créer une Architecture Modulaire dans une Application Laravel Monolithique avec `nWidart/laravel-modules`


## Étape 1 : Créer une nouvelle application Laravel

Pour commencer, installez Laravel en utilisant Composer :

```bash
composer create-project --prefer-dist laravel/laravel blog_modulaire
cd blog_modulaire
```

## Étape 2 : Installer le package `nWidart/laravel-modules`

Installez le package `nWidart/laravel-modules`, qui vous permettra de structurer l'application en modules indépendants.

```bash
composer require nwidart/laravel-modules
```

Après l'installation, publiez le fichier de configuration du package :

```bash
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"
```

Cela va créer un fichier `config/modules.php`, dans lequel vous pouvez configurer le fonctionnement des modules.

## Étape 3 : Créer les modules « GestionArticle » et « GestionCategories »

Créez les modules avec les commandes Artisan :

```bash
php artisan module:make GestionArticle
php artisan module:make GestionCategories
```

Ces commandes génèrent un répertoire pour chaque module dans le dossier `Modules/` avec la structure suivante :

```
Modules/
├── GestionArticle/
│   ├── Config/
│   ├── Database/
│   │   ├── Factories/
│   │   ├── Migrations/
│   │   └── Seeders/
│   ├── Http/
│   │   ├── Controllers/
│   ├── Models/
│   ├── Providers/
│   ├── Resources/
│   │   ├── views/
│   └── Routes/
└── GestionCategories/
```

## Étape 4 : Configurer les modèles et les migrations

### GestionArticle

Dans le module « GestionArticle », créez le modèle `Article` et configurez la migration correspondante :

```bash
php artisan module:make-model Article GestionArticle -m
```

Cela crée un modèle `Article` et une migration dans `Modules/GestionArticle/Database/Migrations/`. Modifiez la migration pour y ajouter les champs nécessaires :

```php
// Modules/GestionArticle/Database/Migrations/XXXX_XX_XX_create_articles_table.php
public function up()
{
    Schema::create('articles', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('content');
        $table->foreignId('category_id')->constrained('categories');
        $table->timestamps();
    });
}
```

### GestionCategories

De la même manière, créez le modèle `Category` dans le module « GestionCategories » avec sa migration :

```bash
php artisan module:make-model Category GestionCategories -m
```

Modifiez la migration pour ajouter les champs du modèle `Category` :

```php
// Modules/GestionCategories/Database/Migrations/XXXX_XX_XX_create_categories_table.php
public function up()
{
    Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->timestamps();
    });
}
```

Ensuite, exécutez les migrations :

```bash
php artisan migrate
```

## Étape 5 : Configurer les routes pour chaque module

### GestionArticle

Dans le fichier `Modules/GestionArticle/Routes/web.php`, ajoutez les routes pour les articles :

```php
use Modules\GestionArticle\Http\Controllers\ArticleController;

Route::resource('articles', ArticleController::class);
```

### GestionCategories

Dans le fichier `Modules/GestionCategories/Routes/web.php`, ajoutez les routes pour les catégories :

```php
use Modules\GestionCategories\Http\Controllers\CategoryController;

Route::resource('categories', CategoryController::class);
```

## Étape 6 : Charger les routes des modules dans `web.php`

Dans `routes/web.php`, importez les routes de chaque module en ajoutant les lignes suivantes :

```php
use Nwidart\Modules\Facades\Module;

Module::load('GestionArticle', 'Routes/web.php');
Module::load('GestionCategories', 'Routes/web.php');
```

## Étape 7 : Créer les contrôleurs pour les modules

### ArticleController

Dans le module « GestionArticle », créez le contrôleur `ArticleController` :

```bash
php artisan module:make-controller ArticleController GestionArticle
```

Ensuite, configurez le contrôleur pour gérer les articles :

```php
// Modules/GestionArticle/Http/Controllers/ArticleController.php
namespace Modules\GestionArticle\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\GestionArticle\Models\Article;
use Modules\GestionCategories\Models\Category;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('category')->get();
        return view('gestionarticle::index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('gestionarticle::create', compact('categories'));
    }

    public function store(Request $request)
    {
        Article::create($request->all());
        return redirect()->route('articles.index');
    }

    // autres méthodes (show, edit, update, destroy)...
}
```

### CategoryController

Dans le module « GestionCategories », créez le contrôleur `CategoryController` :

```bash
php artisan module:make-controller CategoryController GestionCategories
```

Ensuite, configurez le contrôleur pour gérer les catégories :

```php
// Modules/GestionCategories/Http/Controllers/CategoryController.php
namespace Modules\GestionCategories\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\GestionCategories\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('gestioncategories::index', compact('categories'));
    }

    public function create()
    {
        return view('gestioncategories::create');
    }

    public function store(Request $request)
    {
        Category::create($request->all());
        return redirect()->route('categories.index');
    }

    // autres méthodes (show, edit, update, destroy)...
}
```

## Étape 8 : Configurer les vues

### Vues pour les articles

Créez les vues pour les articles dans `Modules/GestionArticle/Resources/views/` :

1. `index.blade.php` : liste des articles
2. `create.blade.php` : formulaire de création d’un article

### Vues pour les catégories

Créez les vues pour les catégories dans `Modules/GestionCategories/Resources/views/` :

1. `index.blade.php` : liste des catégories
2. `create.blade.php` : formulaire de création d’une catégorie

## Étape 9 : Configurer les seeders

Dans le module `GestionArticle`, créez le seeder `ArticleSeeder` et dans `GestionCategories`, le `CategorySeeder`. Ensuite, exécutez les seeders pour générer des données factices :

```bash
php artisan module:seed GestionArticle
php artisan module:seed GestionCategories
```

## Étape 10 : Ajouter Bootstrap pour le style

Ajoutez Bootstrap dans la vue principale (comme `layouts/app.blade.php`) pour appliquer des styles à l’application.

## Conclusion

Vous disposez maintenant d'une application Laravel avec une architecture modulaire utilisant `nWidart/laravel-modules`, structurée pour des modules indépendants avec leurs propres modèles, contrôleurs, migrations, routes et vues. Cette architecture améliore l'organisation et facilite la maintenance et la scalabilité de votre application Laravel.