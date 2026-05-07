<?php

namespace Infrastructure\Persistence\Doctrine\Repository;

use Domain\Facture\Entity\Facture;
use Domain\Facture\Repository\FactureRepositoryInterface;
use Domain\Facture\ValueObject\FactureId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineFactureRepository extends ServiceEntityRepository implements FactureRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Facture::class);
    }

    public function findById(FactureId $id): ?Facture
    {
        return $this->find($id);
    }

    public function save(Facture $facture): void
    {
        $this->getEntityManager()->persist($facture);
        $this->getEntityManager()->flush();
    }

    public function findAll(): array
    {
        return parent::findAll();
    }
}
