<?php

namespace Application\RendezVous\Command;

class ConfirmerRendezVousCommand
{
    public function __construct(
        public readonly string $rendezVousId
    ) {
    }
}
