<?php

namespace UI\Http\Admin\Menu;

use UI\Http\Shared\Menu\MenuItem;
use UI\Http\Shared\Menu\MenuProviderInterface;

final class UserMenuProvider implements MenuProviderInterface
{
    public function provide(): array
    {
        return [
            new MenuItem(
                label: 'Utilisateurs',
                icon: 'ti ti-users',
                routeName: 'admin_user_index',
                children: [
                    new MenuItem('Liste', null, 'admin_user_index'),
                    new MenuItem('Nouveau', null, 'admin_user_new'),
                ]
            ),
        ];
    }
}
