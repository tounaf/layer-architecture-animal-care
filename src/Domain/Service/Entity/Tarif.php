<?php

namespace Domain\Service\Entity;

class Tarif
{
    private \DateTimeImmutable $dateApplication;

    public function __construct(
        private float $montant,
        private string $devise = 'EUR'
    ) {
        $this->dateApplication = new \DateTimeImmutable();
    }

    public function getMontant(): float { return $this->montant; }
    public function getDevise(): string { return $this->devise; }
    public function getDateApplication(): \DateTimeImmutable { return $this->dateApplication; }
}
