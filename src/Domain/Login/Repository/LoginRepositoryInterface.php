<?php

namespace Domain\Login\Repository;

use Domain\Login\Entity\Login;

interface LoginRepositoryInterface
{
    public function getById(string $id): ?Login;
    public function save(Login $login): void;
}
