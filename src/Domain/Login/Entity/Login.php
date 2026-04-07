<?php

namespace Domain\Login\Entity;

use Domain\Shared\Entity\AggregateRoot;
use Domain\Login\Event\LoginCree;

class Login extends AggregateRoot
{
    public function __construct(private string $id)
    {
        $this->recordEvent(new LoginCree($this->id));
    }

    public function getId(): string
    {
        return $this->id;
    }
}
