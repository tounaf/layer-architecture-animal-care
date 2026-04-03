<?php

namespace UI\Http\Admin\Topbar;

use UI\Http\Shared\Topbar\TopbarItem;
use UI\Http\Shared\Topbar\TopbarProviderInterface;

final class AdminTopbarProvider implements TopbarProviderInterface
{
    public function provide(): array
    {
        return [
            // LEFT SLOT
            new TopbarItem(
                label: 'Search',
                icon: 'ti ti-search',
                attributes: [
                    'class' => 'topbar-search text-muted d-none d-xl-flex gap-2 align-items-center',
                    'data-bs-toggle' => 'modal',
                    'data-bs-target' => '#searchModal',
                    'type' => 'button'
                ],
                slot: TopbarItem::SLOT_LEFT,
                priority: 10
            ),

            // RIGHT SLOT
            new TopbarItem(
                label: 'Language',
                template: 'admin/partials/topbar/_language.html.twig',
                slot: TopbarItem::SLOT_RIGHT,
                priority: 10
            ),
            new TopbarItem(
                label: 'Notifications',
                template: 'admin/partials/topbar/_notifications.html.twig',
                slot: TopbarItem::SLOT_RIGHT,
                priority: 20
            ),
            new TopbarItem(
                label: 'Settings',
                icon: 'ti ti-settings',
                attributes: [
                    'class' => 'topbar-link',
                    'data-bs-toggle' => 'offcanvas',
                    'data-bs-target' => '#theme-settings-offcanvas',
                    'type' => 'button'
                ],
                slot: TopbarItem::SLOT_RIGHT,
                priority: 30
            ),
            new TopbarItem(
                label: 'Theme',
                icon: 'ti ti-moon',
                attributes: [
                    'class' => 'topbar-link',
                    'id' => 'light-dark-mode',
                    'type' => 'button'
                ],
                slot: TopbarItem::SLOT_RIGHT,
                priority: 40
            ),

            // USER MENU SLOT
            new TopbarItem(
                label: 'My Account',
                icon: 'ti ti-user-hexagon',
                routeName: 'public_home_index', // Just as example
                slot: TopbarItem::SLOT_USER_MENU,
                priority: 10
            ),
            new TopbarItem(
                label: 'Settings',
                icon: 'ti ti-settings',
                slot: TopbarItem::SLOT_USER_MENU,
                priority: 20
            ),
            new TopbarItem(
                label: 'Support',
                icon: 'ti ti-lifebuoy',
                slot: TopbarItem::SLOT_USER_MENU,
                priority: 30
            ),
        ];
    }
}
