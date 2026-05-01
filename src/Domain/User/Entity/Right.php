<?php

namespace Domain\User\Entity;

use Domain\Shared\Entity\AggregateRoot;
use Domain\User\ValueObject\RightId;

class Right extends AggregateRoot
{
    private \DateTimeImmutable $createdAt;
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct(
        private RightId $id,
        private string $rightName,
        private string $rightCode
    ) {
        $this->createdAt = new \DateTimeImmutable();
    }

    public static function create(string $rightName, string $rightCode): self
    {
        return new self(RightId::generate(), $rightName, $rightCode);
    }

    public function getId(): RightId { return $this->id; }
    public function getRightName(): string { return $this->rightName; }
    public function getRightCode(): string { return $this->rightCode; }
    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
    public function getUpdatedAt(): ?\DateTimeImmutable { return $this->updatedAt; }

    public function updateInformation(string $rightName, string $rightCode): void
    {
        $this->rightName = $rightName;
        $this->rightCode = $rightCode;
        $this->updatedAt = new \DateTimeImmutable();
    }
}
