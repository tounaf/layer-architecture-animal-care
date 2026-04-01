<?php

namespace Infrastructure\Persistence\Doctrine\Repository;

use Domain\User\Entity\User;
use Domain\User\Repository\UserRepositoryInterface;

final class DoctrineUserRepository implements UserRepositoryInterface
{
    public function getById(string $id): ?User
    {
        return null; // TODO: Implémenter avec Doctrine
    }

    public function save(User $user): void
    {
        // TODO: Implémenter avec Doctrine
    }
}
