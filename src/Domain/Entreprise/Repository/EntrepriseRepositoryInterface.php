<?php

namespace Domain\Entreprise\Repository;

use Domain\Entreprise\Entity\Entreprise;

interface EntrepriseRepositoryInterface
{
    public function getById(string $id): ?Entreprise;
    public function save(Entreprise $entreprise): void;
}
