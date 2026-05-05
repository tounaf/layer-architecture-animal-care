<?php

namespace Application\Medicament\Command;

final readonly class DeleteMedicamentCommand
{
    public function __construct(
        public string $id
    ) {}
}
