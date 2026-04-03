<?php

namespace Application\Facturation\Command;

final readonly class CreerFacturationCommand
{
    public function __construct(public string $id)
    {}
}
