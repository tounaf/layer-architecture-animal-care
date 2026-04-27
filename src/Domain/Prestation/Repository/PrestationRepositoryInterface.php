<?php

namespace Domain\Prestation\Repository;

use Domain\Prestation\Entity\Prestation;
use Domain\Prestation\ValueObject\PrestationId;

interface PrestationRepositoryInterface
{
    public function save(Prestation $prestation): void;
    public function findById(PrestationId $id): ?Prestation;
    /** @return Prestation[] */
    public function findAll(): array;
}
