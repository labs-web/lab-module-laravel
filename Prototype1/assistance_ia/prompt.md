
## Prompt 1.1

Je vous que vous m'assiste à développer une application pour la gestion d'un blog. 

L'architecture de l'application Laravel monolithique pour un système de gestion de blog avec une structure modulaire. 

La structure principale de cahque module respecte la structure d'une application laravel standard.

Utiliser des lignes propres et des étiquettes, avec un design professionnel et minimaliste

La structure de l'application 
modules/
  ├── pkg_articles/
  │   ├── controllers/                  # Dossier accessible et couramment utilisé
  │   │   └── articlecontroller.php
  │   ├── models/                       # Dossier utilisé pour les modèles Eloquent
  │   │   └── article.php
  │   ├── resources/                    # Dossier avec les vues et les ressources locales
  │   │   ├── views/
  │   │   │   └── articles/
  │   │   │       └── index.blade.php
  │   │   └── lang/
  │   │       └── en/
  │   │           └── pkg_articles.php
  │   ├── routes/                       # Dossier pour les fichiers de routes spécifiques au module
  │   │   └── web.php
  │   ├── database/                     # Contient les fichiers liés à la base de données
  │   │   ├── migrations/
  │   │   │   └── 2024_XX_XX_create_articles_table.php
  │   │   ├── seeders/
  │   │   │   └── articelseeder.php
  │   │   └── factories/
  │   │       └── articlefactory.php
  │   ├── app/                          # Dossier pour les fichiers moins fréquemment utilisés
  │   │   ├── config/                   # Dossier de configuration du module
  │   │   │   └── pkg_articles.php
  │   │   ├── providers/                # Service providers du module
  │   │   │   └── pkgarticleserviceprovider.php
  │   │   ├── http/                     # Dossier pour les composants HTTP
  │   │   │   ├── controllers/
  │   │   │   ├── middleware/
  │   │   │   └── requests/
  │   │   └── tests/                    # Tests spécifiques au module
  │   │       └── articletest.php
  ├── pkg_categories/
  │   ├── controllers/                  # Dossier accessible et couramment utilisé
  │   │   └── categorycontroller.php
  │   ├── models/                       # Dossier utilisé pour les modèles Eloquent
  │   │   └── category.php
  │   ├── resources/                    # Dossier avec les vues et les ressources locales
  │   │   ├── views/
  │   │   │   └── categories/
  │   │   │       └── index.blade.php
  │   │   └── lang/
  │   │       └── en/
  │   │           └── pkg_categories.php
  │   ├── routes/                       # Dossier pour les fichiers de routes spécifiques au module
  │   │   └── web.php
  │   ├── database/                     # Contient les fichiers liés à la base de données
  │   │   ├── migrations/
  │   │   │   └── 2024_XX_XX_create_categories_table.php
  │   │   ├── seeders/
  │   │   │   └── categoryseeder.php
  │   │   └── factories/
  │   │       └── categoryfactory.php
  │   ├── app/                          # Dossier pour les fichiers moins fréquemment utilisés
  │   │   ├── config/                   # Dossier de configuration du module
  │   │   │   └── pkg_categories.php
  │   │   ├── providers/                # Service providers du module
  │   │   │   └── pkgcategorieserviceprovider.php
  │   │   ├── http/                     # Dossier pour les composants HTTP
  │   │   │   ├── controllers/
  │   │   │   ├── middleware/
  │   │   │   └── requests/
  │   │   └── tests/                    # Tests spécifiques au module
  │   │       └── categorytest.php
  └── ...
