# Clothify

Ceci est le fichier README pour l'API [Clothify]. Cette API utilise la plateforme API Platform pour créer, documenter et gérer une API RESTful.

## Présentation

[L'API](https://github.com/parad0xe/clothify-api) fournit des fonctionnalités pour accéder à une liste de produits, créer des commandes, gérer
la connexion des utilisateurs et permettre la création de nouveaux utilisateurs. Voici une description plus détaillée des fonctionnalités :

Liste de produits : L'API permet de récupérer la liste des produits disponibles. Chaque produit est associé à des informations telles que son nom, sa
description, son prix, etc. Les utilisateurs peuvent consulter cette liste pour obtenir des informations sur les produits disponibles.

Autorisation et Création de commande Paypal : Les utilisateurs peuvent utiliser l'API pour autoriser et créer des commandes ayant été effectué via
paypal en spécifiant la réference de la commande renvoyée par Paypal ainsi que les informations de leur panier tel que les produits, leurs attributs, 
les quantités. Une fois la commande approuvée et créée, l'API fournit un identifiant unique pour suivre l'état de la commande.

Connexion d'utilisateur : L'API permet aux utilisateurs de s'authentifier et de se connecter à leur compte. Cela leur donne accès à des
fonctionnalités spécifiques, telles que la possibilité de finaliser une commande, la visualisation de leurs commandes précédentes, etc. 
Les utilisateurs peuvent utiliser leurs informations d'identification (email et mot de passe) pour se connecter via l'API.

Création d'un utilisateur : Les nouveaux utilisateurs peuvent créer un compte en utilisant l'API. Ils peuvent fournir les informations nécessaires,
telles que leur nom, leur adresse e-mail, un mot de passe, une addresse de livraison et de facturation, pour créer un compte utilisateur. Une fois
créé, l'utilisateur peut se connecter en utilisant les informations d'identification fournies lors de la création du compte.

## Installation et configuration

> Assurez-vous d'avoir installé PHP, Composer et Symfony sur votre machine avant de commencer.\
> Ainsi que les extensions php : openssl

Pour utiliser cette API localement, suivez les étapes suivantes :

1 - Clonez le dépôt :
```bash
git clone https://github.com/parad0xe/clothify-api
cd ./clothify-api
```

2 - Installez les dépendances :
```bash
composer install
```

3 - Configurez les variables d'environnement :
```bash
cp .env .env.local
# Configurez les variables d'environnement du fichier .env.local
```

4 - Créer l'autorité de certification locale (activation de TLS) :
```bash
symfony server:ca:install
```

5 - Générez les clés SSL utilisé pour les tokens JWT :
```bash
php bin/console lexik:jwt:generate-keypair
```

6 - Créer la base donnée :
```bash
php bin/console doctrine:database:create
```

7 - Exécutez les migrations de base de données :
```bash
php bin/console doctrine:migrations:migrate
```

8 - Exécutez les fixtures pour avoir un jeu de donnée :
```bash
php bin/console doctrine:fixtures:load
```

9 - Lancez le serveur de développement :
```bash
symfony serve
```

La configuration est terminée, l'application démarre sur https://localhost:8000/api