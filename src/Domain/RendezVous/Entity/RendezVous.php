<?php
// src/Domain/RendezVous/Entity/RendezVous.php
namespace Domain\RendezVous\Entity;

use Domain\Shared\Entity\AggregateRoot;
use Domain\RendezVous\Event\RendezVousConfirme;

class RendezVous extends AggregateRoot
{
    private string $id;
    private string $statut = 'EN_ATTENTE';

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function confirmer(): void
    {
        if ($this->statut === 'CONFIRME') {
            throw new \DomainException("Le rendez-vous est déjà confirmé.");
        }

        $this->statut = 'CONFIRME';
        $this->recordEvent(new RendezVousConfirme($this->id, "client-123"));
    }

    public function getId(): string { return $this->id; }
    public function getStatut(): string { return $this->statut; }
}
