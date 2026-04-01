<?php
// src/Domain/RendezVous/Event/RendezVousConfirme.php
namespace Domain\RendezVous\Event;

use Domain\Shared\Event\DomainEvent;

final readonly class RendezVousConfirme implements DomainEvent
{
    private \DateTimeImmutable $occurredOn;

    public function __construct(
        public string $rendezVousId,
        public string $clientId
    ) {
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function occurredOn(): \DateTimeImmutable { return $this->occurredOn; }
}
