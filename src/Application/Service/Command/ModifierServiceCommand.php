<?php

namespace Application\Service\Command;

final class ModifierServiceCommand
{
    public function __construct(
        public string $id,
        public string $nom,
        public string $code,
        public string $categorieId,
        public int $dureeDefaultMinutes = 30,
        public bool $necessiteAcompteDefault = true,
        public ?string $description = null,
        public bool $actif = true
    ) {
    }
}
