<?php
// src/Application/RendezVous/Command/ConfirmerRendezVousCommand.php
namespace Application\RendezVous\Command;

final readonly class ConfirmerRendezVousCommand
{
    public function __construct(
        public string $id
    ) {}
}
