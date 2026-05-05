<?php

namespace UI\Http\Admin\Menu;

use UI\Http\Shared\Menu\MenuItem;
use UI\Http\Shared\Menu\MenuProviderInterface;

final class FactureMenuProvider implements MenuProviderInterface
{
    public function provide(): array
    {
        return [
            new MenuItem(
                label: 'Factures',
                icon: 'ti ti-file-invoice',
                routeName: 'admin_facture_index',
                routePrefix: 'admin_facture_',
                priority: 30,
                children: [
                    new MenuItem(label: 'Liste', routeName: 'admin_facture_index', priority: 0),
                ]
            ),
        ];
    }
}
