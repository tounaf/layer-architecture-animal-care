<?php

namespace Domain\RendezVous\Repository;

use Domain\RendezVous\Entity\RendezVous;
use Domain\RendezVous\ValueObject\RendezVousId;

interface RendezVousRepositoryInterface
{
    public function save(RendezVous $rendezVous): void;
    public function findById(RendezVousId $id): ?RendezVous;
}
