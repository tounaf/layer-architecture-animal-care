<?php

namespace UI\Http\Admin\Menu;

use UI\Http\Shared\Menu\MenuItem;
use UI\Http\Shared\Menu\MenuProviderInterface;

final class ClientMenuProvider implements MenuProviderInterface
{
    public function provide(): array
    {
        return [
            new MenuItem(
                label: 'Client',
                icon: 'ti ti-box',
                routeName: 'admin_client_index',
                routePrefix: 'admin_client_',
                children: [
                    new MenuItem('Liste', null, 'admin_client_index'),
                    // new MenuItem('Nouveau', null, 'admin_client_new'),
                ]
            ),
        ];
    }
}
