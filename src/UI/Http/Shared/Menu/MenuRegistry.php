<?php

namespace UI\Http\Shared\Menu;

use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

final class MenuRegistry
{
    /** @var MenuProviderInterface[] */
    private iterable $providers;

    public function __construct(
        #[AutowireIterator('app.menu_provider')] iterable $providers
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

        usort($items, function (MenuItem $a, MenuItem $b) {
            return $b->priority <=> $a->priority;
        });

        $items = array_map(
            fn(MenuItem $item) => $item->withSortedChildren(),
            $items
        );

        return $items;
    }
}