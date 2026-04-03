<?php

namespace Application\Entreprise\Command;

final readonly class CreerEntrepriseCommand
{
    public function __construct(public string $id)
    {}
}
