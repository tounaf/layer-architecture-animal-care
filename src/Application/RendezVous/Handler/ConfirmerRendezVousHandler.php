<?php
// src/Application/RendezVous/Handler/ConfirmerRendezVousHandler.php
namespace Application\RendezVous\Handler;

use Application\RendezVous\Command\ConfirmerRendezVousCommand;
use Application\Shared\Bus\EventBusInterface;
use Domain\RendezVous\Repository\RendezVousRepositoryInterface;

final readonly class ConfirmerRendezVousHandler
{
    public function __construct(
        private RendezVousRepositoryInterface $repository,
        private EventBusInterface $eventBus
    ) {}

    public function __invoke(ConfirmerRendezVousCommand $command): void
    {
        $rendezVous = $this->repository->getById($command->id);

        if (!$rendezVous) {
            throw new \RuntimeException("Rendez-vous non trouvé.");
        }

        $rendezVous->confirmer();
        $this->repository->save($rendezVous);

        $this->eventBus->dispatchAll($rendezVous->getEvents());
        $rendezVous->clearEvents();
    }
}
