# Contribution pour ToDoList App

1/ Installez le projet en local
Si ce n'est déjà fait, installez le projet sur votre machine via Git, en suivant les insctructions d'installation du fichier Readme.
Plus de détails sur la documentation GitHub.

2/ Faire issues - Créez une nouvelle issue que vous mettrez à jour tout au long du processus.
et Contrôlez si elle n'est pas déjà crée.  Mettez à jour si nécessaire.

3/ Créez une nouvelle branche en respectant les conventions : (en anglais de préférence).
            git checkout -b [prefix]/[name],
            hotfix/ : pour les modifications/bugs,
            feature/ : pour l'ajout de nouvelles fonctionnalités.

4/ Travaillez sur votre branche

5/ Testez vos modifications
Lancez les tests pour vérifier qu'ils passent toujours après vos modifs :

6/ Verifiez la qualité de votre code Avant de commiter votre code

7/ Commitez votre code git commit -m "votre message détaillé"

Type :

- build : changements qui affectent le système de build ou des dépendances externes (npm, make…)
- ci : changements concernant les fichiers et scripts d’intégration ou de configuration (Travis, Ansible, BrowserStack…)
- feat : ajout d’une nouvelle fonctionnalité
- fix : correction d’un bug
- perf : amélioration des performances
- refactor : modification qui n’apporte ni nouvelle fonctionnalité ni d’amélioration de performances
- style : changement qui n’apporte aucune altération fonctionnelle ou sémantique (indentation, mise en forme, ajout d’espace, renommage d’une   variable…)
- docs : rédaction ou mise à jour de documentation
- test : ajout ou modification de tests-

8/ Push votre branch git push origin my-new-feature

9/ Créez des Pull Request

10/ php/bin/phpunit
    Mettez à jour les tests existants 
    Créez vos test.

11/Standards à respecter

- PSR-1  = Norme de codage de base
- PSR-2  = Guide de style ( remplacée par PSR-12)
- PSR-4  = Amélioration de la PSR-0 Spécification pour les classes de chargement auto ( directive structure des fichiers)
- PSR-7  = Interfacde de message HTTP

- Le code doit respecter les standards de code de Symfony [link Contributing](https://symfony.com/doc/current/contributing/code/conventions.html)

12/ Les conventions de noms
Utilisez des espaces de noms pour toutes vos classes et nommez-les dans UpperCamelCase
Les variables, fonctions et arguments doivent être nommés dans camelCase
