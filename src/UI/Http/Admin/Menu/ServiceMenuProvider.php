<?php

namespace UI\Http\Admin\Menu;

use UI\Http\Shared\Menu\MenuItem;
use UI\Http\Shared\Menu\MenuProviderInterface;

final class ServiceMenuProvider implements MenuProviderInterface
{
    public function provide(): array
    {
        return [
            new MenuItem(
                label: 'Catalogue',
                icon: 'ti ti-box',
                routeName: 'admin_service_index',
                children: [
                    new MenuItem('Services', null, 'admin_service_index'),
                    new MenuItem('Catégories', null, 'admin_service_categorie_index'),
                ]
            ),
        ];
    }
}
