<?php

namespace Domain\Entreprise\Entity;

use Domain\Shared\Entity\AggregateRoot;
use Domain\Entreprise\Event\EntrepriseCree;

class Entreprise extends AggregateRoot
{
    public function __construct(private string $id)
    {
        $this->recordEvent(new EntrepriseCree($this->id));
    }

    public function getId(): string
    {
        return $this->id;
    }
}
