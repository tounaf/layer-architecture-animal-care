<?php

namespace Domain\Animal\Entity;

use Domain\Shared\Entity\AggregateRoot;
use Domain\Shared\ValueObject\AnimalId;
use Domain\Shared\ValueObject\ClientId;
use Domain\Animal\Event\AnimalCree;

class Animal extends AggregateRoot
{
    public function __construct(
        private AnimalId $id,
        private string $nom,
        private ?string $espece = null,
        private ?string $race = null,
        private ?\DateTimeInterface $dateNaissance = null,
        private ?ClientId $proprietaireId = null,
        private ?float $poids = null
    ) {
    }

    public static function creer(
        string $nom,
        ?string $espece = null,
        ?string $race = null,
        ?\DateTimeInterface $dateNaissance = null,
        ?ClientId $proprietaireId = null,
        ?float $poids = null
    ): self {
        $animal = new self(AnimalId::generate(), $nom, $espece, $race, $dateNaissance, $proprietaireId, $poids);
        $animal->recordEvent(new AnimalCree($animal->id));

        return $animal;
    }

    public function modifier(
        string $nom,
        ?string $espece = null,
        ?string $race = null,
        ?\DateTimeInterface $dateNaissance = null,
        ?ClientId $proprietaireId = null,
        ?float $poids = null
    ): void {
        $this->nom = $nom;
        $this->espece = $espece;
        $this->race = $race;
        $this->dateNaissance = $dateNaissance;
        $this->proprietaireId = $proprietaireId;
        $this->poids = $poids;
    }

    public function getId(): AnimalId { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getEspece(): ?string { return $this->espece; }
    public function getRace(): ?string { return $this->race; }
    public function getDateNaissance(): ?\DateTimeInterface { return $this->dateNaissance; }
    public function getProprietaireId(): ?ClientId { return $this->proprietaireId; }
    public function getPoids(): ?float { return $this->poids; }
}
