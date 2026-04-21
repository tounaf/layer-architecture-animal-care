<?php

namespace UI\Http\Admin\Menu;

use UI\Http\Shared\Menu\MenuItem;
use UI\Http\Shared\Menu\MenuProviderInterface;

final class CareMenuProvider implements MenuProviderInterface
{
    public function provide(): array
    {
        return [
            new MenuItem(
                label: 'Carnet de Santé',
                icon: 'ti ti-heart-rate-monitor',
                routeName: 'admin_care_index',
                children: [
                    new MenuItem('Liste', null, 'admin_care_index'),
                    // new MenuItem('Nouveau', null, 'admin_care_new'),
                ]
            ),
        ];
    }
}
