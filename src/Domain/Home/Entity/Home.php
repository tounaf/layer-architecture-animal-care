<?php

namespace Domain\Home\Entity;

use Domain\Shared\Entity\AggregateRoot;
use Domain\Home\Event\HomeCree;

class Home extends AggregateRoot
{
    public function __construct(private string $id)
    {
        $this->recordEvent(new HomeCree($this->id));
    }

    public function getId(): string
    {
        return $this->id;
    }
}
