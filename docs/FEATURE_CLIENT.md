# Feature : Gestion des Clients

Cette feature permet de gérer la base de données des propriétaires d'animaux.

## 🏗️ Architecture du Domaine

### 1. Entité : `Client`
L'entité `Client` centralise les informations de contact.
*   **Propriétés** : Nom, Prénom, Email (unique), Téléphone, Ville.
*   **Identifiant** : `ClientId` (Value Object).

### 2. Contrat de Persistance
*   `ClientRepositoryInterface` définit les méthodes `save`, `findById`, `findAll` et `delete`.

---

## 🛠️ Couche Application

*   **Commandes** : `CreerClientCommand`, `ModifierClientCommand`.
*   **Handlers** : `CreerClientHandler`, `ModifierClientHandler`.

---

## 🔌 Couche Infrastructure

*   **Repository** : `DoctrineClientRepository`.
*   **Mapping** : XML dans `config/doctrine/client/Client.orm.xml`.
*   **Types DBAL** : `client_id`.

---

## 🖥️ Couche UI

### Administration
*   **Controller** : `ClientAdminController` (`/admin/client`).
*   **Menu** : `ClientMenuProvider`.
*   **Template** : `templates/admin/client/`.

### Espace Public (Espace Client)
L'Espace Client est une interface dédiée aux propriétaires d'animaux.
*   **Accès** : `/mon-espace`.
*   **Controller** : `ClientSpaceController`.
*   **Authentification** : Utilise le système de sécurité standard. Le lien entre l'utilisateur connecté (`User`) et l'entité `Client` se fait par l'adresse email.
*   **Fonctionnalités** :
    *   **Dashboard** : Vue d'ensemble des rendez-vous et animaux.
    *   **Factures** : Consultation de l'historique de facturation.
    *   **Profil** : Informations personnelles.
*   **Templates** : `templates/public/client/`.
