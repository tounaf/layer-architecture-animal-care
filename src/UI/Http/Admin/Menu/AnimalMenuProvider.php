<?php

namespace UI\Http\Admin\Menu;

use UI\Http\Shared\Menu\MenuItem;
use UI\Http\Shared\Menu\MenuProviderInterface;

final class AnimalMenuProvider implements MenuProviderInterface
{
    public function provide(): array
    {
        return [
            new MenuItem(
                label: 'Animal',
                icon: 'ti ti-box',
                routeName: 'admin_animal_index',
                routePrefix: 'admin_animal_',
                children: [
                    new MenuItem('Liste', null, 'admin_animal_index'),
                    // new MenuItem('Nouveau', null, 'admin_animal_new'),
                ]
            ),
        ];
    }
}
