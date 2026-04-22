<?php

namespace Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Domain\Animal\Entity\Animal;
use Domain\Animal\Repository\AnimalRepositoryInterface;
use Domain\Shared\ValueObject\AnimalId;
use Domain\Shared\ValueObject\ClientId;

final class DoctrineAnimalRepository implements AnimalRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function save(Animal $animal): void
    {
        $this->entityManager->persist($animal);
        $this->entityManager->flush();
    }

    public function findById(AnimalId $id): ?Animal
    {
        return $this->entityManager->find(Animal::class, $id);
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(Animal::class)->findAll();
    }

    public function findByProprietaire(ClientId $clientId): array
    {
        return $this->entityManager->getRepository(Animal::class)->findBy(['proprietaireId' => $clientId]);
    }

    public function delete(Animal $animal): void
    {
        $this->entityManager->remove($animal);
        $this->entityManager->flush();
    }
}
