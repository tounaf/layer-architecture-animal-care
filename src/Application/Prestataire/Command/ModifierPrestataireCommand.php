<?php

namespace Application\Prestataire\Command;

final class ModifierPrestataireCommand
{
    public function __construct(
        public readonly string $id,
        public readonly string $nomStructure,
        public readonly string $nomContact,
        public readonly string $prenomContact,
        public readonly string $profession,
        public readonly bool $valideParAdmin
    ) {
    }
}
