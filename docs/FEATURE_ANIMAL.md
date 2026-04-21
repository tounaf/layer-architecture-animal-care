# Feature : Gestion des Animaux

Cette feature permet de gérer le registre des animaux de la plateforme.

## 🏗️ Architecture du Domaine

### 1. Entité : `Animal`
L'entité `Animal` est liée à un propriétaire via son `ClientId`.
*   **Propriétés** : Nom, Espèce, Race, Date de Naissance.
*   **Identifiant** : `AnimalId` (Value Object).

### 2. Contrat de Persistance
*   `AnimalRepositoryInterface` définit les méthodes `save` et `findById`.

---

## 🔌 Couche Infrastructure

*   **Repository** : `DoctrineAnimalRepository`.
*   **Mapping** : XML dans `config/doctrine/Domain.Animal.Entity.Animal.orm.xml`.
*   **Types DBAL** : `animal_id`.

---

## 🖥️ Couche UI

*   **Controller** : `AnimalAdminController` (`/admin/animal`).
*   **Menu** : `AnimalMenuProvider`.
*   **Template** : `templates/admin/animal/index.html.twig`.
