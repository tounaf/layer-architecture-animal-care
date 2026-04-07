# Système de Topbar Dynamique

Ce projet utilise un système de Topbar modulaire où chaque feature peut injecter des éléments (liens, boutons, dropdowns) dans différentes zones (Slots) avec une priorité d'affichage.

## 🏗️ Architecture

Le système repose sur trois composants dans `src/UI/Http/Shared/Topbar/` :

1.  **`TopbarItem`** : Définit un élément du Topbar.
    *   `slot` : `left`, `right`, ou `user_menu`.
    *   `priority` : L'ordre d'affichage (plus petit = plus à gauche).
    *   `attributes` : Attributs HTML (ex: pour les modaux Bootstrap).
    *   `template` : Pour les contenus complexes (ex: dropdown de notifications).

2.  **`TopbarProviderInterface`** : L'interface à implémenter pour ajouter des éléments.

3.  **`TopbarRegistry`** : Le service qui trie et fournit les éléments à Twig.

## 🛠️ Utilisation via le Générateur

Pour ajouter un TopbarProvider à une feature existante :

```bash
php bin/console app:generate:topbar Facturation
```

Cela créera `src/UI/Http/Admin/Topbar/FacturationTopbarProvider.php`.

## ✍️ Exemple de Configuration Manuelle

```php
new TopbarItem(
    label: 'Alerte',
    icon: 'ti ti-alert-circle',
    attributes: [
        'class' => 'topbar-link text-danger',
        'id' => 'alert-button'
    ],
    slot: TopbarItem::SLOT_RIGHT,
    priority: 5
)
```

## 🎨 Les Zones (Slots)

*   **`SLOT_LEFT`** : À côté du logo (généralement pour la recherche).
*   **`SLOT_RIGHT`** : Zone des icônes à droite (Langues, Notifications, Thème).
*   **`SLOT_USER_MENU`** : À l'intérieur du menu déroulant du profil utilisateur.

## 🔍 Débogage

Pour visualiser l'ordre d'affichage (priorités), les slots et les classes sources de chaque élément :
```bash
php bin/console app:debug:ui
```
