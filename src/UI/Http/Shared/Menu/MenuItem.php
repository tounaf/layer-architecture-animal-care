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
        public array $children = [],
        public array $roles = []
    ) {}

    public function hasChildren(): bool
    {
        return !empty($this->children);
    }
}
