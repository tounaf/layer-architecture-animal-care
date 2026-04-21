# Feature : Catalogue des Services & Tarification

Cette feature gère les services proposés par la plateforme et leur historique de prix.

## 🏗️ Architecture du Domaine

### 1. Entité : `Service`
Représente un acte ou une prestation (ex: Consultation, Toilettage).
*   **Propriétés** : Nom, Description, État (actif/inactif).
*   **Identifiant** : `ServiceId` (Value Object).

### 2. Objet Embarqué : `Tarif` (Value Object)
Le tarif est encapsulé dans le service.
*   **Propriétés** : Montant, Devise, Date d'application.

### 3. Contrat de Persistance
*   `ServiceRepositoryInterface` définit les méthodes `save` et `findById`.

---

## 🔌 Couche Infrastructure

*   **Repository** : `DoctrineServiceRepository`.
*   **Mapping** : XML dans `config/doctrine/Domain.Service.Entity.Service.orm.xml` et `Domain.Service.Entity.Tarif.orm.xml` (Embeddable).
*   **Types DBAL** : `service_id`.

---

## 🖥️ Couche UI

*   **Controller** : `ServiceAdminController` (`/admin/service`).
*   **Menu** : `ServiceMenuProvider`.
*   **Template** : `templates/admin/service/index.html.twig`.
