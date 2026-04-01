<?php

namespace Domain\User\Entity;

use Domain\Shared\Entity\AggregateRoot;
use Domain\User\Event\UserCree;

class User extends AggregateRoot
{
    public function __construct(private string $id)
    {
        $this->recordEvent(new UserCree($this->id));
    }

    public function getId(): string
    {
        return $this->id;
    }
}
