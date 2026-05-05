<?php

namespace Application\Medicament\Command;

final readonly class CreerMedicamentCommand
{
    public function __construct(
        public string $nom,
        public string $description,
        public float $prixUnitaire,
        public int $stockInitial
    ) {}
}
