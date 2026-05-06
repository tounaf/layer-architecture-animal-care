<?php

namespace UI\Http\Shared\Menu;

use Domain\User\Repository\RightRepositoryInterface;
use Domain\User\Repository\UserRepositoryInterface;
use Domain\User\ValueObject\UserId;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

final class MenuRegistry
{
    /** @var MenuProviderInterface[] */
    private iterable $providers;

    public function __construct(
        #[AutowireIterator('app.menu_provider')] iterable $providers,
        private readonly Security $security,
        private readonly RightRepositoryInterface $rightRepository,
        private readonly UserRepositoryInterface $userRepository,
        private readonly CacheInterface $appCache
    ) {
        $this->providers = $providers;
    }

    /**
     * @return MenuItem[]
     */
    public function getItems(): array
    {
        $items = [];
        foreach ($this->providers as $provider) {
            $items = array_merge($items, $provider->provide());
        }

        // Ne pas filtrer si on est en CLI (pour le debug:ui) ou si pas de user
        if (PHP_SAPI !== 'cli' && $this->security->getUser()) {
            $items = $this->filterItemsByRights($items);
        }

        usort($items, function (MenuItem $a, MenuItem $b) {
            return $b->priority <=> $a->priority;
        });

        $items = array_map(
            fn(MenuItem $item) => $item->withSortedChildren(),
            $items
        );

        return $items;
    }

    private function filterItemsByRights(array $items): array
    {
        $user = $this->security->getUser();
        if (!$user) {
            return [];
        }

        $userId = $user->getUserIdentifier();
        $userRights = $this->appCache->get("user_all_rights_{$userId}", function (ItemInterface $item) use ($userId) {
            $item->expiresAfter(3600);
            $domainUser = $this->userRepository->findById(UserId::fromString($userId));
            if (!$domainUser) {
                return [];
            }
            return $this->getAllUserRightCodes($domainUser);
        });

        $filteredItems = [];
        foreach ($items as $item) {
            if ($this->hasAccessToItem($item, $userRights)) {
                $filteredItem = clone $item;
                if (!empty($item->children)) {
                    $filteredItem->children = $this->filterItemsByRights($item->children);
                }
                $filteredItems[] = $filteredItem;
            }
        }

        return $filteredItems;
    }

    private function hasAccessToItem(MenuItem $item, array $userRights): bool
    {
        if (!$item->routeName) {
            return true; // Si pas de route, on affiche (ex: parents de sous-menu)
        }

        // Si la route n'est pas protégée par un Right, on l'affiche
        $right = $this->rightRepository->findByCode($item->routeName);
        if (!$right) {
            return true;
        }

        return in_array($item->routeName, $userRights, true);
    }

    private function getAllUserRightCodes($user): array
    {
        $codes = [];
        foreach ($user->getRights() as $right) {
            $codes[] = $right->getRightCode();
        }
        foreach ($user->getProfiles() as $profile) {
            foreach ($profile->getRights() as $right) {
                $codes[] = $right->getRightCode();
            }
        }
        foreach ($user->getGroups() as $group) {
            foreach ($group->getRights() as $right) {
                $codes[] = $right->getRightCode();
            }
            foreach ($group->getProfiles() as $profile) {
                foreach ($profile->getRights() as $right) {
                    $codes[] = $right->getRightCode();
                }
            }
        }
        return array_unique($codes);
    }
}