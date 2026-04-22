<?php

namespace Application\Animal\Command;

final class CreerAnimalCommand
{
    public function __construct(
        public readonly string $nom,
        public readonly string $proprietaireId,
        public readonly ?string $espece = null,
        public readonly ?string $race = null,
        public readonly ?\DateTimeInterface $dateNaissance = null,
        public readonly ?float $poids = null
    ) {
    }
}
