<?php

namespace Domain\Client\Entity;

use Domain\Shared\Entity\AggregateRoot;
use Domain\Shared\ValueObject\ClientId;

class Client extends AggregateRoot
{
    /** @var \Domain\Animal\Entity\Animal[] */
    private array $animals = [];

    public function __construct(
        private ClientId $id,
        private string $nom,
        private string $prenom,
        private string $email,
        private ?string $telephone = null
    ) {
    }

    public static function creer(string $nom, string $prenom, string $email): self
    {
        return new self(ClientId::generate(), $nom, $prenom, $email);
    }

    public function getId(): ClientId { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getPrenom(): string { return $this->prenom; }
    public function getEmail(): string { return $this->email; }
    public function getTelephone(): ?string { return $this->telephone; }
}
