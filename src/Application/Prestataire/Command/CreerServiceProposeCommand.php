<?php

namespace Application\Prestataire\Command;

final class CreerServiceProposeCommand
{
    public function __construct(
        public readonly string $prestataireId,
        public readonly string $serviceId,
        public readonly bool $actif = true,
        public readonly ?string $description = null
    ) {
    }
}
