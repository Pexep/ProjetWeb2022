# Rapport: développement d'un site web pour une entreprise d'économie circulaire

# Plan

- Introduction
- Organisation
- Wireflow
- Cas d'utilisations
- Conclusions personnelles
- Conclusion globlale

# Introduction

Le but de la SAÉ est de créer un site web permettant à un utilisateur d'acheter du matériel informatique et d'en revendre à des entreprises spécialisées dans le recyclage. 

L'utilisateur doit pouvoir voir sa cagnotte, ainsi que les matériaux qu'il a permis de recycler. Il peut aussi parcourir le site pour acheter et revendre du matériel.

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

On pourrait mettre en place des tests qui seront exécutés dans le premier pipeline pour vérifier que les fichiers .php ont une syntaxe valide et qu'ils contiennent bien des valeurs que l'on doit pouvoir retrouver pendant le fonctionnement normal du site.

### Branches autres que master

Lorsque l'on push sur une branche différente de master, le script vient changer le nom du dossier dans lequel sera mis le site comme ceci: `k_$COMMIT_BRANCH_NAME` -> `k_yvan`.
Cela permet de tester en cas de grand changements et que l'on puisse approuver le travail de chaque personne du groupe.

# Wireflow

Le wireflow étant un peu lourd, il se trouve dans le même dossier que ce rapport.

# Cas d'utilisations

Faire des cas d'utilisations ici.

# Conclusions personnelles

## Mathis

## Théo

Personnellement, j'ai apprécié ce projet puisque je préfère le travail en équipe à un travail individuel : être à plusieurs permet de partager son savoir avec ses camarades, d'avoir différents points de vue et différentes approches d'un même élément, et c'est quelque chose que j'affectionne.

## Yvan

Pour moi le projet fut intéréssant, l'aspect (re)découverte du travail en groupe m'a permis de mieux maîtriser git qu'avant. J'ai pu aussi avoir beaucoup de plaisir à paramètrer le déploiement automatique du site grâce à la CI/CD de gitlab. Cela fut un défi technique intéréssant à relever.

# Conclusion globale
