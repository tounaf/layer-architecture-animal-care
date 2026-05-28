<?php

namespace Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Domain\Prestation\Entity\Prestation;
use Domain\Prestation\Repository\PrestationRepositoryInterface;
use Domain\Prestation\ValueObject\PrestationId;

final class DoctrinePrestationRepository implements PrestationRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function save(Prestation $prestation): void
    {
        $this->entityManager->persist($prestation);
        $this->entityManager->flush();
    }

    public function findById(PrestationId $id): ?Prestation
    {
        return $this->entityManager->find(Prestation::class, $id);
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(Prestation::class)->findAll();
    }

    public function searchByClientOrService(string $searchTerm): array
    {
        $repository = $this->entityManager->getRepository(Prestation::class);
        // Retourner tous les prestations pour maintenant, sera enrichie au controller
        // La vraie recherche se fait au niveau du contrôleur après enrichissement avec les données client/service
        return $repository->findAll();
    }
}
