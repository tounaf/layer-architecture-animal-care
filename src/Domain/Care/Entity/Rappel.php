<?php

namespace Domain\Care\Entity;

class Rappel
{
    public function __construct(
        private int $id,
        private \DateTimeInterface $dateRappel,
        private string $typeRappel,
        private string $message,
        private bool $envoye = false,
        private ?\DateTimeInterface $dateEnvoi = null,
        private bool $actif = true
    ) {
    }

    public function getId(): int { return $this->id; }
    public function getDateRappel(): \DateTimeInterface { return $this->dateRappel; }
    public function getTypeRappel(): string { return $this->typeRappel; }
    public function getMessage(): string { return $this->message; }
    public function isEnvoye(): bool { return $this->envoye; }
}
