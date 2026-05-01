<?php

namespace Domain\User\Entity;

use Domain\User\ValueObject\HistoryId;
use Domain\User\ValueObject\UserId;
use Domain\User\ValueObject\ActionId;

class History
{
    public function __construct(
        private HistoryId $id,
        private string $ip,
        private string $tableName,
        private string $resourceId,
        private \DateTimeImmutable $actionDate,
        private UserId $userId,
        private ActionId $actionId
    ) {
    }

    public static function create(
        string $ip,
        string $tableName,
        string $resourceId,
        UserId $userId,
        ActionId $actionId
    ): self {
        return new self(
            HistoryId::generate(),
            $ip,
            $tableName,
            $resourceId,
            new \DateTimeImmutable(),
            $userId,
            $actionId
        );
    }

    public function getId(): HistoryId { return $this->id; }
    public function getIp(): string { return $this->ip; }
    public function getTableName(): string { return $this->tableName; }
    public function getResourceId(): string { return $this->resourceId; }
    public function getActionDate(): \DateTimeImmutable { return $this->actionDate; }
    public function getUserId(): UserId { return $this->userId; }
    public function getActionId(): ActionId { return $this->actionId; }
}
