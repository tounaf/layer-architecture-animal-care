<?php

namespace Infrastructure\Persistence\Doctrine\Repository;

use Domain\Care\Entity\Care;
use Domain\Care\Repository\CareRepositoryInterface;

final class DoctrineCareRepository implements CareRepositoryInterface
{
    public function getById(string $id): ?Care
    {
        return null; // TODO: Implémenter avec Doctrine
    }

    public function save(Care $care): void
    {
        // TODO: Implémenter avec Doctrine
    }
}
