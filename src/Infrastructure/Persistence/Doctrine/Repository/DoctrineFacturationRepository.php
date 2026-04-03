<?php

namespace Infrastructure\Persistence\Doctrine\Repository;

use Domain\Facturation\Entity\Facturation;
use Domain\Facturation\Repository\FacturationRepositoryInterface;

final class DoctrineFacturationRepository implements FacturationRepositoryInterface
{
    public function getById(string $id): ?Facturation
    {
        return null; // TODO: Implémenter avec Doctrine
    }

    public function save(Facturation $facturation): void
    {
        // TODO: Implémenter avec Doctrine
    }
}
