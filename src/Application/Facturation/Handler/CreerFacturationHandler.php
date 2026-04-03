<?php

namespace Application\Facturation\Handler;

use Application\Facturation\Command\CreerFacturationCommand;
use Application\Shared\Bus\EventBusInterface;
use Domain\Facturation\Entity\Facturation;
use Domain\Facturation\Repository\FacturationRepositoryInterface;

final readonly class CreerFacturationHandler
{
    public function __construct(
        private FacturationRepositoryInterface $repository,
        private EventBusInterface $eventBus
    ) {}

    public function __invoke(CreerFacturationCommand $command): void
    {
        $facturation = new Facturation($command->id);
        $this->repository->save($facturation);
        $this->eventBus->dispatchAll($facturation->getEvents());
        $facturation->clearEvents();
    }
}
