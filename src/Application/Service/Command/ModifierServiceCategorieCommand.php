<?php

namespace Application\Service\Command;

final class ModifierServiceCategorieCommand
{
    public function __construct(
        public readonly string $id,
        public readonly string $nom,
        public readonly ?string $description = null,
        public readonly ?string $icone = null,
        public readonly int $ordreAffichage = 0,
        public readonly bool $actif = true
    ) {
    }
}
