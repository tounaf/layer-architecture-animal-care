<?php

namespace UI\Http\Shared\Topbar;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.topbar_provider')]
interface TopbarProviderInterface
{
    /**
     * @return TopbarItem[]
     */
    public function provide(): array;
}
