<?php

namespace Domain\Prestation\Event;

use Domain\Shared\Event\DomainEvent;
use Domain\Prestation\ValueObject\PrestationId;

final readonly class PrestationRealisee implements DomainEvent
{
    public function __construct(
        public PrestationId $prestationId,
        public float $montantTotal
    ) {}

    public function occurredOn(): \DateTimeImmutable
    {
        return new \DateTimeImmutable();
    }
}
