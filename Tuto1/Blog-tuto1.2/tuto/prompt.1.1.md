Voici un prompt détaillé pour la création de l'application Laravel avec une architecture modulaire pour la gestion d'un blog avec les modules `GestionArticle` et `GestionCategories` :

---

**Prompt :**

Créez une application Laravel simple pour la gestion d'un blog en utilisant une architecture modulaire sans packages externes. L'application doit comporter deux modules principaux : `GestionArticle` et `GestionCategories`.

Les spécifications du projet sont les suivantes :

1. **Module `GestionArticle` :**
   - Modèle `Article` avec les attributs `title` (string) et `content` (text).
   - Relation **Many-to-One** entre `Article` et `Category`.
   - Le module doit inclure :
     - Un contrôleur `ArticleController` pour gérer l'affichage, la création et la modification des articles.
     - Des vues pour afficher la liste des articles, créer un nouvel article, et éditer un article.
     - Une route pour chaque fonctionnalité (index, create, store).

2. **Module `GestionCategories` :**
   - Modèle `Category` avec les attributs `name` (string) et `description` (text).
   - Le module doit inclure :
     - Un contrôleur `CategoryController` pour gérer la création et l'affichage des catégories.
     - Des vues pour afficher la liste des catégories, créer une catégorie.
     - Une route pour chaque fonctionnalité (index, create, store).

3. **Relation entre `Article` et `Category` :**
   - Un article appartient à une catégorie. Cette relation doit être implémentée dans les modèles avec une clé étrangère `category_id` dans la table `articles`.

4. **Structure de l'application :**
   - Organisez l'application en créant des dossiers distincts pour chaque module sous `app/Modules/` :
     - `app/Modules/GestionArticle/`
     - `app/Modules/GestionCategories/`
   - Créez des sous-dossiers pour chaque module comme suit :
     - `Controllers`
     - `Models`
     - `Migrations`
     - `Views`
     - `Routes`
   - Ajoutez les routes des modules dans le fichier principal `routes/web.php`.

5. **Fonctionnalités attendues :**
   - **Gestion des Articles :**
     - Lister tous les articles.
     - Créer un article avec un titre, un contenu et une catégorie associée.
     - Modifier un article.
     - Rechercher un article par titre et content en utilisant Ajax
     - Filtrer les article par Catégorie en utilisant Ajax
   - **Gestion des Catégories :**
     - Lister toutes les catégories.
     - Créer une nouvelle catégorie avec un nom et une description.

6. **Base de données :**
   - Créez les tables `articles` et `categories` avec des migrations.
   - La table `articles` doit avoir une clé étrangère `category_id` liée à la table `categories`.

7. **Autres configurations :**
   - Chargez les vues de chaque module dans le contrôleur respectif.
   - Configurez les relations entre les modèles (par exemple, `Article` a une relation `belongsTo` avec `Category`).
   - Utilisez des vues communes via un layout central pour les deux modules.




Donnez le code complet pour chaque étape, y compris la configuration des routes, des contrôleurs, des modèles, des migrations, et des vues pour chaque module, ainsi que les relations dans la base de données.

