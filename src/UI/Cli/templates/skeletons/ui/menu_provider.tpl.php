<?php

namespace UI\Http\{{ context }}\Menu;

use UI\Http\Shared\Menu\MenuItem;
use UI\Http\Shared\Menu\MenuProviderInterface;

final class {{ name }}MenuProvider implements MenuProviderInterface
{
    public function provide(): array
    {
        return [
            new MenuItem(
                label: '{{ name }}',
                icon: 'ti ti-box',
                routeName: '{{ context_lower }}_{{ name_lower }}_index',
                children: [
                    new MenuItem('Liste', null, '{{ context_lower }}_{{ name_lower }}_index'),
                    // new MenuItem('Nouveau', null, '{{ context_lower }}_{{ name_lower }}_new'),
                ]
            ),
        ];
    }
}
