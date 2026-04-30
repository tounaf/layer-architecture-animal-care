# Système de Menu Dynamique (Sidebar)

Ce projet utilise un système de menu découplé où chaque domaine est responsable de l'affichage de ses propres liens dans la sidebar de l'administration.

## 🏗️ Architecture

Le système repose sur trois composants principaux situés dans `src/UI/Http/Shared/Menu/` :

1.  **`MenuItem`** : Un DTO représentant un lien du menu. Il supporte :
    *   `label` : Le nom affiché.
    *   `icon` : L'icône (Tabler Icons ou Solar Icons).
    *   `routeName` : Le nom de la route Symfony.
    *   `routePrefix` : (Optionnel) Un préfixe de route pour marquer l'item comme **actif** (ex: `admin_animal_`).
    *   `children` : Un tableau de `MenuItem` pour créer des sous-menus.
    *   `roles` : (Optionnel) Restriction d'affichage par rôle.

2.  **`MenuProviderInterface`** : L'interface que chaque domaine doit implémenter pour s'enregistrer dans le menu. Elle est automatiquement tagguée avec `app.menu_provider`.

3.  **`MenuRegistry`** : Le service central qui collecte tous les providers et fournit la liste finale des items à Twig.

---

## ✨ État Actif Automatique (Highlight)

Le système détecte automatiquement quel menu est "actif" (en surbrillance) en fonction de la page consultée.

### Comment ça marche ?
La classe `MenuItem` contient une méthode `isActive(string $currentRoute)` qui vérifie :
1. Si la route actuelle correspond exactement au `routeName`.
2. **OU** si la route actuelle commence par le `routePrefix`.
3. **OU** si l'un de ses sous-menus est actif (récursivité).

### Exemple de configuration :
```php
new MenuItem(
    label: 'Animaux',
    icon: 'ti ti-dog',
    routeName: 'admin_animal_index',
    routePrefix: 'admin_animal_' // Tous les CRUD (new, edit, show) activeront ce menu
)
```

Dans le template Twig, le menu parent se dépliera automatiquement (`show`) si un enfant est actif.

## 🛠️ Utilisation via le Générateur

Lors de la création d'une nouvelle feature, vous pouvez générer automatiquement son provider de menu :

```bash
php bin/console app:generate:feature Facturation --admin --menu
```

L'option `--menu` créera le fichier `src/UI/Http/Admin/Menu/FacturationMenuProvider.php`.

## ✍️ Ajout Manuel d'un Menu

Pour ajouter un lien manuellement, créez une classe implémentant `MenuProviderInterface` :

```php
namespace UI\Http\Admin\Menu;

use UI\Http\Shared\Menu\MenuItem;
use UI\Http\Shared\Menu\MenuProviderInterface;

final class MonDomaineMenuProvider implements MenuProviderInterface
{
    public function provide(): array
    {
        return [
            new MenuItem(
                label: 'Mon Domaine',
                icon: 'ti ti-package',
                routeName: 'admin_mondomaine_index',
                children: [
                    new MenuItem('Liste', null, 'admin_mondomaine_index'),
                    new MenuItem('Ajouter', null, 'admin_mondomaine_new'),
                ]
            ),
        ];
    }
}
```

## 🎨 Intégration Twig

Le menu est rendu dynamiquement dans `templates/admin/partials/_sidebar.html.twig` en utilisant la variable globale `menu_registry`.

```twig
{% for item in menu_registry.getItems() %}
    {# Rendu de l'item et de ses enfants #}
{% endfor %}
```

## 🔍 Débogage

Pour voir la liste complète des menus enregistrés et identifier quel provider a généré quel lien :
```bash
php bin/console app:debug:ui
```

## 🔐 Sécurité

Vous pouvez restreindre l'affichage d'un item de menu en passant des rôles au constructeur de `MenuItem` :

```php
new MenuItem('Config', 'ti ti-settings', 'admin_config', [], ['ROLE_SUPER_ADMIN'])
```
*(Note : La logique de vérification des rôles dans le template doit être ajoutée si nécessaire).*
