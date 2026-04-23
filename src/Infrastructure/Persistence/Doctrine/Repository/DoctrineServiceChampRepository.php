<?php

namespace Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Domain\Service\Entity\ServiceChamp;
use Domain\Service\Repository\ServiceChampRepositoryInterface;
use Domain\Service\ValueObject\ServiceChampId;

final class DoctrineServiceChampRepository implements ServiceChampRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function save(ServiceChamp $champ): void
    {
        $this->entityManager->persist($champ);
        $this->entityManager->flush();
    }

    public function findById(ServiceChampId $id): ?ServiceChamp
    {
        return $this->entityManager->find(ServiceChamp::class, $id);
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(ServiceChamp::class)->findAll();
    }
}
