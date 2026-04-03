<?php

namespace UI\Http\Shared\Menu;

use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

final class MenuRegistry
{
    /** @var MenuProviderInterface[] */
    private iterable $providers;

    public function __construct(
        #[TaggedIterator('app.menu_provider')] iterable $providers
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

        return $items;
    }
}
