<?php

namespace Domain\Care\Repository;

use Domain\Care\Entity\Care;

interface CareRepositoryInterface
{
    public function getById(string $id): ?Care;
    public function save(Care $care): void;
}
