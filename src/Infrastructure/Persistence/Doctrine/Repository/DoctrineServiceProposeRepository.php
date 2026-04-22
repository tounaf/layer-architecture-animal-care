<?php

namespace Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Domain\Prestataire\Entity\ServicePropose;
use Domain\Prestataire\Repository\ServiceProposeRepositoryInterface;
use Domain\Prestataire\ValueObject\ServiceProposeId;
use Domain\Shared\ValueObject\PrestataireId;

final class DoctrineServiceProposeRepository implements ServiceProposeRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function save(ServicePropose $servicePropose): void
    {
        $this->entityManager->persist($servicePropose);
        $this->entityManager->flush();
    }

    public function findById(ServiceProposeId $id): ?ServicePropose
    {
        return $this->entityManager->find(ServicePropose::class, $id);
    }

    public function findByPrestataire(PrestataireId $prestataireId): array
    {
        return $this->entityManager->getRepository(ServicePropose::class)->findBy(['prestataireId' => $prestataireId]);
    }

    public function delete(ServicePropose $servicePropose): void
    {
        $this->entityManager->remove($servicePropose);
        $this->entityManager->flush();
    }
}
