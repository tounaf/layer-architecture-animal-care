# Feature : Gestion des Clients

Cette feature permet de gérer la base de données des propriétaires d'animaux.

## 🏗️ Architecture du Domaine

### 1. Entité : `Client`
L'entité `Client` centralise les informations de contact.
*   **Propriétés** : Nom, Prénom, Email (unique), Téléphone.
*   **Identifiant** : `ClientId` (Value Object).

### 2. Contrat de Persistance
*   `ClientRepositoryInterface` définit les méthodes `save` et `findById`.

---

## 🔌 Couche Infrastructure

*   **Repository** : `DoctrineClientRepository`.
*   **Mapping** : XML dans `config/doctrine/Domain.Client.Entity.Client.orm.xml`.
*   **Types DBAL** : `client_id`.

---

## 🖥️ Couche UI

*   **Controller** : `ClientAdminController` (`/admin/client`).
*   **Menu** : `ClientMenuProvider`.
*   **Template** : `templates/admin/client/index.html.twig`.
