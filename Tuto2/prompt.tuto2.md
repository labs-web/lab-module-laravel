Pour obtenir un tutoriel détaillé sur l'implémentation d'une architecture modulaire dans une application Laravel monolithique avec des modules pour un blog (comme `GestionArticle` et `GestionCategories`), voici un prompt précis :

**Prompt :**

## ¨Prompt 1.1

Créez un tutoriel détaillé expliquant comment implémenter une architecture modulaire dans une application Laravel monolithique sans utiliser de package externe pour la gestion des modules. Le tutoriel doit guider étape par étape sur la création d'une application de blog avec deux modules : « GestionArticle » et « GestionCategories ». Il doit expliquer comment structurer les répertoires pour chaque module (y compris les contrôleurs, les modèles, les routes, les migrations et les vues) et fournir des exemples de code pour la configuration des routes, des contrôleurs, des modèles et des migrations.

Incluez une section expliquant comment charger les routes de chaque module dans le fichier principal Laravel ('web.php') et décrivez les bonnes pratiques pour organiser le code et gérer les dépendances entre les modules. Ajoutez également des commandes pour : créer une application Laravel vide, et les migrations et seeders nécessaires pour les modèles Article et Category avec une relation entre eux.

Fournissez des exemples complets de code pour les vues, les contrôleurs, les modèles, les routes et les seeders pour les deux modules Article et Catégories, ainsi que des instructions pour configurer le chargement des vues dans AppServiceProvider.

## Sans utilisation de package nWidart/laravel-modules

Écrire un tutoriel détaillé expliquant comment implémenter une architecture modulaire dans une application Laravel monolithique sans utiliser de package externe pour la gestion des modules. 

Le tutoriel doit guider étape par étape sur la création d'une application de blog avec deux modules, `GestionArticle` et `GestionCategories`. 

Expliquer comment structurer les dossiers pour chaque module (incluant `Controllers`, `Models`, `Routes`, `Migrations`, et `Views`) et fournir des exemples de code pour la configuration des routes, des contrôleurs, des modèles, et des migrations. 

Ajouter une section expliquant comment charger les routes de chaque module dans le fichier principal de Laravel (`web.php`) et détailler les pratiques pour organiser le code et gérer les dépendances entre modules.

Ajouter des commande pour 
- la création d'une application Laravel vide 
- Tous les commende doit être écuter dans powershell

- Ajouter une relation à la base de donnée entre Article et catégorie 
- Ajouter des instruction la configuration de chargement des view dans AppServiceProvider

- Donner code complet de View,Controller, et Modules, et Seeder des deux module Article et Catégories, 



## Avec utilisation de package nWidart/laravel-modules

Écrire un tutoriel détaillé pour implémenter une architecture modulaire dans une application Laravel monolithique en utilisant le package `nWidart/laravel-modules`. Le tutoriel doit inclure un exemple d'application de blog, avec deux modules nommés `GestionArticle` et `GestionCategories`. Expliquer chaque étape, de l'installation du package et la création des modules jusqu'à la configuration des routes, des contrôleurs et des migrations. Ajouter des exemples de code pour chaque étape, et inclure une section sur la manière de structurer les dossiers et de gérer les dépendances entre modules dans Laravel.
