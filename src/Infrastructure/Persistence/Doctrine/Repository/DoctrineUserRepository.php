<?php

namespace Infrastructure\Persistence\Doctrine\Repository;

use Domain\User\Entity\User;
use Domain\User\Repository\UserRepositoryInterface;
use Domain\User\ValueObject\UserId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineUserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $user): void
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function findById(UserId $id): ?User
    {
        return $this->find($id);
    }

    public function findByLogin(string $login): ?User
    {
        return $this->findOneBy(['login' => $login]);
    }

    public function findByMail(string $mail): ?User
    {
        return $this->findOneBy(['mail' => $mail]);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }

    public function delete(User $user): void
    {
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
    }
}
