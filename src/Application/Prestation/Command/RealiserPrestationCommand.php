<?php

namespace Application\Prestation\Command;

final class RealiserPrestationCommand
{
    public function __construct(
        public readonly string $rendezVousId,
        public readonly string $serviceProposeId,
        public readonly \DateTimeInterface $dateRealisation,
        public readonly float $coutTotal,
        public readonly array $valeursChamps = [] // format: ['champ_id' => 'valeur' | ['file' => File, 'description' => '...']]
    ) {
    }
}
