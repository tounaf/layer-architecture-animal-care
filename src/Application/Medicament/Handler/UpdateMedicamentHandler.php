<?php

namespace Application\Medicament\Handler;

use Application\Medicament\Command\UpdateMedicamentCommand;
use Domain\Medicament\Repository\MedicamentRepositoryInterface;
use Domain\Medicament\ValueObject\MedicamentId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class UpdateMedicamentHandler
{
    public function __construct(
        private MedicamentRepositoryInterface $repository
    ) {}

    public function __invoke(UpdateMedicamentCommand $command): void
    {
        $medicament = $this->repository->findById(MedicamentId::fromString($command->id));
        if (!$medicament) {
            throw new \InvalidArgumentException("Médicament non trouvé");
        }

        $medicament->updateInformation($command->nom, $command->description, $command->prixUnitaire);
        $this->repository->save($medicament);
    }
}
