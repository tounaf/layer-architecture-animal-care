<?php

namespace Application\RendezVous\Command;

final readonly class ReporterRendezVousCommand
{
    public function __construct(
        public string $rendezVousId,
        public \DateTimeInterface $nouvelleDate,
        public string $nouvelleHeure
    ) {
    }
}
