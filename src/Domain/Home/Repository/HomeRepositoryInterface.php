<?php

namespace Domain\Home\Repository;

use Domain\Home\Entity\Home;

interface HomeRepositoryInterface
{
    public function getById(string $id): ?Home;
    public function save(Home $home): void;
}
