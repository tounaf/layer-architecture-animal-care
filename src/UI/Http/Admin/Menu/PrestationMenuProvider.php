<?php

namespace UI\Http\Admin\Menu;

use UI\Http\Shared\Menu\MenuItem;
use UI\Http\Shared\Menu\MenuProviderInterface;

final class PrestationMenuProvider implements MenuProviderInterface
{
    public function provide(): array
    {
        return [
            new MenuItem(
                label: 'Prestations',
                icon: 'ti ti-building-hospital',
                routeName: 'admin_prestation_index',
                children: [
                    new MenuItem('Liste', null, 'admin_prestation_index'),
                ]
            ),
        ];
    }
}
