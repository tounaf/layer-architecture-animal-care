<?php

namespace Domain\Care\Entity;

class Alerte
{
    public function __construct(
        private int $id,
        private string $typeAlerte,
        private string $titre,
        private string $description,
        private string $severite,
        private bool $active = true,
        private ?\DateTimeInterface $dateDebut = null,
        private ?\DateTimeInterface $dateFin = null
    ) {
    }

    public function getId(): int { return $this->id; }
    public function getTypeAlerte(): string { return $this->typeAlerte; }
    public function getTitre(): string { return $this->titre; }
    public function getDescription(): string { return $this->description; }
    public function getSeverite(): string { return $this->severite; }
    public function isActive(): bool { return $this->active; }
}
