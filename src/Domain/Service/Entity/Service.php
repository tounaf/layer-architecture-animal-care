<?php

namespace Domain\Service\Entity;

use Domain\Shared\Entity\AggregateRoot;
use Domain\Service\ValueObject\ServiceId;

class Service extends AggregateRoot
{
    private Tarif $tarif;

    public function __construct(
        private ServiceId $id,
        private string $nom,
        private string $code,
        private ServiceCategorie $categorie,
        private int $dureeDefaultMinutes = 30,
        private bool $necessiteAcompteDefault = true,
        private ?string $description = null,
        private bool $actif = true
    ) {
        $this->tarif = new Tarif(0);
    }

    public static function creer(
        string $nom,
        string $code,
        ServiceCategorie $categorie,
        int $dureeDefaultMinutes = 30,
        bool $necessiteAcompteDefault = true,
        ?string $description = null
    ): self {
        return new self(
            ServiceId::generate(),
            $nom,
            $code,
            $categorie,
            $dureeDefaultMinutes,
            $necessiteAcompteDefault,
            $description
        );
    }

    public function mettreAJourTarif(float $montant, string $devise = 'EUR'): void
    {
        $this->tarif = new Tarif($montant, $devise);
    }

    public function getId(): ServiceId { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getCode(): string { return $this->code; }
    public function getCategorie(): ServiceCategorie { return $this->categorie; }
    public function getDureeDefaultMinutes(): int { return $this->dureeDefaultMinutes; }
    public function isNecessiteAcompteDefault(): bool { return $this->necessiteAcompteDefault; }
    public function getDescription(): ?string { return $this->description; }
    public function isActif(): bool { return $this->actif; }
    public function getTarif(): Tarif { return $this->tarif; }
}
