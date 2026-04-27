<?php

namespace Domain\Document\Entity;

use Domain\Shared\Entity\AggregateRoot;
use Domain\Document\ValueObject\DocumentId;

class Document extends AggregateRoot
{
    public function __construct(
        private DocumentId $id,
        private string $idEntree,
        private string $typeDocument,
        private string $nomFichier,
        private string $cheminUrl,
        private string $typeMime,
        private int $taille,
        private \DateTimeInterface $dateUpload,
        private ?string $description = null
    ) {
    }

    public static function creer(
        string $idEntree,
        string $typeDocument,
        string $nomFichier,
        string $cheminUrl,
        string $typeMime,
        int $taille,
        ?string $description = null
    ): self {
        return new self(
            DocumentId::generate(),
            $idEntree,
            $typeDocument,
            $nomFichier,
            $cheminUrl,
            $typeMime,
            $taille,
            new \DateTimeImmutable(),
            $description
        );
    }

    public function getId(): DocumentId { return $this->id; }
    public function getIdEntree(): string { return $this->idEntree; }
    public function getTypeDocument(): string { return $this->typeDocument; }
    public function getNomFichier(): string { return $this->nomFichier; }
    public function getCheminUrl(): string { return $this->cheminUrl; }
    public function getTypeMime(): string { return $this->typeMime; }
    public function getTaille(): int { return $this->taille; }
    public function getDateUpload(): \DateTimeInterface { return $this->dateUpload; }
    public function getDescription(): ?string { return $this->description; }
}
