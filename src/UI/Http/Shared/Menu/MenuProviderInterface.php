<?php

namespace UI\Http\Shared\Menu;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.menu_provider')]
interface MenuProviderInterface
{
    /**
     * @return MenuItem[]
     */
    public function provide(): array;
}
