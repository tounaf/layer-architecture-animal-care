<?php

namespace Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Domain\RendezVous\Entity\RendezVous;
use Domain\RendezVous\Repository\RendezVousRepositoryInterface;
use Domain\RendezVous\ValueObject\RendezVousId;

final class DoctrineRendezVousRepository implements RendezVousRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function save(RendezVous $rendezVous): void
    {
        $this->entityManager->persist($rendezVous);
        $this->entityManager->flush();
    }

    public function findById(RendezVousId $id): ?RendezVous
    {
        return $this->entityManager->find(RendezVous::class, $id);
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(RendezVous::class)->findAll();
    }
}
