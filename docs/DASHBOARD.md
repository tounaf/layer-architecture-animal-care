# Système de Dashboard Dynamique (AJAX)

Le dashboard de l'administration est conçu pour être performant, modulaire et découplé du rendu initial de la page. Il utilise une approche **AJAX-first** pour charger les données métier sans bloquer l'affichage de l'interface.

## 🏗️ Architecture

Le système repose sur une séparation claire entre la récupération des données (REST) et l'affichage (Twig/JS).

### 1. Couche Domaine (Repository)
Pour garantir la performance, les repositories définissent des méthodes de comptage et d'agrégation optimisées (DQL) :
*   `countAll()` : Retourne le nombre total d'entités.
*   `countUpcoming()` : Retourne le nombre de rendez-vous à venir.
*   `getSpeciesRepartition()` : Retourne un tableau associatif (clé: espèce, valeur: compte).

### 2. Couche Application (`DashboardStatsProvider`)
Ce service (`Application\Shared\Dashboard\DashboardStatsProvider`) orchestre la récupération des données à travers les différents domaines (User, Animal, RendezVous, Client).
Il transforme les entités ou les résultats bruts en structures de données (tableaux/DTO) prêtes à être consommées par l'UI.

### 3. Couche REST (`DashboardStatsController`)
Les données sont exposées via des endpoints dédiés sous le préfixe `/api/admin/dashboard/` :
*   `GET /api/admin/dashboard/kpis` : Chiffres clés.
*   `GET /api/admin/dashboard/upcoming-appointments` : Liste des 5 prochains rendez-vous.
*   `GET /api/admin/dashboard/species-repartition` : Statistiques par espèce.

---

## 🖥️ Interface Utilisateur (UI)

Le template `templates/admin/dashboard/index.html.twig` agit comme un squelette (Skeleton Screen).

### Fonctionnement du chargement :
1.  **Rendu initial** : La page s'affiche avec des indicateurs de chargement ("...").
2.  **Appels Asynchrones** : Au chargement du DOM, des fonctions `fetch()` interrogent les endpoints REST.
3.  **Mise à jour du DOM** : Chaque widget est mis à jour indépendamment dès que sa donnée est disponible.

---

## 🚀 Performances & Évolutivité

*   **Non-bloquant** : Si un domaine est lent ou subit une maintenance, seul le widget concerné affiche une erreur ou un chargement long, le reste du dashboard reste fonctionnel.
*   **Requêtes ciblées** : Utilisation de `SELECT COUNT` et de filtres DQL pour minimiser la charge sur la base de données.
*   **Extensibilité** : Pour ajouter un nouveau widget :
    1.  Ajouter une méthode dans le repository concerné.
    2.  Ajouter une méthode dans le `DashboardStatsProvider`.
    3.  Créer un endpoint dans le `DashboardStatsController`.
    4.  Ajouter le conteneur HTML et l'appel `fetch()` dans le template.

---

## 🔍 Débogage

Pour tester les données brutes sans passer par l'interface, vous pouvez appeler directement les API via votre navigateur ou un outil comme Postman :
`https://votre-projet.local/api/admin/dashboard/kpis`
