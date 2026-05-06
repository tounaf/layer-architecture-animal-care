<?php

namespace Domain\Medicament\Entity;

use Domain\Shared\Entity\AggregateRoot;
use Domain\Medicament\ValueObject\MedicamentId;
use Domain\Medicament\Enum\TypeMouvement;
use Domain\Prestation\ValueObject\PrestationId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Medicament extends AggregateRoot
{
    private \DateTimeImmutable $createdAt;
    private ?\DateTimeImmutable $updatedAt = null;
    private Collection $mouvements;

    public function __construct(
        private MedicamentId $id,
        private string $nom,
        private string $description,
        private float $prixUnitaire,
        private int $stockActuel
    ) {
        $this->createdAt = new \DateTimeImmutable();
        $this->mouvements = new ArrayCollection();
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
    public function getMouvements(): Collection { return $this->mouvements; }
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

    public function prescrire(int $quantite, PrestationId $prestationId): void
    {
        if ($quantite <= 0) {
            throw new \InvalidArgumentException("La quantité prescrite doit être positive.");
        }
        $this->ajusterStock(-$quantite);
        $this->mouvements->add(MouvementStock::creer(
            $this,
            $quantite,
            TypeMouvement::SORTIE,
            $prestationId,
            "Sortie pour prestation {$prestationId}"
        ));
    }

    public function approvisionner(int $quantite, string $commentaire = null): void
    {
        if ($quantite <= 0) {
            throw new \InvalidArgumentException("La quantité d'approvisionnement doit être positive.");
        }
        $this->ajusterStock($quantite);
        $this->mouvements->add(MouvementStock::creer(
            $this,
            $quantite,
            TypeMouvement::ENTREE,
            null,
            $commentaire ?: "Approvisionnement de stock"
        ));
    }
}
