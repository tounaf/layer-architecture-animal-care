# Espace Client

Un nouvel espace public a été implémenté pour permettre aux clients de gérer leurs interactions avec la clinique.

## 🏗️ Architecture (`src/UI/Http/Public`)

- **Contrôleur** : `ClientSpaceController`.
- **Accès** : L'accès est protégé par la sécurité Symfony standard. Le lien entre l'utilisateur connecté (`User`) et l'entité `Client` se fait par l'adresse email.

## 🖥️ Fonctionnalités

- **Tableau de Bord** : Vue d'ensemble des rendez-vous à venir et de la liste des animaux du client.
- **Gestion des Rendez-vous** : Visualisation du statut de chaque demande (en attente, confirmé, etc.).
- **Facturation** : Historique des factures émises pour le client.
- **Profil** : Consultation des informations personnelles.

## 🎨 Templates
Les templates utilisent le layout `templates/public/client/layout.html.twig` qui fournit une navigation simplifiée et distincte de l'interface d'administration.
