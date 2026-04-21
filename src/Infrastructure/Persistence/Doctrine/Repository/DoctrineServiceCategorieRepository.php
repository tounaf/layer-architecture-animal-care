<?php

namespace Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Domain\Service\Entity\ServiceCategorie;
use Domain\Service\Repository\ServiceCategorieRepositoryInterface;
use Domain\Service\ValueObject\ServiceCategorieId;

final class DoctrineServiceCategorieRepository implements ServiceCategorieRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function save(ServiceCategorie $categorie): void
    {
        $this->entityManager->persist($categorie);
        $this->entityManager->flush();
    }

    public function findById(ServiceCategorieId $id): ?ServiceCategorie
    {
        return $this->entityManager->find(ServiceCategorie::class, $id);
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(ServiceCategorie::class)->findBy([], ['ordreAffichage' => 'ASC']);
    }

    public function delete(ServiceCategorie $categorie): void
    {
        $this->entityManager->remove($categorie);
        $this->entityManager->flush();
    }
}
