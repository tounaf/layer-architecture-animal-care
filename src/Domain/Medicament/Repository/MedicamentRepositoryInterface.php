<?php

namespace Domain\Medicament\Repository;

use Domain\Medicament\Entity\Medicament;
use Domain\Medicament\ValueObject\MedicamentId;

interface MedicamentRepositoryInterface
{
    public function save(Medicament $medicament): void;
    public function findById(MedicamentId $id): ?Medicament;
    public function findAll(): array;
    public function delete(Medicament $medicament): void;
}
