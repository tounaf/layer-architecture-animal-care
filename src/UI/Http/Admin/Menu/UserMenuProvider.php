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
                    new MenuItem('Droits', null, 'admin_right_index'),
                    new MenuItem('Utilisateurs', null, 'admin_user_index'),
                    new MenuItem('Profils', null, 'admin_profile_index'),
                    new MenuItem('Groupes', null, 'admin_group_index'),
                    
                ]
            ),
        ];
    }
}
