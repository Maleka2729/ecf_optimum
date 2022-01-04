# ecf_optimum

## Description des besoins
Monsieur le Directeur GA souhaite moderniser son site internet en ajoutant un module de réservation pour les différents cours de sport et autres services. 
Il souhaite aussi, rendre son site internet accessible sur mobile. Egalement, une tablette à l'entrée de la salle de sport sera mise à disposition, pour confirmer la présence des inscrits aux séances réservés. De plus, le client souhaite conserver son rôle de community manager.

## Définition des utilisateurs
  - Administrateur : Monsieur le directeur GA.
  - Client : les personnes visitant le site « OPTIMUM ».

## Besoins fonctionnels 
**ADMINISTRATEUR**
  - En tant qu'administrateur, je veux présenter la salle en ajoutant des photos, du texte, afin d'informer les clients et d'être visible sur les moteurs de recherche.

**CLIENT**
  - En tant que client, je veux accéder aux cours particulier, collectifs et offres proposés, afin de m'informer.
  - En tant que client, je veux m'inscrire via un formulaire de réservation, afin de participer soit à un cours collectif ou soit à un cours particulier.
  - En tant que client, je veux m'inscrire via un formulaire de réservation, afin d'accéder à une offre.
  - En tant que client, je veux informer ma présence à l'entrée de la salle, afin de confirmer ma réservation pour cette séance.
  - En tant que client, je veux accéder au site « OPTIMUM » sur mon téléphone, afin de pouvoir réserver plus facilement.

## Spécifications technique
  - Le projet sera réalisé via une solution CMS « WordPress » pour rendre le site « OPTIMUM » accessible sur pc et sur le téléphone.
  - Concernant la base de données, nous utiliserons mysql Workbench.

## Plan du site
  - Accueil,
    - Présentation du site
  - Les cours : 
    - Cours particuliers : Présentation renforcement musculaire + préparation physique
    - Cours collectifs : Présentation cardio training + cross training
    - Séance : Présentation séance Yoga
  - Les offres : 
    -  Accès à la salle de musculation : abonnement mensuel + annuel
  - Réservations : formulaire de réservation  
  - Contact : formulaire de contact

## Maquette : 
  - Le maquettage a été réalisé avec l'application web Figma. Ci-joint le lien pour accéder aux maquette : 
    - https://www.figma.com/file/qgsvPgSJQwRsQWQiLNBgj5/OPTIMUM?node-id=0%3A1

## Sécurité :
Au niveau de la sécurité, plusieurs actions ont été réalisés : 
  - Utilisation de mot de passe sécurisée
  - Modification du préfixe de la base de données
  - Supression du compte administrateur par défaut
  - Masquer la version de Wordpress
  - Ajouter des clés de sécurité secrètes dans le fichier wp-config.php
  - Bloquer l'accès au fichier README.HTML


