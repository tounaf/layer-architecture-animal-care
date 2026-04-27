<?php

namespace Domain\Prestation\Entity;

use Domain\Shared\Entity\AggregateRoot;
use Domain\Prestation\ValueObject\PrestationId;
use Domain\RendezVous\ValueObject\RendezVousId;
use Domain\Prestataire\ValueObject\ServiceProposeId;
use Domain\Service\ValueObject\ServiceChampId;
use Domain\Document\ValueObject\DocumentId;

class Prestation extends AggregateRoot
{
    /** @var PrestationValeurChamp[] */
    private array $valeursChamps = [];

    public function __construct(
        private PrestationId $id,
        private RendezVousId $rendezVousId,
        private ServiceProposeId $serviceProposeId,
        private \DateTimeInterface $dateRealisation,
        private float $coutTotal,
        private string $statut = 'realisee'
    ) {
    }

    public static function creer(
        RendezVousId $rendezVousId,
        ServiceProposeId $serviceProposeId,
        \DateTimeInterface $dateRealisation,
        float $coutTotal
    ): self {
        return new self(
            PrestationId::generate(),
            $rendezVousId,
            $serviceProposeId,
            $dateRealisation,
            $coutTotal
        );
    }

    public function ajouterValeurChamp(
        ServiceChampId $champId,
        ?string $valeur,
        string $typeValeur = 'texte',
        ?DocumentId $documentId = null
    ): void {
        $this->valeursChamps[] = new PrestationValeurChamp(
            $this->id,
            $champId,
            $valeur,
            $typeValeur,
            $documentId
        );
    }

    public function getId(): PrestationId { return $this->id; }
    public function getRendezVousId(): RendezVousId { return $this->rendezVousId; }
    public function getServiceProposeId(): ServiceProposeId { return $this->serviceProposeId; }
    public function getDateRealisation(): \DateTimeInterface { return $this->dateRealisation; }
    public function getCoutTotal(): float { return $this->coutTotal; }
    public function getStatut(): string { return $this->statut; }
    public function getValeursChamps(): array { return $this->valeursChamps; }
}
