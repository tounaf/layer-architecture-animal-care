<?php

namespace Application\Service\Command;

final class CreerServiceCategorieCommand
{
    public function __construct(
        public string $nom,
        public ?string $description = null,
        public ?string $icone = null,
        public int $ordreAffichage = 0
    ) {
    }
}
