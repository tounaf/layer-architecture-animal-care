# Feature : Gestion des Médicaments

Cette feature permet de gérer le catalogue des médicaments et de suivre les prescriptions lors des prestations.

## 🏗️ Architecture

### 1. Domaine (`src/Domain/Medicament`)
- **Entité** : `Medicament` (Aggregate Root).
- **Entité liée** : `MouvementStock`.
- **Value Object** : `MedicamentId`.
- **Logique** : Gère son stock via les méthodes `ajusterStock()`, `prescrire()` et `approvisionner()`. Un médicament a un nom, une description, un prix unitaire et un stock actuel. Chaque changement de stock génère un `MouvementStock` pour l'historique.

### 2. Application (`src/Application/Medicament`)
- CRUD standard via Command/Handler.

### 3. Infrastructure
- Persistence via Doctrine (Mapping XML dans `config/doctrine/medicament/`).
- Type DBAL personnalisé `medicament_id`.

## 🔄 Intégration Prestation
Lorsqu'un vétérinaire réalise une prestation (`RealiserPrestationHandler`), il peut spécifier une liste de médicaments prescrits avec leurs quantités.
- Le handler diminue automatiquement le stock de chaque médicament prescrit.
- Les médicaments sont affichés dans le formulaire de validation de prestation avec leur stock actuel.

---

# Feature : Gestion de la Facturation

La facturation est déclenchée automatiquement suite à la réalisation d'une prestation, en utilisant des événements de domaine pour maintenir un couplage faible.

## 🏗️ Architecture

### 1. Domaine (`src/Facture`)
- **Entité** : `Facture`.
- **Value Object** : `FactureId`.
- **Enum** : `StatutFacture` (en_attente, payee, annulee).

### 2. Flux d'Événements
1. La `Prestation` enregistre un événement `PrestationRealisee` lors de sa création.
2. Le `RealiserPrestationHandler` dispatch cet événement via l' `EventBus`.
3. Le `GenererFactureSurPrestationRealiseeHandler` (Subscriber) intercepte l'événement.
4. Une nouvelle `Facture` est créée avec un numéro unique et les montants (HT, TVA, TTC) calculés.

## 🖥️ UI
Une liste des factures est disponible dans l'administration pour suivre les paiements.

---

# Amélioration : Gestion des Droits & Sécurité

La gestion des droits a été améliorée pour être plus robuste et liée directement aux fonctionnalités de l'application.

- **Extraction de Routes** : Un service `RouteExtractor` permet de récupérer toutes les routes déclarées dans Symfony.
- **Affectation** : Lors de la création d'un "Droit", l'administrateur choisit désormais une route Symfony parmi la liste. Cela garantit que les droits correspondent à des points d'accès réels.
- **Contrôle d'Accès Dynamique** : Un `AccessControlSubscriber` intercepte chaque requête vers un contrôleur. Si la route est associée à un `Right`, il vérifie que l'utilisateur possède ce droit (directement ou via ses profils/groupes).
- **Menu Filtré** : Le `MenuRegistry` filtre automatiquement les éléments de menu en fonction des droits de l'utilisateur. Un lien vers une route protégée ne s'affichera que si l'utilisateur a l'autorisation.
- **Performance** : Les calculs de droits sont mis en cache (Symfony Cache) par utilisateur pour garantir une performance optimale.
