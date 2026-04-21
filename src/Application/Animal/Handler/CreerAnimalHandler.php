<?php

namespace Application\Animal\Handler;

use Application\Animal\Command\CreerAnimalCommand;
use Application\Shared\Bus\EventBusInterface;
use Domain\Animal\Entity\Animal;
use Domain\Animal\Repository\AnimalRepositoryInterface;

final readonly class CreerAnimalHandler
{
    public function __construct(
        private AnimalRepositoryInterface $repository,
        private EventBusInterface $eventBus
    ) {}

    public function __invoke(CreerAnimalCommand $command): void
    {
        $animal = new Animal($command->id);
        $this->repository->save($animal);
        $this->eventBus->dispatchAll($animal->getEvents());
        $animal->clearEvents();
    }
}
