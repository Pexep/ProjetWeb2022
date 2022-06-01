# Rapport: développement d'un site web pour une entreprise d'économie circulaire

# Plan

- Introduction
- Organisation
- Wireflow
- Cas d'utilisations
- Conclusions personnelles
- Conclusion globlale

# Introduction
...

# Organisation

##  Repartitions des tâches

### Trello

Pour se répartir les tâches nous avons décidé d'utiliser [Trello](https://trello.com/b/i1b6ghEQ/site).

Ce magnifique outil nous permet de planifier les tâches et de les assigner à un membre du groupe. On peut voir l'avancée globale du projet mais aussi de chacune des parties du projet.

## Fonctionnement du repo git

### Choix de la plateforme

Gitlab a été notre choix principal pour nous permettre d'automatiser des tâches pour que chacun d'entre nous puisse travailler et ne pas avoir à attendre la personne chez qui le projet est hébergé.

### Déploiement automatique

Pour le déploiement nous avons décidé d'utiliser Gitlab, plus précisement la partie CI/CD qui nous permet de développer le site et d'envoyer les changements automatiquement sur le serveur dwarves à chaque push (principalement les pushs faits sur la branche `master`).

À chaque push, gitlab va exécuter ce que l'on appele des pipelines. Les pipelines permettent de faire des actions précisées dans un fichier appelé `gitlab-ci.yml` (pour gitlab). On peut choisir d'exécuter des tests, de déployer un site ou bien une application.

Dans notre cas, nous avons une pipeline qui vient compresser le dossier `src/` qui contient les fichiers sources du site. Puis une autre qui va envoyer ce fichier zip sur iluvatar et le décompresser ensuite dans notre dossier `public_html`.

On pourrait mettre en place des tests qui seront exécutés dans le premier pipeline pour vérifier que les fichiers .php ont une syntaxe valide.

# Wireflow

# Cas d'utilisations

# Conclusions personnelles

## Mathis

## Théo

## Yvan

# Conclusion globale
