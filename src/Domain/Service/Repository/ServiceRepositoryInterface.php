<?php

namespace Domain\Service\Repository;

use Domain\Service\Entity\Service;
use Domain\Service\ValueObject\ServiceId;

interface ServiceRepositoryInterface
{
    public function save(Service $service): void;
    public function findById(ServiceId $id): ?Service;
}
