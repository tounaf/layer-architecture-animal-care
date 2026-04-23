<?php

namespace Domain\Document\Repository;

use Domain\Document\Entity\Document;
use Domain\Document\ValueObject\DocumentId;

interface DocumentRepositoryInterface
{
    public function save(Document $document): void;
    public function findById(DocumentId $id): ?Document;
}
