<?php

namespace Domain\Service\Repository;

use Domain\Service\Entity\ServiceCategorie;
use Domain\Service\ValueObject\ServiceCategorieId;

interface ServiceCategorieRepositoryInterface
{
    public function save(ServiceCategorie $categorie): void;
    public function findById(ServiceCategorieId $id): ?ServiceCategorie;
    /** @return ServiceCategorie[] */
    public function findAll(): array;
    public function delete(ServiceCategorie $categorie): void;
}
