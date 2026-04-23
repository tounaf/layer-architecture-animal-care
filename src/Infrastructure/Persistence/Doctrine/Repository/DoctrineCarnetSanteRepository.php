<?php

namespace Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Domain\Care\Entity\CarnetSante;
use Domain\Care\Repository\CarnetSanteRepositoryInterface;
use Domain\Care\ValueObject\CarnetSanteId;
use Domain\Shared\ValueObject\AnimalId;

final class DoctrineCarnetSanteRepository implements CarnetSanteRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function save(CarnetSante $carnetSante): void
    {
        $this->entityManager->persist($carnetSante);
        $this->entityManager->flush();
    }

    public function findById(CarnetSanteId $id): ?CarnetSante
    {
        return $this->entityManager->find(CarnetSante::class, $id);
    }

    public function findByAnimal(AnimalId $animalId): ?CarnetSante
    {
        return $this->entityManager->getRepository(CarnetSante::class)->findOneBy(['animalId' => $animalId]);
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(CarnetSante::class)->findAll();
    }
}
