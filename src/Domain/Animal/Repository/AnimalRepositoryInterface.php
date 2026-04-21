<?php

namespace Domain\Animal\Repository;

use Domain\Animal\Entity\Animal;
use Domain\Shared\ValueObject\AnimalId;

interface AnimalRepositoryInterface
{
    public function save(Animal $animal): void;
    public function findById(AnimalId $id): ?Animal;
}
