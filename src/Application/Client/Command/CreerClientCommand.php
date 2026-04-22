<?php

namespace Application\Client\Command;

final class CreerClientCommand
{
    public function __construct(
        public readonly string $nom,
        public readonly string $prenom,
        public readonly string $email,
        public readonly ?string $telephone = null,
        public readonly ?string $ville = null
    ) {
    }
}
