<?php

namespace Domain\Service\Entity;

use Domain\Shared\Entity\AggregateRoot;
use Domain\Service\ValueObject\ServiceChampId;

class ServiceChamp extends AggregateRoot
{
    public function __construct(
        private ServiceChampId $id,
        private string $nom,
        private string $typeChamp,
        private ?string $description = null,
        private bool $obligatoireGlobal = false
    ) {
    }

    public static function creer(
        string $nom,
        string $typeChamp,
        ?string $description = null,
        bool $obligatoireGlobal = false
    ): self {
        return new self(
            ServiceChampId::generate(),
            $nom,
            $typeChamp,
            $description,
            $obligatoireGlobal
        );
    }

    public function getId(): ServiceChampId { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getTypeChamp(): string { return $this->typeChamp; }
    public function getDescription(): ?string { return $this->description; }
    public function isObligatoireGlobal(): bool { return $this->obligatoireGlobal; }
}
