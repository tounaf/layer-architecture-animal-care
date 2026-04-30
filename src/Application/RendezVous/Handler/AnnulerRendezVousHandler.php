<?php

namespace Application\RendezVous\Handler;

use Application\RendezVous\Command\AnnulerRendezVousCommand;
use Domain\RendezVous\Repository\RendezVousRepositoryInterface;
use Domain\RendezVous\ValueObject\RendezVousId;
use Application\Shared\Bus\EventBusInterface;

final class AnnulerRendezVousHandler
{
    public function __construct(
        private RendezVousRepositoryInterface $repository,
        private EventBusInterface $eventBus
    ) {
    }

    public function __invoke(AnnulerRendezVousCommand $command): void
    {
        $rendezVous = $this->repository->findById(
            RendezVousId::fromString($command->rendezVousId)
        );

        if (!$rendezVous) {
            throw new \InvalidArgumentException('Rendez-vous non trouvé');
        }

        $rendezVous->annuler($command->motif);

        $this->repository->save($rendezVous);

        foreach ($rendezVous->getEvents() as $event) {
            $this->eventBus->dispatch($event);
        }

        $rendezVous->clearEvents();
    }
}
