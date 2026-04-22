<?php

namespace Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Domain\Prestataire\Entity\Prestataire;
use Domain\Prestataire\Repository\PrestataireRepositoryInterface;
use Domain\Shared\ValueObject\PrestataireId;

final class DoctrinePrestataireRepository implements PrestataireRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function save(Prestataire $prestataire): void
    {
        $this->entityManager->persist($prestataire);
        $this->entityManager->flush();
    }

    public function findById(PrestataireId $id): ?Prestataire
    {
        return $this->entityManager->find(Prestataire::class, $id);
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(Prestataire::class)->findAll();
    }

    public function delete(Prestataire $prestataire): void
    {
        $this->entityManager->remove($prestataire);
        $this->entityManager->flush();
    }
}
