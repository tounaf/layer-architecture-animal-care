<?php

namespace Application\Medicament\Command;

final readonly class UpdateMedicamentCommand
{
    public function __construct(
        public string $id,
        public string $nom,
        public string $description,
        public float $prixUnitaire
    ) {}
}
