<?php

namespace UI\Http\Admin\Menu;

use UI\Http\Shared\Menu\MenuItem;
use UI\Http\Shared\Menu\MenuProviderInterface;

final class FacturationMenuProvider implements MenuProviderInterface
{
    public function provide(): array
    {
        return [
            new MenuItem(
                label: 'Facturation',
                icon: 'ti ti-box',
                routeName: 'admin_facturation_index',
                children: [
                    new MenuItem('Liste', null, 'admin_facturation_index'),
                    // new MenuItem('Nouveau', null, 'admin_facturation_new'),
                ]
            ),
        ];
    }
}
