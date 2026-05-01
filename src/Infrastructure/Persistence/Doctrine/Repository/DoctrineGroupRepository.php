<?php

namespace Infrastructure\Persistence\Doctrine\Repository;

use Domain\User\Entity\Group;
use Domain\User\Repository\GroupRepositoryInterface;
use Domain\User\ValueObject\GroupId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineGroupRepository extends ServiceEntityRepository implements GroupRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Group::class);
    }

    public function save(Group $group): void
    {
        $this->getEntityManager()->persist($group);
        $this->getEntityManager()->flush();
    }

    public function findById(GroupId $id): ?Group
    {
        return $this->find($id);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }
}
