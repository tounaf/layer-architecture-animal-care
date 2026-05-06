<?php

namespace Domain\RendezVous\Event;

use Domain\Shared\Event\DomainEvent;
use Domain\RendezVous\ValueObject\RendezVousId;
use Domain\Shared\ValueObject\ClientId;
use Domain\Shared\ValueObject\PrestataireId;

final readonly class RendezVousDemande implements DomainEvent
{
    public function __construct(
        public RendezVousId $rendezVousId,
        public ClientId $clientId,
        public PrestataireId $prestataireId
    ) {}

    public function occurredOn(): \DateTimeImmutable
    {
        return new \DateTimeImmutable();
    }
}
