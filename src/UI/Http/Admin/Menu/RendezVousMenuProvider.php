<?php

namespace UI\Http\Admin\Menu;

use UI\Http\Shared\Menu\MenuItem;
use UI\Http\Shared\Menu\MenuProviderInterface;

final class RendezVousMenuProvider implements MenuProviderInterface
{
    public function provide(): array
    {
        return [
            new MenuItem(
                label: 'Rendez-vous',
                icon: 'ti ti-calendar-event',
                routeName: 'admin_rendezvous_index',
                children: [
                    new MenuItem('Liste', null, 'admin_rendezvous_index'),
                ]
            ),
        ];
    }
}
