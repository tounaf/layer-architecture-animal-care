# Feature : Gestion des Rendez-vous

Cette feature permet la prise de rendez-vous entre un client et un prestataire pour un service donné.

## 🏗️ Architecture du Domaine

### 1. Entité : `RendezVous`
Gère l'état et l'horaire de la prestation.
*   **Propriétés** : Client (ID), Animal (ID), Prestataire (ID), Plage Horaire, Statut (En attente, Confirmé, Annulé).
*   **Logique métier** : Validation des créneaux (8h-20h), Transition d'états.

---

## 🔌 API REST

L'API permet la création de rendez-vous, notamment depuis une application mobile ou un frontend séparé.

### Créer un rendez-vous
*   **URL** : `POST /api/rendez-vous`
*   **Spécificité** : Permet la création du client et de l'animal "à la volée" si les IDs ne sont pas fournis mais que les informations de contact le sont.

---

## 🛠️ Couche Application

*   **Commandes** : `CreerRendezVousCommand` (supporte la création à la volée), `ConfirmerRendezVousCommand`.
*   **Handlers** : `CreerRendezVousHandler` (Orchestre la création Client/Animal/RDV).
