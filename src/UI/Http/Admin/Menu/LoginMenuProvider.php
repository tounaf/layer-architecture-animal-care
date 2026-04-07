<?php

namespace UI\Http\Admin\Menu;

use UI\Http\Shared\Menu\MenuItem;
use UI\Http\Shared\Menu\MenuProviderInterface;

final class LoginMenuProvider implements MenuProviderInterface
{
    public function provide(): array
    {
        return [
            new MenuItem(
                label: 'Login',
                icon: 'ti ti-box',
                routeName: 'admin_login_index',
                children: [
                    new MenuItem('Liste', null, 'admin_login_index'),
                    // new MenuItem('Nouveau', null, 'admin_login_new'),
                ]
            ),
        ];
    }
}
