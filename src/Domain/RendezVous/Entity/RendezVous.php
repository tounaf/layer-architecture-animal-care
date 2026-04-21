<?php

namespace Domain\RendezVous\Entity;

use Domain\Shared\Entity\AggregateRoot;
use Domain\RendezVous\ValueObject\RendezVousId;
use Domain\Shared\ValueObject\ClientId;
use Domain\Shared\ValueObject\AnimalId;
use Domain\Shared\ValueObject\PrestataireId;
use Domain\RendezVous\ValueObject\TimeRange;
use Domain\RendezVous\Enum\StatutRendezVous;
use Domain\RendezVous\Event\RendezVousConfirme;
use Domain\RendezVous\Event\RendezVousAnnule;

class RendezVous extends AggregateRoot
{
    private function __construct(
        private RendezVousId $id,
        private ClientId $clientId,
        private AnimalId $animalId,
        private PrestataireId $prestataireId,
        private TimeRange $plageHoraire,
        private StatutRendezVous $statut,
        private ?string $commentaires = null
    ) {
    }

    public static function creer(
        ClientId $clientId,
        AnimalId $animalId,
        PrestataireId $prestataireId,
        \DateTimeInterface $dateRdv,
        string $heureDebut,
        int $dureeMinutes,
        ?string $commentaires = null
    ): self {
        // Business logic for creation
        if ($heureDebut < '08:00' || $heureDebut > '20:00') {
            throw new \DomainException('Les rendez-vous sont possibles de 8h à 20h');
        }

        $plageHoraire = new TimeRange($heureDebut, $dureeMinutes);

        return new self(
            RendezVousId::generate(),
            $clientId,
            $animalId,
            $prestataireId,
            $plageHoraire,
            StatutRendezVous::EN_ATTENTE,
            $commentaires
        );
    }

    public function confirmer(): void
    {
        if ($this->statut !== StatutRendezVous::EN_ATTENTE) {
            throw new \DomainException('Seul un rendez-vous en attente peut être confirmé');
        }

        $this->statut = StatutRendezVous::CONFIRME;

        $this->recordEvent(new RendezVousConfirme(
            $this->id,
            $this->clientId,
            $this->prestataireId
        ));
    }

    public function annuler(string $motif): void
    {
        if ($this->statut === StatutRendezVous::ANNULE) {
            throw new \DomainException('Déjà annulé');
        }

        $this->statut = StatutRendezVous::ANNULE;

        $this->recordEvent(new RendezVousAnnule(
            $this->id,
            $motif
        ));
    }

    public function getId(): RendezVousId { return $this->id; }
    public function getClientId(): ClientId { return $this->clientId; }
    public function getAnimalId(): AnimalId { return $this->animalId; }
    public function getPrestataireId(): PrestataireId { return $this->prestataireId; }
    public function getStatut(): StatutRendezVous { return $this->statut; }
}
