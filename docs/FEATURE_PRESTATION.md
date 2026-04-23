# Feature : Prestations Réalisées

Cette feature assure le suivi des actes effectivement réalisés suite à un rendez-vous.

## 🏗️ Architecture du Domaine

### 1. Entité : `Prestation`
Représente l'acte finalisé.
*   **Propriétés** : Rendez-vous (ID), Service Proposé (ID), Date de réalisation, Coût total, Statut (réalisée).
*   **Identifiant** : `PrestationId` (Value Object).

---

## 🛠️ Couche Application

*   **Commande** : `RealiserPrestationCommand`.
*   **Handler** : `RealiserPrestationHandler`.
    *   **Logique** : Enregistre la prestation et déclenche la création/mise à jour du carnet de santé de l'animal.

---

## 🖥️ Couche UI (Administration)

*   **Contrôleur** : `PrestationAdminController`.
*   **Fonctionnalité** : Validation d'un rendez-vous terminé et liste historique des prestations.
