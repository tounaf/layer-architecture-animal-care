<?php

namespace Domain\Medicament\Entity;

use Domain\Shared\Entity\AggregateRoot;
use Domain\Medicament\ValueObject\MedicamentId;

class Medicament extends AggregateRoot
{
    private \DateTimeImmutable $createdAt;
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct(
        private MedicamentId $id,
        private string $nom,
        private string $description,
        private float $prixUnitaire,
        private int $stockActuel
    ) {
        $this->createdAt = new \DateTimeImmutable();
    }

    public static function creer(
        string $nom,
        string $description,
        float $prixUnitaire,
        int $stockInitial
    ): self {
        return new self(
            MedicamentId::generate(),
            $nom,
            $description,
            $prixUnitaire,
            $stockInitial
        );
    }

    public function getId(): MedicamentId { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getDescription(): string { return $this->description; }
    public function getPrixUnitaire(): float { return $this->prixUnitaire; }
    public function getStockActuel(): int { return $this->stockActuel; }
    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
    public function getUpdatedAt(): ?\DateTimeImmutable { return $this->updatedAt; }

    public function updateInformation(string $nom, string $description, float $prixUnitaire): void
    {
        $this->nom = $nom;
        $this->description = $description;
        $this->prixUnitaire = $prixUnitaire;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function ajusterStock(int $quantite): void
    {
        $this->stockActuel += $quantite;
        $this->updatedAt = new \DateTimeImmutable();

        if ($this->stockActuel < 0) {
            throw new \DomainException("Le stock du médicament {$this->nom} ne peut pas être négatif.");
        }
    }

    public function prescrire(int $quantite): void
    {
        if ($quantite <= 0) {
            throw new \InvalidArgumentException("La quantité prescrite doit être positive.");
        }
        $this->ajusterStock(-$quantite);
        // On pourrait enregistrer un événement ici si besoin
    }
}
