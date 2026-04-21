<?php

namespace Domain\RendezVous\ValueObject;

class TimeRange
{
    private string $fin;

    public function __construct(
        private string $debut,
        private int $dureeMinutes
    ) {
        if (!preg_match('/^([0-1][0-9]|2[0-3]):[0-5][0-9]$/', $debut)) {
            throw new \DomainException('Format heure invalide');
        }
        
        $this->fin = date('H:i', strtotime($debut) + $dureeMinutes * 60);
    }

    public function getDebut(): string { return $this->debut; }
    public function getFin(): string { return $this->fin; }
    public function getDuree(): int { return $this->dureeMinutes; }

    public function chevauche(TimeRange $autre): bool
    {
        return !($this->fin <= $autre->debut || $this->debut >= $autre->fin);
    }
}
