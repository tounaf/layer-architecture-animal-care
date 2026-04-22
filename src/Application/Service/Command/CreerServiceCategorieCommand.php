<?php

namespace Application\Service\Command;

final class CreerServiceCategorieCommand
{
    public function __construct(
        public readonly string $nom,
        public readonly ?string $description = null,
        public readonly ?string $icone = null,
        public readonly int $ordreAffichage = 0
    ) {
    }
}
