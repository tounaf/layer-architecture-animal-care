<?php

namespace UI\Http\Admin\Menu;

use UI\Http\Shared\Menu\MenuItem;
use UI\Http\Shared\Menu\MenuProviderInterface;

final class MedicamentMenuProvider implements MenuProviderInterface
{
    public function provide(): array
    {
        return [
            new MenuItem(
                label: 'Médicaments',
                icon: 'ti ti-pill',
                routeName: 'admin_medicament_index',
                routePrefix: 'admin_medicament_',
                priority: 35,
                children: [
                    new MenuItem(label: 'Liste', routeName: 'admin_medicament_index', priority: 0),
                    new MenuItem(label: 'Nouveau', routeName: 'admin_medicament_new', priority: 10),
                ]
            ),
        ];
    }
}
