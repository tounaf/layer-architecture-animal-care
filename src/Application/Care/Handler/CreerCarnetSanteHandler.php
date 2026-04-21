<?php

namespace Application\Care\Handler;

use Application\Care\Command\CreerCareCommand;
use Application\Shared\Bus\EventBusInterface;
use Domain\Care\Entity\Care;
use Domain\Care\Repository\CareRepositoryInterface;

final readonly class CreerCareHandler
{
    public function __construct(
        private CareRepositoryInterface $repository,
        private EventBusInterface $eventBus
    ) {}

    public function __invoke(CreerCareCommand $command): void
    {
        $care = new Care($command->id);
        $this->repository->save($care);
        $this->eventBus->dispatchAll($care->getEvents());
        $care->clearEvents();
    }
}
