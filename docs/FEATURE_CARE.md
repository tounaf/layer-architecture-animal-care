# Feature : Suivi Médical (CARE)

Cette feature gère le carnet de santé électronique des animaux, permettant un suivi historique de leur santé.

## 🏗️ Architecture du Domaine

### 1. Agrégat : `CarnetSante`
Le point central du suivi médical d'un animal.
*   **Propriétés** : Animal (ID), Date de création, Informations générales (bio), Métadonnées (groupe sanguin, allergies, puce), Date de mise à jour.
*   **Identifiant** : `CarnetSanteId` (Value Object).

### 2. Entité : `EntreeCarnet`
Une note ou un acte médical consigné dans le carnet.

---

## 🛠️ Couche Application

Le carnet de santé est automatiquement créé ou mis à jour lors de la validation d'une **Prestation**.

---

## 🔌 Couche Infrastructure

*   **Mapping** : XML dans `config/doctrine/care/`.
*   **Repositories** : `DoctrineCarnetSanteRepository`.
