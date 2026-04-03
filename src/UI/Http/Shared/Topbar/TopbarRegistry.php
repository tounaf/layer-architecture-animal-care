<?php

namespace UI\Http\Shared\Topbar;

use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

final class TopbarRegistry
{
    /** @var TopbarProviderInterface[] */
    private iterable $providers;

    public function __construct(
        #[TaggedIterator('app.topbar_provider')] iterable $providers
    ) {
        $this->providers = $providers;
    }

    /**
     * @return TopbarItem[]
     */
    public function getItemsBySlot(string $slot): array
    {
        $items = [];
        foreach ($this->providers as $provider) {
            foreach ($provider->provide() as $item) {
                if ($item->slot === $slot) {
                    $items[] = $item;
                }
            }
        }

        usort($items, fn(TopbarItem $a, TopbarItem $b) => $a->priority <=> $b->priority);

        return $items;
    }
}
