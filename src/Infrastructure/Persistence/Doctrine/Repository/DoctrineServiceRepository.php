<?php

namespace Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Domain\Service\Entity\Service;
use Domain\Service\Repository\ServiceRepositoryInterface;
use Domain\Service\ValueObject\ServiceId;

final class DoctrineServiceRepository implements ServiceRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function save(Service $service): void
    {
        $this->entityManager->persist($service);
        $this->entityManager->flush();
    }

    public function findById(ServiceId $id): ?Service
    {
        return $this->entityManager->find(Service::class, $id);
    }
}
