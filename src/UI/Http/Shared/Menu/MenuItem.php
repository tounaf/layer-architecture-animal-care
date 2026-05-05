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
        public array $roles = [],
        public int $priority = 0,
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

    /**
     * Crée une nouvelle instance avec les enfants triés par priorité
     */
    public function withSortedChildren(): self
    {
        if (!$this->hasChildren()) {
            return $this;
        }

        $sortedChildren = $this->children;
        usort($sortedChildren, function (MenuItem $a, MenuItem $b) {
            return $b->priority <=> $a->priority;
        });

        // Trier récursivement les enfants
        $sortedChildren = array_map(
            fn(MenuItem $child) => $child->withSortedChildren(),
            $sortedChildren
        );

        return new self(
            label: $this->label,
            icon: $this->icon,
            routeName: $this->routeName,
            routePrefix: $this->routePrefix,
            children: $sortedChildren,
            roles: $this->roles,
            priority: $this->priority,
        );
    }
}