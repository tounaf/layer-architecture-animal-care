<?php

namespace Domain\Prestataire\Repository;

use Domain\Prestataire\Entity\Prestataire;
use Domain\Shared\ValueObject\PrestataireId;

interface PrestataireRepositoryInterface
{
    public function save(Prestataire $prestataire): void;
    public function findById(PrestataireId $id): ?Prestataire;
    /** @return Prestataire[] */
    public function findAll(): array;
    public function delete(Prestataire $prestataire): void;
}
