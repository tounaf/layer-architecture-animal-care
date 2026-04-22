<?php

namespace UI\Http\Admin\Menu;

use UI\Http\Shared\Menu\MenuItem;
use UI\Http\Shared\Menu\MenuProviderInterface;

final class PrestataireMenuProvider implements MenuProviderInterface
{
    public function provide(): array
    {
        return [
            new MenuItem(
                label: 'Prestataires',
                icon: 'ti ti-building-hospital',
                routeName: 'admin_prestataire_index',
                children: [
                    new MenuItem('Liste', null, 'admin_prestataire_index'),
                    new MenuItem('Nouveau', null, 'admin_prestataire_new'),
                ]
            ),
        ];
    }
}
