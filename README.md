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
    - Page d'accueil :
      - ![Capture 1](https://user-images.githubusercontent.com/67027958/150721485-231af81e-b789-498e-a98a-fd27cfe8cbf2.PNG)
    
    - Cours particuliers : 
      - ![Capture 2](https://user-images.githubusercontent.com/67027958/150723857-63cc6de1-44e5-4362-9b0a-c12357c2f5f3.PNG)

    - Cours collectifs :
      - ![Capture 3](https://user-images.githubusercontent.com/67027958/150723921-5d111a20-26ec-40fa-95cf-0fcfae94da31.PNG)

    - Cours de Yoga :
      - ![Capture 4](https://user-images.githubusercontent.com/67027958/150723944-841ad2da-278e-41d3-8514-5842c2b586cf.PNG)

    - Les offres :
      - ![Capture 5](https://user-images.githubusercontent.com/67027958/150723962-f07c172d-bdc0-4966-8966-4b55092c97d1.PNG)

    - Formulaire de réservation - Cours particuliers :
      - ![Capture 6](https://user-images.githubusercontent.com/67027958/150723988-a842d330-d746-4400-a1f7-65b0cf2daa14.PNG)

    - Formulaire de réservation - Cours collectifs :
      - ![Capture 7](https://user-images.githubusercontent.com/67027958/150724010-7fa8e4a3-75a9-4135-8d75-035666147bc7.PNG)
    
    - Formulaire de contact :
      - ![Capture 8](https://user-images.githubusercontent.com/67027958/150724035-e4ecac1d-9a68-45b1-8926-d4607fe45a41.PNG)

## Sécurité :
Au niveau de la sécurité, plusieurs actions ont été réalisés : 
  - Utilisation de mot de passe sécurisée
  - Modification du préfixe de la base de données
  - Supression du compte administrateur par défaut
  - Masquer la version de Wordpress
  - Ajouter des clés de sécurité secrètes dans le fichier wp-config.php
  - Bloquer l'accès au fichier README.HTML


