<?php

namespace Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Domain\Document\Entity\Document;
use Domain\Document\Repository\DocumentRepositoryInterface;
use Domain\Document\ValueObject\DocumentId;

final class DoctrineDocumentRepository implements DocumentRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function save(Document $document): void
    {
        $this->entityManager->persist($document);
        $this->entityManager->flush();
    }

    public function findById(DocumentId $id): ?Document
    {
        return $this->entityManager->find(Document::class, $id);
    }
}
