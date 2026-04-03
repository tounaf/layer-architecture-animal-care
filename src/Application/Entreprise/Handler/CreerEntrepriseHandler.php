<?php

namespace Application\Entreprise\Handler;

use Application\Entreprise\Command\CreerEntrepriseCommand;
use Application\Shared\Bus\EventBusInterface;
use Domain\Entreprise\Entity\Entreprise;
use Domain\Entreprise\Repository\EntrepriseRepositoryInterface;

final readonly class CreerEntrepriseHandler
{
    public function __construct(
        private EntrepriseRepositoryInterface $repository,
        private EventBusInterface $eventBus
    ) {}

    public function __invoke(CreerEntrepriseCommand $command): void
    {
        $entreprise = new Entreprise($command->id);
        $this->repository->save($entreprise);
        $this->eventBus->dispatchAll($entreprise->getEvents());
        $entreprise->clearEvents();
    }
}
