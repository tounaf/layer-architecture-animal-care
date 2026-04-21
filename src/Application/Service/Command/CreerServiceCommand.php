<?php

namespace Application\Service\Command;

final class CreerServiceCommand
{
    public function __construct(
        public string $nom,
        public string $code,
        public string $categorieId,
        public int $dureeDefaultMinutes = 30,
        public bool $necessiteAcompteDefault = true,
        public ?string $description = null,
        public float $montantTarif = 0
    ) {
    }
}
