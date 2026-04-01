<?php

namespace Domain\{{ name }}\Entity;

use Domain\Shared\Entity\AggregateRoot;
use Domain\{{ name }}\Event\{{ name }}Cree;

class {{ name }} extends AggregateRoot
{
    public function __construct(private string $id)
    {
        $this->recordEvent(new {{ name }}Cree($this->id));
    }

    public function getId(): string
    {
        return $this->id;
    }
}
