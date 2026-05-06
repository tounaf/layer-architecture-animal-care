<?php

namespace Domain\Medicament\Entity;

use Domain\Medicament\ValueObject\MedicamentId;
use Domain\Medicament\Enum\TypeMouvement;
use Domain\Prestation\ValueObject\PrestationId;

class MouvementStock
{
    private \DateTimeImmutable $dateMouvement;

    public function __construct(
        private string $id,
        private Medicament $medicament,
        private int $quantite,
        private TypeMouvement $type,
        private ?PrestationId $prestationId = null,
        private ?string $commentaire = null
    ) {
        $this->dateMouvement = new \DateTimeImmutable();
    }

    public static function creer(
        Medicament $medicament,
        int $quantite,
        TypeMouvement $type,
        ?PrestationId $prestationId = null,
        ?string $commentaire = null
    ): self {
        return new self(
            bin2hex(random_bytes(16)),
            $medicament,
            $quantite,
            $type,
            $prestationId,
            $commentaire
        );
    }

    public function getId(): string { return $this->id; }
    public function getQuantite(): int { return $this->quantite; }
    public function getType(): TypeMouvement { return $this->type; }
    public function getPrestationId(): ?PrestationId { return $this->prestationId; }
    public function getCommentaire(): ?string { return $this->commentaire; }
    public function getDateMouvement(): \DateTimeImmutable { return $this->dateMouvement; }
}
