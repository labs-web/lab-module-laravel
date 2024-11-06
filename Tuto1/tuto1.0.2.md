Effectivement, pour automatiser l'exécution des migrations de tous les modules en une seule commande, vous pouvez ajouter un script dans le fichier `composer.json`. Voici comment faire :

1. Ouvrez le fichier `composer.json` à la racine de votre projet Laravel.
2. Dans la section `"scripts"`, ajoutez une commande personnalisée pour exécuter les migrations de chaque module.

Voici un exemple de script dans `composer.json` :

```json
{
    "scripts": {
        "post-update-cmd": [
            "@migrate-modules"
        ],
        "migrate-modules": [
            "php artisan migrate --path=app/Modules/GestionArticle/Migrations",
            "php artisan migrate --path=app/Modules/GestionCategories/Migrations"
        ]
    }
}
```

### Explication des Scripts

- **`migrate-modules`** : Ce script exécute les migrations pour chaque module. Ici, il lance les migrations dans les dossiers `GestionArticle` et `GestionCategories`.
- **`post-update-cmd`** : Ce script peut être exécuté automatiquement après chaque mise à jour des dépendances (`composer update`) pour s’assurer que les migrations sont à jour. Vous pouvez l’omettre si vous préférez exécuter les migrations manuellement.

### Exécution du Script

Pour exécuter les migrations des modules d'un coup, utilisez :

```bash
composer run migrate-modules
```

### Avantages de cette Méthode

- **Automatisation** : Ce script permet d’exécuter toutes les migrations de vos modules sans devoir indiquer manuellement chaque chemin.
- **Clarté** : Il est facile de centraliser la gestion des migrations dans le fichier `composer.json` pour une meilleure lisibilité et maintenabilité.
- **Extensibilité** : En ajoutant de nouveaux modules, il suffit d’ajouter leur chemin dans le script `migrate-modules`.