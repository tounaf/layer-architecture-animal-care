<?php

namespace Infrastructure\Persistence\Doctrine\Repository;

use Domain\Home\Entity\Home;
use Domain\Home\Repository\HomeRepositoryInterface;

final class DoctrineHomeRepository implements HomeRepositoryInterface
{
    public function getById(string $id): ?Home
    {
        return null; // TODO: Implémenter avec Doctrine
    }

    public function save(Home $home): void
    {
        // TODO: Implémenter avec Doctrine
    }
}
