<?php

namespace Domain\Client\Entity;

use Domain\Shared\Entity\AggregateRoot;
use Domain\Shared\ValueObject\ClientId;

class Client extends AggregateRoot
{
    public function __construct(
        private ClientId $id,
        private string $nom,
        private string $prenom,
        private string $email,
        private ?string $telephone = null,
        private ?string $ville = null
    ) {
    }

    public static function creer(string $nom, string $prenom, string $email, ?string $telephone = null, ?string $ville = null): self
    {
        return new self(ClientId::generate(), $nom, $prenom, $email, $telephone, $ville);
    }

    public function modifier(string $nom, string $prenom, string $email, ?string $telephone = null, ?string $ville = null): void
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->ville = $ville;
    }

    public function getId(): ClientId { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getPrenom(): string { return $this->prenom; }
    public function getEmail(): string { return $this->email; }
    public function getTelephone(): ?string { return $this->telephone; }
    public function getVille(): ?string { return $this->ville; }
}
