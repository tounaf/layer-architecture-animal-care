<?php

namespace Application\Animal\Command;

final readonly class CreerAnimalCommand
{
    public function __construct(public string $id)
    {}
}
