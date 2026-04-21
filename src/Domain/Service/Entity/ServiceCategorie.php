<?php

namespace Domain\Service\Entity;

use Domain\Shared\Entity\AggregateRoot;
use Domain\Service\ValueObject\ServiceCategorieId;

class ServiceCategorie extends AggregateRoot
{
    public function __construct(
        private ServiceCategorieId $id,
        private string $nom,
        private ?string $description = null,
        private ?string $icone = null,
        private int $ordreAffichage = 0,
        private bool $actif = true
    ) {
    }

    public static function creer(
        string $nom,
        ?string $description = null,
        ?string $icone = null,
        int $ordreAffichage = 0
    ): self {
        return new self(
            ServiceCategorieId::generate(),
            $nom,
            $description,
            $icone,
            $ordreAffichage
        );
    }

    public function getId(): ServiceCategorieId { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getDescription(): ?string { return $this->description; }
    public function getIcone(): ?string { return $this->icone; }
    public function getOrdreAffichage(): int { return $this->ordreAffichage; }
    public function isActif(): bool { return $this->actif; }
}
