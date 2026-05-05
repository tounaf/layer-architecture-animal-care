<?php

namespace Infrastructure\Persistence\Doctrine\Repository;

use Domain\User\Entity\Profile;
use Domain\User\Repository\ProfileRepositoryInterface;
use Domain\User\ValueObject\ProfileId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineProfileRepository extends ServiceEntityRepository implements ProfileRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Profile::class);
    }

    public function save(Profile $profile): void
    {
        $this->getEntityManager()->persist($profile);
        $this->getEntityManager()->flush();
    }

    public function findById(ProfileId $id): ?Profile
    {
        return $this->find($id);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }
}
