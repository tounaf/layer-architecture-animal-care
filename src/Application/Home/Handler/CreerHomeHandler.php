<?php

namespace Application\Home\Handler;

use Application\Home\Command\CreerHomeCommand;
use Application\Shared\Bus\EventBusInterface;
use Domain\Home\Entity\Home;
use Domain\Home\Repository\HomeRepositoryInterface;

final readonly class CreerHomeHandler
{
    public function __construct(
        private HomeRepositoryInterface $repository,
        private EventBusInterface $eventBus
    ) {}

    public function __invoke(CreerHomeCommand $command): void
    {
        $home = new Home($command->id);
        $this->repository->save($home);
        $this->eventBus->dispatchAll($home->getEvents());
        $home->clearEvents();
    }
}
