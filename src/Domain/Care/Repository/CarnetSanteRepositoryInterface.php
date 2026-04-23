<?php

namespace Domain\Care\Repository;

use Domain\Care\Entity\CarnetSante;
use Domain\Care\ValueObject\CarnetSanteId;
use Domain\Shared\ValueObject\AnimalId;

interface CarnetSanteRepositoryInterface
{
    public function save(CarnetSante $carnetSante): void;
    public function findById(CarnetSanteId $id): ?CarnetSante;
    public function findByAnimal(AnimalId $animalId): ?CarnetSante;
    /** @return CarnetSante[] */
    public function findAll(): array;
}
