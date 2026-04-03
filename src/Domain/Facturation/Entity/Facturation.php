<?php

namespace Domain\Facturation\Entity;

use Domain\Shared\Entity\AggregateRoot;
use Domain\Facturation\Event\FacturationCree;

class Facturation extends AggregateRoot
{
    public function __construct(private string $id)
    {
        $this->recordEvent(new FacturationCree($this->id));
    }

    public function getId(): string
    {
        return $this->id;
    }
}
