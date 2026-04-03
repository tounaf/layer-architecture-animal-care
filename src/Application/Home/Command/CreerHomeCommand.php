<?php

namespace Application\Home\Command;

final readonly class CreerHomeCommand
{
    public function __construct(public string $id)
    {}
}
