<?php

namespace UI\Http\Admin\Topbar;

use UI\Http\Shared\Topbar\TopbarItem;
use UI\Http\Shared\Topbar\TopbarProviderInterface;

final class NotificationTopbarProvider implements TopbarProviderInterface
{
    public function provide(): array
    {
        return [
            // 1. Un bouton "Favoris" tout à droite (Priorité haute = plus à droite)
            new TopbarItem(
                label: 'Favoris',
                icon: 'ti ti-heart',
                attributes: ['class' => 'topbar-link'],
                slot: TopbarItem::SLOT_RIGHT,
                priority: 100 
            ),

            // 2. Un bouton de Chat à côté des réglages (Priorité basse = plus à gauche)
            new TopbarItem(
                label: 'Chat',
                icon: 'ti ti-messages',
                attributes: [
                    'class' => 'topbar-link',
                    'id' => 'chat-button',
                    'data-bs-toggle' => 'tooltip',
                    'title' => 'Vous avez 3 messages'
                ],
                slot: TopbarItem::SLOT_RIGHT,
                priority: 15
            ),

            // 3. Un nouveau lien dans le menu déroulant du profil utilisateur
            new TopbarItem(
                label: 'Mes Factures',
                icon: 'ti ti-file-invoice',
                routeName: 'admin_dashboard', // TODO: Remplacer par la route réelle
                slot: TopbarItem::SLOT_USER_MENU,
                priority: 15 // Entre "Mon Compte" (10) et "Paramètres" (20)
            ),
        ];
    }
}
