<?php

namespace Application\Prestataire\Command;

final class CreerPrestataireCommand
{
    public function __construct(
        public readonly string $nomStructure,
        public readonly string $nomContact,
        public readonly string $prenomContact,
        public readonly string $profession,
        public readonly string $email,
        public readonly bool $valideParAdmin = false
    ) {
    }
}
