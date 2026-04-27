<?php

namespace Domain\Service\Repository;

use Domain\Service\Entity\ServiceChamp;
use Domain\Service\ValueObject\ServiceChampId;

interface ServiceChampRepositoryInterface
{
    public function save(ServiceChamp $champ): void;
    public function findById(ServiceChampId $id): ?ServiceChamp;
    /** @return ServiceChamp[] */
    public function findAll(): array;
}
