<?php

namespace Application\Medicament\Handler;

use Application\Medicament\Command\DeleteMedicamentCommand;
use Domain\Medicament\Repository\MedicamentRepositoryInterface;
use Domain\Medicament\ValueObject\MedicamentId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class DeleteMedicamentHandler
{
    public function __construct(
        private MedicamentRepositoryInterface $repository
    ) {}

    public function __invoke(DeleteMedicamentCommand $command): void
    {
        $medicament = $this->repository->findById(MedicamentId::fromString($command->id));
        if ($medicament) {
            $this->repository->delete($medicament);
        }
    }
}
