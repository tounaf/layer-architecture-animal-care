<?php

namespace UI\Http\Admin\Menu;

use UI\Http\Shared\Menu\MenuItem;
use UI\Http\Shared\Menu\MenuProviderInterface;

final class DashboardMenuProvider implements MenuProviderInterface
{
    public function provide(): array
    {
        return [
            new MenuItem(
                label: 'Dashboard',
                icon: 'ti ti-dashboard',
                routeName: 'admin_dashboard',
                routePrefix: 'admin_dashboard',
                priority: 10
            ),
        ];
    }
}
