<?php

namespace Application\Service\Command;

final class CreerServiceCommand
{
    public function __construct(
        public readonly string $nom,
        public readonly string $code,
        public readonly string $categorieId,
        public readonly int $dureeDefaultMinutes = 30,
        public readonly bool $necessiteAcompteDefault = true,
        public readonly ?string $description = null,
        public readonly float $montantTarif = 0
    ) {
    }
}
