<?php

namespace Application\Client\Handler;

use Application\Client\Command\CreerClientCommand;
use Application\Shared\Bus\EventBusInterface;
use Domain\Client\Entity\Client;
use Domain\Client\Repository\ClientRepositoryInterface;

final readonly class CreerClientHandler
{
    public function __construct(
        private ClientRepositoryInterface $repository,
        private EventBusInterface $eventBus
    ) {}

    public function __invoke(CreerClientCommand $command): void
    {
        $client = new Client($command->id);
        $this->repository->save($client);
        $this->eventBus->dispatchAll($client->getEvents());
        $client->clearEvents();
    }
}
