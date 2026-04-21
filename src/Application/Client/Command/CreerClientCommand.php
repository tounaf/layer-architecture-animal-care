<?php

namespace Application\Client\Command;

final readonly class CreerClientCommand
{
    public function __construct(public string $id)
    {}
}
