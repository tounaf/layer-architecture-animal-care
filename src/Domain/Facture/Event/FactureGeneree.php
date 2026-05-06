<?php

namespace Domain\Facture\Event;

use Domain\Shared\Event\DomainEvent;
use Domain\Facture\ValueObject\FactureId;

final readonly class FactureGeneree implements DomainEvent
{
    public function __construct(
        public FactureId $factureId
    ) {}

    public function occurredOn(): \DateTimeImmutable
    {
        return new \DateTimeImmutable();
    }
}
