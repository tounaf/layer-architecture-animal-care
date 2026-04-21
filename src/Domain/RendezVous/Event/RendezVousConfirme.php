<?php

namespace Domain\RendezVous\Event;

use Domain\Shared\Event\DomainEvent;
use Domain\RendezVous\ValueObject\RendezVousId;
use Domain\Shared\ValueObject\ClientId;
use Domain\Shared\ValueObject\PrestataireId;

class RendezVousConfirme implements DomainEvent
{
    private \DateTimeImmutable $occurredOn;

    public function __construct(
        private RendezVousId $rendezVousId,
        private ClientId $clientId,
        private PrestataireId $prestataireId
    ) {
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function occurredOn(): \DateTimeImmutable { return $this->occurredOn; }
    public function getRendezVousId(): RendezVousId { return $this->rendezVousId; }
    public function getClientId(): ClientId { return $this->clientId; }
    public function getPrestataireId(): PrestataireId { return $this->prestataireId; }
}
