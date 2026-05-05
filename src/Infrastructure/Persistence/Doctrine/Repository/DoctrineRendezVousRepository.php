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

    public function countUpcoming(): int
    {
        return (int) $this->entityManager
            ->createQuery('SELECT COUNT(r.id) FROM Domain\RendezVous\Entity\RendezVous r WHERE r.dateRdv >= :today')
            ->setParameter('today', new \DateTimeImmutable('today'))
            ->getSingleScalarResult();
    }

    public function findUpcoming(int $limit = 5): array
    {
        return $this->entityManager
            ->createQuery('SELECT r FROM Domain\RendezVous\Entity\RendezVous r WHERE r.dateRdv >= :today ORDER BY r.dateRdv ASC, r.plageHoraire.debut ASC')
            ->setParameter('today', new \DateTimeImmutable('today'))
            ->setMaxResults($limit)
            ->getResult();
    }
}
