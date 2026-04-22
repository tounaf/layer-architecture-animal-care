<?php

namespace Domain\Animal\Repository;

use Domain\Animal\Entity\Animal;
use Domain\Shared\ValueObject\AnimalId;
use Domain\Shared\ValueObject\ClientId;

interface AnimalRepositoryInterface
{
    public function save(Animal $animal): void;
    public function findById(AnimalId $id): ?Animal;
    /** @return Animal[] */
    public function findAll(): array;
    /** @return Animal[] */
    public function findByProprietaire(ClientId $clientId): array;
    public function delete(Animal $animal): void;
}
