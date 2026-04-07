<?php

namespace Infrastructure\Persistence\Doctrine\Repository;

use Domain\Login\Entity\Login;
use Domain\Login\Repository\LoginRepositoryInterface;

final class DoctrineLoginRepository implements LoginRepositoryInterface
{
    public function getById(string $id): ?Login
    {
        return null; // TODO: Implémenter avec Doctrine
    }

    public function save(Login $login): void
    {
        // TODO: Implémenter avec Doctrine
    }
}
