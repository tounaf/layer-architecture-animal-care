<?php

namespace Application\Facture\Command;

final readonly class CreerFactureCommand
{
    public function __construct(public string $id)
    {}
}
