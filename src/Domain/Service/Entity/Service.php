<?php

namespace Domain\Service\Entity;

use Domain\Shared\Entity\AggregateRoot;
use Domain\Service\ValueObject\ServiceId;

class Service extends AggregateRoot
{
    /** @var Tarif[] */
    private array $tarifs = [];

    public function __construct(
        private ServiceId $id,
        private string $nom,
        private ?string $description = null,
        private bool $actif = true
    ) {
    }

    public static function creer(string $nom, ?string $description = null): self
    {
        return new self(ServiceId::generate(), $nom, $description);
    }

    public function ajouterTarif(float $montant, string $devise = 'EUR'): void
    {
        $this->tarifs[] = new Tarif($montant, $devise);
    }

    public function getId(): ServiceId { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getTarifs(): array { return $this->tarifs; }
}
