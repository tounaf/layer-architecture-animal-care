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

## 🛠️ Couche Application (Cas d'Usage)

La modification des données transite par des Commandes et des Handlers pour garantir l'intégrité métier.

*   **Catégories** : `CreerServiceCategorieCommand`, `ModifierServiceCategorieCommand`.
*   **Services** : `CreerServiceCommand`, `ModifierServiceCommand`.

---

## 🔌 Couche Infrastructure

### 1. Persistance
*   **Repository** : `DoctrineServiceRepository` et `DoctrineServiceCategorieRepository`.
*   **Mapping** : Configuration XML dans `config/doctrine/service/`.
*   **Types DBAL** : `service_id` et `service_categorie_id`.

### 2. Données Initiales (Fixtures)
Le catalogue complet peut être chargé via `ServiceFixtures`.

---

## 🖥️ Couche UI (Administration)

L'interface d'administration permet de gérer le catalogue via un CRUD complet.

*   **Gestion des Catégories** : `/admin/service-categorie`
*   **Gestion des Services** : `/admin/service`
*   **Formulaires** : `ServiceCategorieType`, `ServiceType`.

---

## 🔍 Commandes Utiles

### Charger le catalogue
```bash
php bin/console doctrine:fixtures:load --append
```

### Vérifier l'enregistrement UI
```bash
php bin/console app:debug:ui
```
