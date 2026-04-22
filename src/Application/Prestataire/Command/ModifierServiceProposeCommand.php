<?php

namespace Application\Prestataire\Command;

final class ModifierServiceProposeCommand
{
    public function __construct(
        public readonly string $id,
        public readonly string $serviceId,
        public readonly bool $actif,
        public readonly ?string $description = null
    ) {
    }
}
