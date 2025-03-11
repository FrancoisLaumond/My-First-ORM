# My-First-ORM

## Description
Mini ORM dans le cadre du cours POO-Framework. Ce projet utilise plusieurs bibliothèques pour gérer les variables d'environnement et fournir des fonctionnalités ORM simples.

## Installation
1. Clonez le dépôt :
    ```bash
    git clone https://github.com/votre-utilisateur/My-First-ORM.git
    ```
2. Accédez au répertoire du projet :
    ```bash
    cd My-First-ORM
    ```
3. Installez les dépendances via Composer :
    ```bash
    composer install
    ```

## Configuration
1. Créez un fichier `.env` à la racine du projet et ajoutez vos configurations de base de données :
    ```env
    DB_HOST=localhost
    DB_PORT=8889
    DB_NAME=mini-orm
    DB_USER=root
    DB_PASS=root
    ```

## Utilisation
1. Chargez les variables d'environnement en incluant le fichier `bootstrap.php` :
    ```php
    require 'bootstrap.php';
    ```

2. Utilisez les modèles pour interagir avec la base de données. Par exemple, pour récupérer les élèves :
    ```php
    use Awl\Orm\User;

    $modelUser = (new User())->eleves();

    echo '<pre>';
    print_r($modelUser);
    echo '</pre>';
    ```

## Dépendances
- `vlucas/phpdotenv` : Pour charger les variables d'environnement depuis un fichier `.env`.
- `symfony/polyfill-ctype` : Fournit les fonctions `ctype_*` pour les versions PHP sans l'extension ctype.
- `symfony/polyfill-mbstring` : Fournit une implémentation partielle en PHP natif pour l'extension Mbstring.
- `symfony/polyfill-php80` : Fournit des fonctionnalités ajoutées au noyau PHP 8.0.
- `graham-campbell/result-type` : Une implémentation du type de résultat.
- `phpoption/phpoption` : Fournit le type Option pour PHP.

## Auteurs
- Francois Laumond
