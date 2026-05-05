<?php

namespace Domain\RendezVous\Repository;

use Domain\RendezVous\Entity\RendezVous;
use Domain\RendezVous\ValueObject\RendezVousId;

interface RendezVousRepositoryInterface
{
    public function save(RendezVous $rendezVous): void;
    public function findById(RendezVousId $id): ?RendezVous;
    public function findAll(): array;
    public function countUpcoming(): int;
    /** @return RendezVous[] */
    public function findUpcoming(int $limit = 5): array;
}
