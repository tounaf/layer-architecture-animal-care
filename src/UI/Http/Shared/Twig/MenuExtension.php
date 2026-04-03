<?php

namespace UI\Http\Shared\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use UI\Http\Shared\Menu\MenuRegistry;
use UI\Http\Shared\Topbar\TopbarRegistry;

final class MenuExtension extends AbstractExtension implements GlobalsInterface
{
    public function __construct(
        private MenuRegistry $menuRegistry,
        private TopbarRegistry $topbarRegistry
    ) {}

    public function getGlobals(): array
    {
        return [
            'menu_registry' => $this->menuRegistry,
            'topbar_registry' => $this->topbarRegistry,
        ];
    }
}
