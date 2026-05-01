<?php

namespace Infrastructure\Persistence\Doctrine\Repository;

use Domain\User\Entity\Right;
use Domain\User\Repository\RightRepositoryInterface;
use Domain\User\ValueObject\RightId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineRightRepository extends ServiceEntityRepository implements RightRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Right::class);
    }

    public function save(Right $right): void
    {
        $this->getEntityManager()->persist($right);
        $this->getEntityManager()->flush();
    }

    public function findById(RightId $id): ?Right
    {
        return $this->find($id);
    }

    public function findByCode(string $code): ?Right
    {
        return $this->findOneBy(['rightCode' => $code]);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }
}
