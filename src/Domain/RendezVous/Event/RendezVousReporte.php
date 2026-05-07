<?php

namespace Domain\RendezVous\Event;

use Domain\Shared\Event\DomainEvent;
use Domain\RendezVous\ValueObject\RendezVousId;

final readonly class RendezVousReporte implements DomainEvent
{
    public function __construct(
        public RendezVousId $rendezVousId
    ) {}

    public function occurredOn(): \DateTimeImmutable
    {
        return new \DateTimeImmutable();
    }
}
