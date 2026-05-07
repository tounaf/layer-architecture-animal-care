<?php

namespace Domain\Prestataire\Entity;

use Domain\Shared\Entity\AggregateRoot;
use Domain\Shared\ValueObject\PrestataireId;

class Prestataire extends AggregateRoot
{
    public function __construct(
        private PrestataireId $id,
        private string $nomStructure,
        private string $nomContact,
        private string $prenomContact,
        private string $profession,
        private string $email = '',
        private bool $valideParAdmin = false
    ) {
    }

    public static function creer(
        string $nomStructure,
        string $nomContact,
        string $prenomContact,
        string $profession,
        string $email,
        bool $valideParAdmin = false
    ): self {
        return new self(
            PrestataireId::generate(),
            $nomStructure,
            $nomContact,
            $prenomContact,
            $profession,
            $email,
            $valideParAdmin
        );
    }

    public function modifier(
        string $nomStructure,
        string $nomContact,
        string $prenomContact,
        string $profession,
        string $email,
        bool $valideParAdmin
    ): void {
        $this->nomStructure = $nomStructure;
        $this->nomContact = $nomContact;
        $this->prenomContact = $prenomContact;
        $this->profession = $profession;
        $this->email = $email;
        $this->valideParAdmin = $valideParAdmin;
    }

    public function getId(): PrestataireId { return $this->id; }
    public function getNomStructure(): string { return $this->nomStructure; }
    public function getNomContact(): string { return $this->nomContact; }
    public function getPrenomContact(): string { return $this->prenomContact; }
    public function getProfession(): string { return $this->profession; }
    public function getEmail(): string { return $this->email; }
    public function isValideParAdmin(): bool { return $this->valideParAdmin; }
}
