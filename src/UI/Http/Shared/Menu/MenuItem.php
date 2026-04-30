<?php

namespace UI\Http\Shared\Menu;

final readonly class MenuItem
{
    /**
     * @param MenuItem[] $children
     */
    public function __construct(
        public string $label,
        public ?string $icon = null,
        public ?string $routeName = null,
        public ?string $routePrefix = null,
        public array $children = [],
        public array $roles = []
    ) {}

    public function hasChildren(): bool
    {
        return !empty($this->children);
    }

    public function isActive(string $currentRoute): bool
    {
        if ($this->routeName === $currentRoute) {
            return true;
        }

        if ($this->routePrefix !== null && str_starts_with($currentRoute, $this->routePrefix)) {
            return true;
        }

        foreach ($this->children as $child) {
            if ($child->isActive($currentRoute)) {
                return true;
            }
        }

        return false;
    }
}
