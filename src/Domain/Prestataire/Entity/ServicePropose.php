<?php

namespace Domain\Prestataire\Entity;

use Domain\Shared\Entity\AggregateRoot;
use Domain\Prestataire\ValueObject\ServiceProposeId;
use Domain\Shared\ValueObject\PrestataireId;
use Domain\Service\ValueObject\ServiceId;

class ServicePropose extends AggregateRoot
{
    public function __construct(
        private ServiceProposeId $id,
        private PrestataireId $prestataireId,
        private ServiceId $serviceId,
        private bool $actif = true,
        private ?string $description = null
    ) {
    }

    public static function creer(
        PrestataireId $prestataireId,
        ServiceId $serviceId,
        bool $actif = true,
        ?string $description = null
    ): self {
        return new self(
            ServiceProposeId::generate(),
            $prestataireId,
            $serviceId,
            $actif,
            $description
        );
    }

    public function modifier(
        ServiceId $serviceId,
        bool $actif,
        ?string $description
    ): void {
        $this->serviceId = $serviceId;
        $this->actif = $actif;
        $this->description = $description;
    }

    public function getId(): ServiceProposeId { return $this->id; }
    public function getPrestataireId(): PrestataireId { return $this->prestataireId; }
    public function getServiceId(): ServiceId { return $this->serviceId; }
    public function isActif(): bool { return $this->actif; }
    public function getDescription(): ?string { return $this->description; }
}
