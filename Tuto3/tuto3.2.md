Voici un tutoriel détaillé pour réaliser un prototype de gestion modulaire dans une application Laravel monolithique, en utilisant **Git sous-modules** pour isoler les modules et permettre à chaque développeur de travailler indépendamment sur son module tout en collaborant efficacement.

---

### Tutoriel : Création d'un Prototype d'Architecture Modulaire Laravel avec Git Sous-Modules

#### 1. **Initialisation du dépôt principal Laravel**

Commencez par créer un nouveau projet Laravel dans lequel vous allez intégrer des sous-modules pour les différents modules.

```bash
# Créer le projet principal Laravel
composer create-project --prefer-dist laravel/laravel monolith-modular

# Naviguer dans le dossier du projet
cd monolith-modular
```

#### 2. **Créer des dépôts séparés pour chaque module**

Supposons que nous avons deux modules : **ModuleA** et **ModuleB**.

##### 2.1. **Créer les dépôts pour les modules**

1. Créez deux dépôts Git séparés pour chaque module. Par exemple, vous pouvez utiliser GitHub ou GitLab pour héberger les dépôts.

   - **ModuleA** : `https://github.com/your-username/module-a.git`
   - **ModuleB** : `https://github.com/your-username/module-b.git`

2. Initialisez chaque module dans son propre dossier sur votre machine.

```bash
# Créer un dossier pour ModuleA
mkdir module-a
cd module-a
git init
# Ajoutez vos fichiers pour ModuleA (contrôleurs, modèles, etc.)
git commit -m "Initial commit for ModuleA"
git remote add origin https://github.com/your-username/module-a.git
git push -u origin main

# Répétez pour ModuleB
mkdir module-b
cd module-b
git init
# Ajoutez vos fichiers pour ModuleB (contrôleurs, modèles, etc.)
git commit -m "Initial commit for ModuleB"
git remote add origin https://github.com/your-username/module-b.git
git push -u origin main
```

#### 3. **Ajouter les sous-modules Git au projet principal**

Maintenant que vous avez vos deux modules, vous pouvez les ajouter en tant que **sous-modules Git** dans votre dépôt principal Laravel.

1. Revenez au dépôt principal (`monolith-modular`) :

```bash
cd ../monolith-modular
```

2. Ajoutez **ModuleA** et **ModuleB** comme sous-modules Git :

```bash
# Ajouter ModuleA en tant que sous-module
git submodule add https://github.com/your-username/module-a.git app/Modules/ModuleA

# Ajouter ModuleB en tant que sous-module
git submodule add https://github.com/your-username/module-b.git app/Modules/ModuleB
```

3. Ensuite, **initialisez et mettez à jour** les sous-modules :

```bash
git submodule update --init --recursive
```

#### 4. **Structure des modules dans Laravel**

Dans votre structure Laravel, vous allez avoir les modules dans `app/Modules`. Voici à quoi cela pourrait ressembler :

```bash
app/
├── Modules/
│   ├── ModuleA/
│   │   ├── Controllers/
│   │   ├── Models/
│   │   ├── Routes/
│   ├── ModuleB/
│   │   ├── Controllers/
│   │   ├── Models/
│   │   ├── Routes/
```

Chaque module est un sous-dossier dans `app/Modules`. Vous pouvez maintenant organiser vos modules comme des packages autonomes avec leurs propres contrôleurs, modèles, routes, etc.

#### 5. **Configurer le chargement dynamique des modules**

Maintenant, vous allez configurer le chargement dynamique des routes et autres fichiers de chaque module dans Laravel. Cela peut être fait dans le `AppServiceProvider`.

1. Ouvrez le fichier `app/Providers/AppServiceProvider.php`.

2. Modifiez la méthode `boot` pour charger dynamiquement les routes de chaque module :

```php
public function boot()
{
    // Charger les routes pour ModuleA
    $moduleARoutes = base_path('app/Modules/ModuleA/routes/web.php');
    if (file_exists($moduleARoutes)) {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group($moduleARoutes);
    }

    // Charger les routes pour ModuleB
    $moduleBRoutes = base_path('app/Modules/ModuleB/routes/web.php');
    if (file_exists($moduleBRoutes)) {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group($moduleBRoutes);
    }
}
```

#### 6. **Mise en place des workflows de Git pour les développeurs**

##### 6.1. **Création des branches dédiées pour chaque module**

Chaque développeur doit travailler sur une branche dédiée pour son module. Par exemple :

- **Développeur A** travaille sur `module-a/develop`.
- **Développeur B** travaille sur `module-b/develop`.

Pour **Développeur A** :

```bash
git checkout -b module-a/develop
```

Pour **Développeur B** :

```bash
git checkout -b module-b/develop
```

##### 6.2. **Références des sous-modules dans le dépôt principal**

Chaque fois qu'un développeur met à jour un module, il doit mettre à jour la référence du sous-module dans le dépôt principal.

```bash
# Après avoir modifié un module, mettre à jour le sous-module
git submodule update --remote app/Modules/ModuleA
git submodule update --remote app/Modules/ModuleB
```

##### 6.3. **Soumettre des PRs pour les mises à jour**

Les développeurs doivent soumettre des **pull requests** (PRs) dans les dépôts respectifs de `ModuleA` et `ModuleB` pour chaque fonctionnalité ou correction de bug.

- **Développeur A** fait une PR pour les modifications de **ModuleA**.
- **Développeur B** fait une PR pour les modifications de **ModuleB**.

#### 7. **Fusion dans le dépôt principal**

Une fois que les PRs pour les modules ont été fusionnées, les développeurs mettent à jour le dépôt principal pour pointer vers les dernières versions de chaque sous-module.

```bash
git submodule update --remote app/Modules/ModuleA
git submodule update --remote app/Modules/ModuleB
```

Puis ils peuvent soumettre une **PR** dans le dépôt principal pour intégrer les modifications des modules dans la branche `main` ou `master`.

#### 8. **Déploiement du prototype**

Une fois les PRs fusionnées dans le dépôt principal, vous pouvez déployer l'application. Tous les modules et leurs dépendances sont désormais intégrés via les sous-modules Git.

---

### Résumé du tutoriel :

1. **Initialisez un projet Laravel** et créez des dépôts Git pour chaque module.
2. **Ajoutez les modules comme sous-modules Git** dans le dépôt principal.
3. **Configurez le chargement dynamique des modules** dans le fichier `AppServiceProvider`.
4. **Travaillez sur des branches dédiées** pour chaque module, avec des PRs et des mises à jour régulières des sous-modules.
5. **Fusionnez les changements** dans le dépôt principal et déployez l'application.

Ce processus assure que les modules restent isolés tout en permettant une collaboration fluide entre les développeurs.