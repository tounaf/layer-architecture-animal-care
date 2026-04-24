<?php

namespace Application\Animal\Handler;

use Application\Animal\Command\CreerAnimalCommand;
use Domain\Animal\Entity\Animal;
use Domain\Animal\Repository\AnimalRepositoryInterface;
use Domain\Shared\ValueObject\ClientId;
use Application\Shared\Bus\EventBusInterface;

final class CreerAnimalHandler
{
    public function __construct(
        private AnimalRepositoryInterface $repository,
        private EventBusInterface $eventBus
    ) {
    }

    public function __invoke(CreerAnimalCommand $command): void
    {
        $animal = Animal::creer(
            $command->nom,
            $command->espece,
            $command->race,
            $command->dateNaissance,
            ClientId::fromString($command->proprietaireId),
            $command->poids
        );

        $this->repository->save($animal);

        foreach ($animal->getEvents() as $event) {
            $this->eventBus->dispatch($event);
        }
        $animal->clearEvents();
    }
}
