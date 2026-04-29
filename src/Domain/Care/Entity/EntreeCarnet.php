<?php

namespace Domain\Care\Entity;

use Domain\Care\ValueObject\EntreeCarnetId;
use Domain\Care\Enum\TypeEntree;
use Domain\Shared\ValueObject\PrestataireId;

class EntreeCarnet
{
    private \DateTimeImmutable $dateEntree;
    private \DateTimeImmutable $dateModification;

    private ?CarnetSante $carnetSante = null;

    public function __construct(
        private EntreeCarnetId $id,
        private TypeEntree $type,
        private string $titre,
        private string $description,
        private PrestataireId $etabliPar,
        private bool $visibleProprietaire = true,
        private ?\DateTimeInterface $dateRappel = null,
        private string $donneesStructurees = ''
    ) {
        $this->dateEntree = new \DateTimeImmutable();
        $this->dateModification = new \DateTimeImmutable();
    }

    public function setCarnetSante(CarnetSante $carnetSante): void
    {
        $this->carnetSante = $carnetSante;
    }

    public function getId(): EntreeCarnetId
    {
        return $this->id;
    }

    public function getType(): TypeEntree
    {
        return $this->type;
    }

    public function getTitre(): string
    {
        return $this->titre;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getEtabliPar(): PrestataireId
    {
        return $this->etabliPar;
    }

    public function isVisibleProprietaire(): bool
    {
        return $this->visibleProprietaire;
    }

    public function getDateRappel(): ?\DateTimeInterface
    {
        return $this->dateRappel;
    }

    public function getDonneesStructurees(): string
    {
        return $this->donneesStructurees;
    }
}
