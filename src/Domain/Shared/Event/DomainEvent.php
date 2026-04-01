<?php
// src/Domain/Shared/Event/DomainEvent.php
namespace Domain\Shared\Event;

interface DomainEvent
{
    public function occurredOn(): \DateTimeImmutable;
}
