<?php

namespace Application\Animal\Command;

final class ModifierAnimalCommand
{
    public function __construct(
        public readonly string $id,
        public readonly string $nom,
        public readonly string $proprietaireId,
        public readonly ?string $espece = null,
        public readonly ?string $race = null,
        public readonly ?\DateTimeInterface $dateNaissance = null,
        public readonly ?float $poids = null
    ) {
    }
}
