<?php

namespace Domain\Animal\Entity;

use Domain\Shared\Entity\AggregateRoot;
use Domain\Shared\ValueObject\AnimalId;
use Domain\Shared\ValueObject\ClientId;

class Animal extends AggregateRoot
{
    public function __construct(
        private AnimalId $id,
        private string $nom,
        private ?string $espece = null,
        private ?string $race = null,
        private ?\DateTimeInterface $dateNaissance = null,
        private ?ClientId $proprietaireId = null
    ) {
    }

    public static function creer(string $nom, ?string $espece = null, ?ClientId $proprietaireId = null): self
    {
        return new self(AnimalId::generate(), $nom, $espece, null, null, $proprietaireId);
    }

    public function getId(): AnimalId { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getEspece(): ?string { return $this->espece; }
    public function getRace(): ?string { return $this->race; }
    public function getDateNaissance(): ?\DateTimeInterface { return $this->dateNaissance; }
    public function getProprietaireId(): ?ClientId { return $this->proprietaireId; }
}
