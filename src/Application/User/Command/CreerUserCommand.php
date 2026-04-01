<?php

namespace Application\User\Command;

final readonly class CreerUserCommand
{
    public function __construct(public string $id)
    {}
}
