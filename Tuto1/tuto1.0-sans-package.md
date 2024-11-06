# Créer une architecture modulaire sans utiliser de package externe

Créer une architecture modulaire sans utiliser de package externe dans Laravel est tout à fait possible en structurant manuellement les dossiers et en organisant le code de manière logique. Voici un tutoriel détaillé pour implémenter une application de blog avec deux modules, `GestionArticle` et `GestionCategories`, en gérant les modules de façon native.

<!-- 
Point faible : 

- Migration 
  - on doit exécuter le migration par module et non avec l'utilisation de la commande : php artisan migrate

 -->

### Objectif du Tutoriel

Ce tutoriel vise à :
1. Créer une architecture modulaire native dans Laravel.
2. Construire deux modules : `GestionArticle` pour gérer les articles et `GestionCategories` pour gérer les catégories.
3. Configurer les routes, les contrôleurs, les modèles et les migrations pour chaque module.

### Prérequis

- **Laravel 9 ou supérieur** installé
- **Composer** installé

### Étape 1 : Configurer la Structure des Dossiers

Nous allons organiser les modules dans un dossier `Modules` dans le répertoire `app` pour maintenir une séparation claire entre chaque module.

1. **Créer un dossier `Modules` dans `app`** :

   ```bash
   mkdir app/Modules
   ```

2. **Créer les dossiers pour `GestionArticle` et `GestionCategories`** :

   ```bash
   mkdir app/Modules/GestionArticle
   mkdir app/Modules/GestionCategories
   ```

3. **Structurer chaque module** pour inclure des sous-dossiers de `Controllers`, `Models`, `Routes`, `Migrations`, et `Views` :

   ```bash
   mkdir -p app/Modules/GestionArticle/Controllers
   mkdir -p app/Modules/GestionArticle/Models
   mkdir -p app/Modules/GestionArticle/Routes
   mkdir -p app/Modules/GestionArticle/Migrations
   mkdir -p app/Modules/GestionArticle/Views

   mkdir -p app/Modules/GestionCategories/Controllers
   mkdir -p app/Modules/GestionCategories/Models
   mkdir -p app/Modules/GestionCategories/Routes
   mkdir -p app/Modules/GestionCategories/Migrations
   mkdir -p app/Modules/GestionCategories/Views
   ```

### Étape 2 : Configurer les Routes

Nous allons créer des fichiers de routes pour chaque module et les charger dans le fichier de routes principal de Laravel (`web.php`).

1. **Créer les fichiers de routes** :

   Créez un fichier `web.php` pour chaque module dans le dossier `Routes` :

   ```bash
New-Item -ItemType File -Path "app\Modules\GestionArticle\Routes\web.php"
New-Item -ItemType File -Path "app\Modules\GestionCategories\Routes\web.php"
   ```

2. **Définir les routes** dans `web.php` pour chaque module :

   - Dans `app/Modules/GestionArticle/Routes/web.php` :

     ```php
     use Illuminate\Support\Facades\Route;
     use App\Modules\GestionArticle\Controllers\ArticleController;

     Route::prefix('articles')->group(function () {
         Route::get('/', [ArticleController::class, 'index'])->name('articles.index');
         Route::get('/create', [ArticleController::class, 'create'])->name('articles.create');
         Route::post('/', [ArticleController::class, 'store'])->name('articles.store');
     });
     ```

   - Dans `app/Modules/GestionCategories/Routes/web.php` :

     ```php
     use Illuminate\Support\Facades\Route;
     use App\Modules\GestionCategories\Controllers\CategoryController;

     Route::prefix('categories')->group(function () {
         Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
         Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
         Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
     });
     ```

3. **Charger les routes** dans `routes/web.php` en utilisant `require` :

   ```php
   require base_path('app/Modules/GestionArticle/Routes/web.php');
   require base_path('app/Modules/GestionCategories/Routes/web.php');
   ```

### Étape 3 : Créer les Contrôleurs

Dans chaque module, créez des contrôleurs pour gérer les actions.

1. **Créer le `ArticleController`** dans `app/Modules/GestionArticle/Controllers/ArticleController.php` :

   ```php
   namespace App\Modules\GestionArticle\Controllers;

   use App\Http\Controllers\Controller;
   use Illuminate\Http\Request;

   class ArticleController extends Controller
   {
       public function index()
       {
           // Logique pour afficher la liste des articles
           return view('GestionArticle::index');
       }

       public function create()
       {
           return view('GestionArticle::create');
       }

       public function store(Request $request)
       {
           // Logique pour enregistrer un nouvel article
       }
   }
   ```

2. **Créer le `CategoryController`** dans `app/Modules/GestionCategories/Controllers/CategoryController.php` :

   ```php
   namespace App\Modules\GestionCategories\Controllers;

   use App\Http\Controllers\Controller;
   use Illuminate\Http\Request;

   class CategoryController extends Controller
   {
       public function index()
       {
           // Logique pour afficher la liste des catégories
           return view('GestionCategories::index');
       }

       public function create()
       {
           return view('GestionCategories::create');
       }

       public function store(Request $request)
       {
           // Logique pour enregistrer une nouvelle catégorie
       }
   }
   ```

### Étape 4 : Créer les Modèles

1. **Créer le modèle `Article`** dans `app/Modules/GestionArticle/Models/Article.php` :

   ```php
   namespace App\Modules\GestionArticle\Models;

   use Illuminate\Database\Eloquent\Model;

   class Article extends Model
   {
       protected $fillable = ['title', 'content'];
   }
   ```

2. **Créer le modèle `Category`** dans `app/Modules/GestionCategories/Models/Category.php` :

   ```php
   namespace App\Modules\GestionCategories\Models;

   use Illuminate\Database\Eloquent\Model;

   class Category extends Model
   {
       protected $fillable = ['name', 'description'];
   }
   ```

### Étape 5 : Créer les Migrations

1. **Créer les migrations pour `Article`** et `Category`. Placez-les dans le dossier principal des migrations, mais vous pouvez les organiser sous les modules pour la lisibilité.

   ```bash
   php artisan make:migration create_articles_table --path=app/Modules/GestionArticle/Migrations
   php artisan make:migration create_categories_table --path=app/Modules/GestionCategories/Migrations
   ```

2. **Définir les tables** dans chaque migration :

   - Dans `app/Modules/GestionArticle/Migrations/create_articles_table.php` :

     ```php
     public function up()
     {
         Schema::create('articles', function (Blueprint $table) {
             $table->id();
             $table->string('title');
             $table->text('content');
             $table->timestamps();
         });
     }
     ```

   - Dans `app/Modules/GestionCategories/Migrations/create_categories_table.php` :

     ```php
     public function up()
     {
         Schema::create('categories', function (Blueprint $table) {
             $table->id();
             $table->string('name');
             $table->text('description')->nullable();
             $table->timestamps();
         });
     }
     ```

3. **Exécuter les migrations** :

   ```bash
   php artisan migrate --path=app/Modules/GestionArticle/Migrations
   php artisan migrate --path=app/Modules/GestionCategories/Migrations
   ```

### Étape 6 : Configurer les Vues

1. **Créer des vues dans chaque module** pour les affichages (index et formulaire) :

   - Dans `app/Modules/GestionArticle/Views/index.blade.php` et `create.blade.php`
   - Dans `app/Modules/GestionCategories/Views/index.blade.php` et `create.blade.php`

   Pour organiser les noms des vues, vous pouvez configurer les espaces de noms :

   ```php
   return view('GestionArticle::index');  // Par exemple pour afficher la vue dans ArticleController
   ```

### Conclusion

Ce guide permet de structurer une application Laravel en modules natifs sans utiliser de packages.