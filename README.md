# Sujet test Symfony / API

Le but du test est de pouvoir importer un fichier CSV d'une liste de Pokémon (fournis dans le test) et de créer une API avec [API Platform](https://api-platform.com/) afin d'effectuer des actions sur les données
* L’utilisation de la version de Symfony est libre (de préférence Symfony 4.x ou 5.x).
* Le choix du type de la base de donnée est également libre.

Une authentification sera nécessaire afin de pouvoir utiliser l'API sur certaines routes.

Voici les spécifications demandées:
## Import du fichier
- Vous devrez créer une commande permettant d'importer le fichier CSV afin de remplir votre base de donnée.
- Seul les fichiers CSV seront acceptés
- Le fichier est présenté sous cette forme

Type 2	Total	HP	Attack	Defense	Sp. Atk	Sp. Def	Speed	Generation	Legendary

| #   | Name | Type 1 | Type 2 | Total |  HP | Attack | Defense | Sp. Atk | Sp. Def | Speed | Generation | Legendary |
| ---:|-----:| ------:| ------:| -----:| ---:| ------:| -------:| -------:| -------:| -----:| ----------:| ---------:|

``$ bin/console app:import:csv FILEPATH``

> À noter que l'ordre des colonnes ne doit pas impacter l'import
## Actions sur l'API:
### Inscription:

- [X] Email et mot de passe obligatoire
- [X] Le champs email doit être un email valide et unique
- [X] Le champs mot de passe doit comporter au minimum **8 caractères**, **une majuscule**, **une miniscule** et **un caractère spécial** ``,;:?./@#"'{}[]-_()$*%=+``
- [X] Contrôle et retour d'erreur si les champs ne sont pas valide

### Connexion:
L’utilisateur doit pouvoir se connecter avec:
- email
- mot de passe

- [X] Une fois connecté, un **token** devra être généré pour le reste de l'utilisation de l'API

## Pokémon:

### Index / Show:
- [X] Route publique
- [X] Pouvoir voir un Pokémon spécifique grâce à son **ID**
- [X] Renvoie la liste de Pokémon 50 par 50
- [X] Possibilité de changer de page et de changer le nombre de ligne affiché
- [X] Possibilité de filtrer / rechercher par
  - [X] Nom
  - [X] Type
  - [X] Génération
  - [X] Légendaire

### Edit / Delete:
- [X] Route privée
- [X] Ne pas pouvoir éditer / supprimer un Pokémon Légendaire
- Possibilité d'éditer
  - [X] Nom
  - [ ] Type (changer parmis les types présents. Pas de possibilité d'en ajouter)
  - [X] Génération
  - [X] Légendaire

## Nice to have :

* Commande d’installation du projet
* Interface

## Bonus:

* Test unitaire
* Soyez créatif :)
