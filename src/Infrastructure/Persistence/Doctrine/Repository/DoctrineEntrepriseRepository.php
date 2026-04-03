<?php

namespace Infrastructure\Persistence\Doctrine\Repository;

use Domain\Entreprise\Entity\Entreprise;
use Domain\Entreprise\Repository\EntrepriseRepositoryInterface;

final class DoctrineEntrepriseRepository implements EntrepriseRepositoryInterface
{
    public function getById(string $id): ?Entreprise
    {
        return null; // TODO: Implémenter avec Doctrine
    }

    public function save(Entreprise $entreprise): void
    {
        // TODO: Implémenter avec Doctrine
    }
}
