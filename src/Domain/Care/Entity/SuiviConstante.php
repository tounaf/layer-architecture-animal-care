<?php

namespace Domain\Care\Entity;

class SuiviConstante
{
    public function __construct(
        private int $id,
        private \DateTimeInterface $dateMesure,
        private string $typeMesure,
        private float $valeur,
        private string $unite,
        private ?string $remarques = null
    ) {
    }

    public function getId(): int { return $this->id; }
    public function getDateMesure(): \DateTimeInterface { return $this->dateMesure; }
    public function getTypeMesure(): string { return $this->typeMesure; }
    public function getValeur(): float { return $this->valeur; }
    public function getUnite(): string { return $this->unite; }
    public function getRemarques(): ?string { return $this->remarques; }
}
