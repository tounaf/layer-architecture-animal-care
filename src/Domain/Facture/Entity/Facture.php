<?php

namespace Domain\Facture\Entity;

use Domain\Shared\Entity\AggregateRoot;
use Domain\Facture\ValueObject\FactureId;
use Domain\Prestation\ValueObject\PrestationId;
use Domain\Facture\Enum\StatutFacture;

class Facture extends AggregateRoot
{
    private \DateTimeImmutable $createdAt;
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct(
        private FactureId $id,
        private PrestationId $prestationId,
        private string $numeroFacture,
        private float $montantHT,
        private float $tva,
        private float $montantTTC,
        private StatutFacture $statut = StatutFacture::EN_ATTENTE
    ) {
        $this->createdAt = new \DateTimeImmutable();
    }

    public static function genererDepuisPrestation(
        PrestationId $prestationId,
        float $montantTotal
    ): self {
        $tvaRate = 0.20; // 20% par défaut
        $montantHT = $montantTotal / (1 + $tvaRate);
        $tva = $montantTotal - $montantHT;

        return new self(
            FactureId::generate(),
            $prestationId,
            'FACT-' . date('Ymd') . '-' . substr(bin2hex(random_bytes(4)), 0, 4),
            $montantHT,
            $tva,
            $montantTotal,
            StatutFacture::EN_ATTENTE
        );
    }

    public function getId(): FactureId { return $this->id; }
    public function getPrestationId(): PrestationId { return $this->prestationId; }
    public function getNumeroFacture(): string { return $this->numeroFacture; }
    public function getMontantHT(): float { return $this->montantHT; }
    public function getTva(): float { return $this->tva; }
    public function getMontantTTC(): float { return $this->montantTTC; }
    public function getStatut(): StatutFacture { return $this->statut; }
    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
    public function getUpdatedAt(): ?\DateTimeImmutable { return $this->updatedAt; }

    public function marquerCommePayee(): void
    {
        $this->statut = StatutFacture::PAYEE;
        $this->updatedAt = new \DateTimeImmutable();
    }
}
