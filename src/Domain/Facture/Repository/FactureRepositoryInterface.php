<?php

namespace Domain\Facture\Repository;

use Domain\Facture\Entity\Facture;
use Domain\Facture\ValueObject\FactureId;

interface FactureRepositoryInterface
{
    public function save(Facture $facture): void;
    public function findById(FactureId $id): ?Facture;
    public function findAll(): array;
}
