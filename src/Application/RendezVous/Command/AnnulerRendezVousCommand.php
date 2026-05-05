<?php

namespace Application\RendezVous\Command;

final readonly class AnnulerRendezVousCommand
{
    public function __construct(
        public string $rendezVousId,
        public string $motif
    ) {
    }
}
