<?php

namespace Domain\Care\Event;

use Domain\Shared\Event\DomainEvent;
use Domain\Care\ValueObject\CarnetSanteId;
use Domain\Care\ValueObject\EntreeCarnetId;
use Domain\Shared\ValueObject\AnimalId;
use Domain\Care\Enum\TypeEntree;

class EntreeAjoutee implements DomainEvent
{
    private \DateTimeImmutable $occurredOn;

    public function __construct(
        private CarnetSanteId $carnetId,
        private EntreeCarnetId $entreeId,
        private AnimalId $animalId,
        private TypeEntree $type
    ) {
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function occurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }

    public function getCarnetId(): CarnetSanteId
    {
        return $this->carnetId;
    }

    public function getEntreeId(): EntreeCarnetId
    {
        return $this->entreeId;
    }

    public function getAnimalId(): AnimalId
    {
        return $this->animalId;
    }

    public function getType(): TypeEntree
    {
        return $this->type;
    }
}
