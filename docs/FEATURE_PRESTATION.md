# Feature : Prestations Réalisées & Champs Dynamiques

Cette feature assure le suivi des actes finalisés et permet de collecter des informations spécifiques selon le type de service (vaccination, chirurgie, etc.).

## 🏗️ Architecture du Domaine

### 1. Entité : `Prestation`
Représente l'acte finalisé.
*   **Propriétés** : Rendez-vous (ID), Service Proposé (ID), Date de réalisation, Coût total.
*   **Identifiant** : `PrestationId` (Value Object).

### 2. Entité : `ServiceChamp`
Définit un champ de donnée supplémentaire réutilisable.
*   **Propriétés** : Nom, Type (text, textarea, date, file, etc.), Obligation.

### 3. Entité : `PrestationValeurChamp`
Stocke la valeur saisie pour un champ lors d'une prestation donnée.

### 4. Entité : `Document`
Gère les fichiers uploadés (ordonnances, analyses, photos) liés aux prestations.

---

## 🛠️ Couche Application

*   **Commande** : `RealiserPrestationCommand`.
*   **Handler** : `RealiserPrestationHandler`.
    *   **Flow** :
        1. Enregistre la prestation.
        2. Traite les valeurs des champs dynamiques.
        3. Gère l'upload et la persistance des documents si nécessaire.
        4. Crée ou met à jour le **Carnet de Santé** de l'animal.
        5. Ajoute une entrée historique dans le carnet de santé.

---

## 🖥️ Couche UI (Administration)

*   **Validation** : Depuis un rendez-vous, un bouton permet d'accéder au formulaire de validation de prestation.
*   **Champs dynamiques** : Le formulaire génère automatiquement les entrées basées sur les `ServiceChamp` enregistrés.
*   **Upload** : Support complet des fichiers via le service `FileUploader`.

---

## 🔌 Infrastructure

*   **Stockage** : Les fichiers sont stockés dans `public/uploads/` avec une organisation chronologique (`AAAA/MM`).
*   **Persistence** : Mappings XML pour toutes les nouvelles entités.
