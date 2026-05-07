<?php

namespace Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Domain\Client\Entity\Client;
use Domain\Client\Repository\ClientRepositoryInterface;
use Domain\Shared\ValueObject\ClientId;

final class DoctrineClientRepository implements ClientRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function save(Client $client): void
    {
        $this->entityManager->persist($client);
        $this->entityManager->flush();
    }

    public function findById(ClientId $id): ?Client
    {
        return $this->entityManager->find(Client::class, $id);
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(Client::class)->findAll();
    }

    public function findByEmail(string $email): ?Client
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function delete(Client $client): void
    {
        $this->entityManager->remove($client);
        $this->entityManager->flush();
    }
}
