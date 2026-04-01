<?php

namespace Domain\User\Repository;

use Domain\User\Entity\User;

interface UserRepositoryInterface
{
    public function getById(string $id): ?User;
    public function save(User $user): void;
}
