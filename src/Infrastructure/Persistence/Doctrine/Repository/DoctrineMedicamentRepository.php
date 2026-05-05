<?php

namespace Infrastructure\Persistence\Doctrine\Repository;

use Domain\Medicament\Entity\Medicament;
use Domain\Medicament\Repository\MedicamentRepositoryInterface;
use Domain\Medicament\ValueObject\MedicamentId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineMedicamentRepository extends ServiceEntityRepository implements MedicamentRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Medicament::class);
    }

    public function findById(MedicamentId $id): ?Medicament
    {
        return $this->find($id);
    }

    public function save(Medicament $medicament): void
    {
        $this->getEntityManager()->persist($medicament);
        $this->getEntityManager()->flush();
    }

    public function findAll(): array
    {
        return parent::findAll();
    }

    public function delete(Medicament $medicament): void
    {
        $this->getEntityManager()->remove($medicament);
        $this->getEntityManager()->flush();
    }
}
