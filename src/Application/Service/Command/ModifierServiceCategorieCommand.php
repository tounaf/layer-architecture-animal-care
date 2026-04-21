<?php

namespace Application\Service\Command;

final class ModifierServiceCategorieCommand
{
    public function __construct(
        public string $id,
        public string $nom,
        public ?string $description = null,
        public ?string $icone = null,
        public int $ordreAffichage = 0,
        public bool $actif = true
    ) {
    }
}
