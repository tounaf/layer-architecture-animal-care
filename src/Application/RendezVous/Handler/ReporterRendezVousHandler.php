<?php

namespace Application\RendezVous\Handler;

use Application\RendezVous\Command\ReporterRendezVousCommand;
use Domain\RendezVous\Repository\RendezVousRepositoryInterface;
use Domain\RendezVous\ValueObject\RendezVousId;
use Application\Shared\Bus\EventBusInterface;

final class ReporterRendezVousHandler
{
    public function __construct(
        private RendezVousRepositoryInterface $repository,
        private EventBusInterface $eventBus
    ) {
    }

    public function __invoke(ReporterRendezVousCommand $command): void
    {
        $rendezVous = $this->repository->findById(
            RendezVousId::fromString($command->rendezVousId)
        );

        if (!$rendezVous) {
            throw new \InvalidArgumentException('Rendez-vous non trouvé');
        }

        $rendezVous->reporter($command->nouvelleDate, $command->nouvelleHeure);

        $this->repository->save($rendezVous);

        foreach ($rendezVous->getEvents() as $event) {
            $this->eventBus->dispatch($event);
        }

        $rendezVous->clearEvents();
    }
}
