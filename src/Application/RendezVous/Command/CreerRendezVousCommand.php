<?php

namespace Application\RendezVous\Command;

class CreerRendezVousCommand
{
    public function __construct(
        public readonly string $clientId,
        public readonly string $animalId,
        public readonly string $prestataireId,
        public readonly \DateTimeInterface $dateRdv,
        public readonly string $heureDebut,
        public readonly int $dureeMinutes,
        public readonly ?string $commentaires = null
    ) {
    }
}
