# Feature : CARE (Suivi Médical / Carnet de Santé)

Cette feature implémente la gestion complète du carnet de santé des animaux, permettant un suivi chronologique des actes médicaux, des constantes et des alertes sanitaires.

## 🏗️ Architecture du Domaine

### 1. Agrégat Racine : `CarnetSante`
Le `CarnetSante` est l'entité centrale liée à un `AnimalId`. Il orchestre :
*   L'ajout d'entrées médicales.
*   Le suivi des constantes (poids, température).
*   La gestion des alertes (allergies, maladies chroniques).
*   La génération de rappels automatiques.

### 2. Entités et Objets de Valeur (DDD)
*   **Entités** :
    *   `EntreeCarnet` : Acte médical typé (Vaccination, Consultation, etc.).
    *   `SuiviConstante` : Mesure ponctuelle (Poids, Température).
    *   `Alerte` : Information critique à afficher prioritairement.
    *   `Rappel` : Événement futur généré à partir d'une entrée.
*   **Value Objects** :
    *   `CarnetSanteId`, `EntreeCarnetId` : Identifiants forts.
    *   `AnimalId`, `PrestataireId` : Références vers d'autres domaines.
*   **Enum** :
    *   `TypeEntree` : Catégorisation stricte des actes.

### 3. Événements de Domaine
*   `EntreeAjoutee` : Publié chaque fois qu'un acte est consigné au carnet.

---

## 🛠️ Couche Application (Cas d'Usage)

*   **Command** : `CreerCarnetSanteCommand`
*   **Handler** : `CreerCarnetSanteHandler`
    *   Vérifie l'existence préalable d'un carnet pour l'animal.
    *   Initialise un nouvel agrégat `CarnetSante`.
    *   Persiste via le repository.

---

## 🔌 Couche Infrastructure (Adaptateurs)

### 1. Persistance
*   **Repository** : `DoctrineCarnetSanteRepository` implémente `CarnetSanteRepositoryInterface`.
*   **Mapping** : Configuration XML dans `config/doctrine/` pour maintenir la pureté du Domaine (aucune annotation Doctrine dans `src/Domain`).
*   **Types DBAL** : Types personnalisés pour le mapping automatique des Value Objects (`carnet_sante_id`, `animal_id`, etc.).

### 2. Intégration Système
*   Déclaration des mappings et des types dans `config/packages/doctrine.yaml`.

---

## 🖥️ Couche UI (Interface Utilisateur)

### 1. Administration
*   **Controller** : `CareAdminController` gérant les routes `/admin/care`.
*   **Menu** : `CareMenuProvider` injecte dynamiquement "Carnet de Santé" dans la sidebar.
*   **Template** : `templates/admin/care/index.html.twig` fournissant le tableau de bord du suivi médical.

---

## 🔍 Commandes Utiles

### Débogage UI
Pour vérifier que le menu CARE est bien enregistré :
```bash
php bin/console app:debug:ui
```

### Génération de Schéma
Pour créer les tables en base de données :
```bash
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```

---
*Documentation générée le 21/04/2026 suite à l'implémentation initiale.*
