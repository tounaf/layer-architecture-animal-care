<?php

namespace Domain\User\Entity;

use Domain\User\ValueObject\ActionId;

class Action
{
    private \DateTimeImmutable $createdAt;

    public function __construct(
        private ActionId $id,
        private string $actionName,
        private string $actionDescription
    ) {
        $this->createdAt = new \DateTimeImmutable();
    }

    public static function create(string $actionName, string $actionDescription): self
    {
        return new self(ActionId::generate(), $actionName, $actionDescription);
    }

    public function getId(): ActionId { return $this->id; }
    public function getActionName(): string { return $this->actionName; }
    public function getActionDescription(): string { return $this->actionDescription; }
    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
}
