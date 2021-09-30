## P8 TodoList   -  Description du projet


## Votre rôle ici est donc d’améliorer la qualité de l’application. La qualité est un concept qui englobe bon nombre de sujets : on parle souvent de qualité de code, mais il y a également la qualité perçue par l’utilisateur de l’application ou encore la qualité perçue par les collaborateurs de l’entreprise, et enfin la qualité que vous percevez lorsqu’il vous faut travailler sur le projet.


  ## Tâches à faire  
```sh

  1. implémentation de nouvelles fonctionnalités 
  2. corriger les anomalies 
  3. implémenter les tests automatisés

  ### Correction des anomalies :
    - automatiquement, à la sauvegarde de la tâche, l’utilisateur authentifié soit rattaché à la tâche nouvellement créée.
    - Lors de la modification de la tâche, l’auteur ne peut pas être modifié.
    - les tâches déjà créées, il faut qu’elles soient rattachées à un utilisateur “anonyme”.


  ### Tests automatisés :
    - les implémenter avec PHPUnit
    - prévoir les données de test pour prouver le bon fonctionnement dans les    cas explicités ici.
    - fournir un rapport de couverture de code à la fin du projet. Taux de couverture supérieur à 70%.

  ### Rôle utilisateur
  - Choisir un rôle pour un utilisateur
    - Administrateur (ROLE_ADMIN)
    - utilisateur (ROLE_USER)

  ### Autorisation
  - Seuls les utilisateurs ayant le rôle administrateur (ROLE_ADMIN) doivent pouvoir accéder aux pages de gestion des utilisateurs.
 - Les tâches rattachées à l’utilisateur “anonyme” peuvent être supprimées uniquement par les utilisateurs ayant le rôle administrateur (ROLE_ADMIN).
```
### Pré Requis

  
  - Composer [Link download composer](https://getcomposer.org/download/)

### Library
  - composer require --dev theofidry/alice-data-fixtures
  - composer require fzaninotto/faker


##  Guide d'installation

  - Clonez ou téléchargez le repository GitHub dans le dossier :
  ```sh
  git clone https://github.com/pascalinecte91/TodoList_.git
  ```

  - Copier le fichier .env dans un autre fichier .env.local
  - creation DataBase, configurer le fichier .env.local exemple :
  ```yaml
   DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/projet_todoList?serverVersion=5.7"
  ```
  - lancez l'installation des dépendances
  ```sh
   composer install
   
  - php bin/console asset:install
  ```

## Commandes Symfony executions diverses
  ```
  1. Creation database : 
    - php bin/console doctrine:database:create
  2. Proceder à la migration : 
    - php bin/console doctrine:migrations:migrate
  3. Installer les fixtures :
    - php bin/console doctrine:fixture:load
```

## Autres commandes:
```
 - Vider cache si besoin:
    - php bin/console cache:clear
```

## Documentation


  - Produire une "documentation technique"
    - expliquer l'implémentation de l'authentification
    - prévoir qu'un débutant puisse :
      - comprendre quel(s) fichier(s) il faut modifier et pourquoi
      - comment s’opère l’authentification
      - où sont stockés les utilisateurs.
      - ...

  - Produire documentation des procédures  pour tous nouveaux développeurs souhaitant apporter des modifications au projet.
      - detail du processus de qualité
      - règle à respecter.

  - Audit de performance : 
      - Blackfire obligatoire


Auteur
- pascale CHRISTOPHE  Elève OpenClassroom
   

