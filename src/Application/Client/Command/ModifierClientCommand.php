<?php

namespace Application\Client\Command;

final class ModifierClientCommand
{
    public function __construct(
        public readonly string $id,
        public readonly string $nom,
        public readonly string $prenom,
        public readonly string $email,
        public readonly ?string $telephone = null,
        public readonly ?string $ville = null
    ) {
    }
}
