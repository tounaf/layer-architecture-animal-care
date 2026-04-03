<?php

namespace UI\Http\Shared\Topbar;

final readonly class TopbarItem
{
    public const SLOT_LEFT = 'left';
    public const SLOT_RIGHT = 'right';
    public const SLOT_USER_MENU = 'user_menu';

    /**
     * @param array<string, string> $attributes
     */
    public function __construct(
        public string $label,
        public ?string $icon = null,
        public ?string $routeName = null,
        public array $attributes = [],
        public ?string $template = null,
        public array $templateData = [],
        public string $slot = self::SLOT_RIGHT,
        public int $priority = 0
    ) {}

    public function hasTemplate(): bool
    {
        return $this->template !== null;
    }
}
