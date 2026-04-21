<?php

namespace Domain\Service\Event;

use Domain\Shared\Event\DomainEvent;

readonly class ServiceCree implements DomainEvent
{
    private \DateTimeImmutable $occurredOn;

    public function __construct(public string $id)
    {
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function occurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
