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

## 🔄 Cycle de Vie & États

Le rendez-vous suit un flux précis pour garantir la cohérence métier.

### États possibles (`StatutRendezVous`) :
1.  **En attente** : État initial après création.
2.  **Confirmé** : Le prestataire a validé le créneau. **Obligatoire** pour pouvoir créer une prestation.
3.  **Annulé** : Le rendez-vous ne pourra plus être honoré (nécessite un motif).
4.  **Terminé** : Une prestation a été réalisée pour ce rendez-vous.

### Actions disponibles :
*   **Confirmer** : Passe de `En attente` à `Confirmé`.
*   **Annuler** : Peut être fait depuis l'état `En attente` ou `Confirmé`.
*   **Reporter** : Modifie la date et l'heure. Possible tant que le RDV n'est pas `Terminé`.
*   **Terminer** : Action automatique lors de la réalisation d'une prestation.

---

## 🛠️ Couche Application

*   **Commandes** : 
    *   `CreerRendezVousCommand` : Initialisation.
    *   `ConfirmerRendezVousCommand` : Validation simple.
    *   `AnnulerRendezVousCommand` : Requiert l'ID et un motif.
    *   `ReporterRendezVousCommand` : Requiert l'ID, la nouvelle date et l'heure.
*   **Handlers** : Gèrent la persistence et le dispatch des événements de domaine (`RendezVousConfirme`, `RendezVousAnnule`).

---

## 🖥️ Interface Admin

La liste des rendez-vous (`/admin/rendez-vous`) adapte ses boutons selon l'état :
*   **Boutons Confirm/Annuler/Reporter** : Visibles pour les rendez-vous en attente.
*   **Bouton Créer Prestation** : Visible **uniquement** si le statut est `Confirmé`.
*   **Formulaire de report** : Intégré en ligne (inline) pour une modification rapide sans quitter la liste.
