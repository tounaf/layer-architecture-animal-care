<?php

namespace Domain\RendezVous\Event;

use Domain\Shared\Event\DomainEvent;
use Domain\RendezVous\ValueObject\RendezVousId;

class RendezVousAnnule implements DomainEvent
{
    private \DateTimeImmutable $occurredOn;

    public function __construct(
        private RendezVousId $rendezVousId,
        private string $motif
    ) {
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function occurredOn(): \DateTimeImmutable { return $this->occurredOn; }
    public function getRendezVousId(): RendezVousId { return $this->rendezVousId; }
    public function getMotif(): string { return $this->motif; }
}
