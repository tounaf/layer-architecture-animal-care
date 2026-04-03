# Système de Menu Dynamique (Sidebar)

Ce projet utilise un système de menu découplé où chaque domaine est responsable de l'affichage de ses propres liens dans la sidebar de l'administration.

## 🏗️ Architecture

Le système repose sur trois composants principaux situés dans `src/UI/Http/Shared/Menu/` :

1.  **`MenuItem`** : Un DTO représentant un lien du menu. Il supporte :
    *   `label` : Le nom affiché.
    *   `icon` : L'icône (Tabler Icons ou Solar Icons).
    *   `routeName` : Le nom de la route Symfony.
    *   `children` : Un tableau de `MenuItem` pour créer des sous-menus.
    *   `roles` : (Optionnel) Restriction d'affichage par rôle.

2.  **`MenuProviderInterface`** : L'interface que chaque domaine doit implémenter pour s'enregistrer dans le menu. Elle est automatiquement tagguée avec `app.menu_provider`.

3.  **`MenuRegistry`** : Le service central qui collecte tous les providers et fournit la liste finale des items à Twig.

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

## 🔐 Sécurité

Vous pouvez restreindre l'affichage d'un item de menu en passant des rôles au constructeur de `MenuItem` :

```php
new MenuItem('Config', 'ti ti-settings', 'admin_config', [], ['ROLE_SUPER_ADMIN'])
```
*(Note : La logique de vérification des rôles dans le template doit être ajoutée si nécessaire).*
