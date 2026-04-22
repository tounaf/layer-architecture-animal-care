# Feature : Gestion des Prestataires

Cette feature gère les structures et professionnels (vétérinaires, toiletteurs, etc.) inscrits sur la plateforme, ainsi que les services qu'ils proposent.

## 🏗️ Architecture du Domaine

### 1. Entité : `Prestataire`
Représente un professionnel ou une structure de soin.
*   **Propriétés** : Nom de structure, Nom/Prénom de contact, Profession, Statut de validation.
*   **Identifiant** : `PrestataireId` (Value Object).

### 2. Entité : `ServicePropose`
Définit le lien entre un prestataire et un service du catalogue général.
*   **Propriétés** : Prestataire (ID), Service (ID), État (actif/inactif), Description personnalisée.
*   **Identifiant** : `ServiceProposeId` (Value Object).

---

## 🛠️ Couche Application

*   **Commandes** : `CreerPrestataireCommand`, `ModifierPrestataireCommand`, `CreerServiceProposeCommand`, `ModifierServiceProposeCommand`.
*   **Handlers** : Gèrent la logique de création et mise à jour.

---

## 🔌 Couche Infrastructure

*   **Mapping** : XML dans `config/doctrine/prestataire/`.
*   **Repositories** : `DoctrinePrestataireRepository`, `DoctrineServiceProposeRepository`.

---

## 🖥️ Couche UI (Administration)

*   **Contrôleur** : `PrestataireAdminController` (`/admin/prestataire`).
*   **Fonctionnalités** : CRUD Prestataire, Gestion des services proposés par prestataire.
