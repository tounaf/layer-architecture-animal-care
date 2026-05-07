<?php

namespace Application\Medicament\Handler;

use Application\Medicament\Command\CreerMedicamentCommand;
use Application\Shared\Bus\EventBusInterface;
use Domain\Medicament\Entity\Medicament;
use Domain\Medicament\Repository\MedicamentRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreerMedicamentHandler
{
    public function __construct(
        private MedicamentRepositoryInterface $repository,
        private EventBusInterface $eventBus
    ) {}

    public function __invoke(CreerMedicamentCommand $command): void
    {
        $medicament = Medicament::creer(
            $command->nom,
            $command->description,
            $command->prixUnitaire,
            $command->stockInitial
        );
        $this->repository->save($medicament);

        foreach ($medicament->getEvents() as $event) {
            $this->eventBus->dispatch($event);
        }
        $medicament->clearEvents();
    }
}
