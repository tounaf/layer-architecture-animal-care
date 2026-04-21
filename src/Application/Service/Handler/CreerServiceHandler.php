<?php

namespace Application\Service\Handler;

use Application\Service\Command\CreerServiceCommand;
use Application\Shared\Bus\EventBusInterface;
use Domain\Service\Entity\Service;
use Domain\Service\Repository\ServiceRepositoryInterface;

final readonly class CreerServiceHandler
{
    public function __construct(
        private ServiceRepositoryInterface $repository,
        private EventBusInterface $eventBus
    ) {}

    public function __invoke(CreerServiceCommand $command): void
    {
        $service = new Service($command->id);
        $this->repository->save($service);
        $this->eventBus->dispatchAll($service->getEvents());
        $service->clearEvents();
    }
}
