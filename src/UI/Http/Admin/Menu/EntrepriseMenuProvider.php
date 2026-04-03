<?php

namespace UI\Http\Admin\Menu;

use UI\Http\Shared\Menu\MenuItem;
use UI\Http\Shared\Menu\MenuProviderInterface;

final class EntrepriseMenuProvider implements MenuProviderInterface
{
    public function provide(): array
    {
        return [
            new MenuItem(
                label: 'Entreprise',
                icon: 'ti ti-box',
                routeName: 'admin_entreprise_index',
                children: [
                    new MenuItem('Liste', null, 'admin_entreprise_index'),
                    // new MenuItem('Nouveau', null, 'admin_entreprise_new'),
                ]
            ),
        ];
    }
}
