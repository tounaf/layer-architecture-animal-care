# Feature : Catalogue des Services & Tarification

Cette feature gère les services proposés par la plateforme, leur catégorisation et leur tarification.

## 🏗️ Architecture du Domaine

### 1. Entité : `ServiceCategorie`
Regroupe les services par thématique (ex: Consultations, Vaccinations, Toilettage).
*   **Propriétés** : Nom, Description, Icône, Ordre d'affichage, État (actif/inactif).
*   **Identifiant** : `ServiceCategorieId` (Value Object).

### 2. Entité : `Service`
Représente un acte ou une prestation spécifique.
*   **Propriétés** : Nom, Code unique, Description, Durée par défaut (minutes), Nécessite un acompte, État (actif/inactif).
*   **Identifiant** : `ServiceId` (Value Object).
*   **Relation** : Lié à une `ServiceCategorie`.

### 3. Objet Embarqué : `Tarif` (Value Object)
Le tarif actuel est encapsulé dans le service.
*   **Propriétés** : Montant, Devise, Date d'application.

---

## 🔌 Couche Infrastructure

### 1. Persistance
*   **Repository** : `DoctrineServiceRepository`.
*   **Mapping** : Configuration XML dans `config/doctrine/service/` pour `Service`, `ServiceCategorie` et `Tarif`.
*   **Types DBAL** : `service_id` et `service_categorie_id` pour le mapping des Value Objects.

### 2. Données Initiales (Fixtures)
Le catalogue complet est chargé via `ServiceFixtures` dans `src/Infrastructure/Persistence/Doctrine/Fixtures/`.
Il comprend 8 catégories et 31 services pré-configurés.

---

## 🖥️ Couche UI

*   **Controller** : `ServiceAdminController` (`/admin/service`).
*   **Menu** : `ServiceMenuProvider`.
*   **Template** : `templates/admin/service/index.html.twig`.

---

## 🔍 Commandes Utiles

### Charger le catalogue
```bash
php bin/console doctrine:fixtures:load --append
```
