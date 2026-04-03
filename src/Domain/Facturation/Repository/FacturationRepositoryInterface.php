<?php

namespace Domain\Facturation\Repository;

use Domain\Facturation\Entity\Facturation;

interface FacturationRepositoryInterface
{
    public function getById(string $id): ?Facturation;
    public function save(Facturation $facturation): void;
}
