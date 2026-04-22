<?php

namespace Application\RendezVous\Command;

class CreerRendezVousCommand
{
    public function __construct(
        public readonly string $prestataireId,
        public readonly string $serviceProposeId,
        public readonly \DateTimeInterface $dateRdv,
        public readonly string $heureDebut,
        public readonly int $dureeMinutes,
        public readonly ?string $commentaires = null,
        // Client info for on-the-fly creation
        public readonly ?string $clientNom = null,
        public readonly ?string $clientPrenom = null,
        public readonly ?string $clientEmail = null,
        public readonly ?string $clientTelephone = null,
        // Animal info
        public readonly ?string $animalNom = null,
        public readonly ?string $animalEspece = null,
        // Existing IDs if provided
        public readonly ?string $clientId = null,
        public readonly ?string $animalId = null
    ) {
    }
}
